<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Http\Controllers\Controller;
use DexBarrett\Http\Requests;
use DexBarrett\Post;
use DexBarrett\PostStatus;
use DexBarrett\PostType;
use DexBarrett\Services\Imgur\Imgur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AdminController extends Controller
{
    public function index($postTypeName = 'post', $postStatusName = 'published')
    {
        $postType = PostType::where('name', $postTypeName)->firstOrFail();
        $postStatusPublished = PostStatus::where('name', 'published')->firstOrFail();
        $postStatusDraft = PostStatus::where('name', 'draft')->firstOrFail();

        $postStatus = null;
        $postStatusDesc = 'papelera';

        if ($postStatusName != 'trashed') {
            $postStatus = PostStatus::where('name', $postStatusName)->firstOrFail();
            $postStatusDesc = $postStatus->desc;
        }

        $postTypePublishedCount = DB::select(
            'select count(id) as count from posts where user_id = ? 
            and post_type_id = ? and post_status_id = ? and deleted_at is null',
            [auth()->user()->id, $postType->id, $postStatusPublished->id]
        )[0]->count;

        $postTypeDraftCount = DB::select(
            'select count(id) as count from posts where user_id = ? and
             post_type_id = ? and post_status_id = ? and deleted_at is null',
            [auth()->user()->id, $postType->id, $postStatusDraft->id]
        )[0]->count;

        $trashedPostsCount = DB::select(
            'select count(id) as count from posts where user_id = ?
            and post_type_id = ? 
            and deleted_at is not null',
            [auth()->user()->id, $postType->id]
        )[0]->count;

        $posts = Post::with('type')
        ->with(['tags' => function($query) {
            $query->orderBy('name');
        }])
        ->with('type')
        ->where('post_type_id', $postType->id);

        if ($postStatus == null) {
            $posts->onlyTrashed();
        } else {
            $posts->where('post_status_id', $postStatus->id);
        }

        // need to reassign $posts variable for paginator to work when cutting the method chaining
        $posts = $posts->where('user_id', auth()->user()->id)
        ->select(['id', 'title', 'slug', 'post_type_id', 'uuid'])
        ->latest('created_at')
        ->paginate(10);
        

        return view('admin.posts')
        ->with(compact(
            'posts', 'postType', 'postStatusName', 'postTypePublishedCount',
            'postTypeDraftCount', 'postStatusPublished', 'postStatusDraft',
            'postStatusDesc', 'trashedPostsCount')
        );

    }

    public function editProfile() {
        return view('admin.profile')
            ->with(
                'user', auth()->user()
            );
    }

    public function saveProfile(Request $request)
    {
        $formData = $request->all();

        $validator = Validator::make($formData, [
            'username' => 'required|alpha_num',
            'email' => 'required|email',
            'password' => 'confirmed|min:8'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }

        
        $user = auth()->user();

        $user->username = $formData['username'];
        $user->email = $formData['email'];

        if (trim($formData['password'])) {
            $user->password = trim($formData['password']);
        }

        $user->save();

        return redirect()
            ->back()
            ->with('message', 'Perfil actualizado correctamente');

    }

    public function showSettings(Imgur $imgur)
    {
        return view('admin.settings')
            ->with(compact('imgur'));
    }

    public function imgurAuth(Request $request, Imgur $imgur)
    {
        $imgur->requestAccessToken($request->input('code'));
        
        return redirect()->action('AdminController@showSettings');
    }
}
