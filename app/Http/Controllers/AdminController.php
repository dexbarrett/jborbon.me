<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Post;
use DexBarrett\PostType;
use DexBarrett\PostStatus;
use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use Illuminate\Support\Facades\DB;
use DexBarrett\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index($postTypeName = 'post', $postStatusName = 'published')
    {
        $postType = PostType::where('name', $postTypeName)->firstOrFail();
        $postStatus = PostStatus::where('name', $postStatusName)->firstOrFail();
        $postStatusPublished = PostStatus::where('name', 'published')->firstOrFail();
        $postStatusDraft = PostStatus::where('name', 'draft')->firstOrFail();

        $postTypePublishedCount = DB::select(
            'select count(id) as count from posts where user_id = ? 
            and post_type_id = ? and post_status_id = ?',
            [auth()->user()->id, $postType->id, $postStatusPublished->id]
        )[0]->count;

        $postTypeDraftCount = DB::select(
            'select count(id) as count from posts where user_id = ? and
             post_type_id = ? and post_status_id = ?',
            [auth()->user()->id, $postType->id, $postStatusDraft->id]
        )[0]->count;

        $posts = Post::with('type')
        ->with(['tags' => function($query) {
            $query->orderBy('name');
        }])
        ->where('post_type_id', $postType->id)
        ->where('post_status_id', $postStatus->id)
        ->where('user_id', auth()->user()->id)
        ->select(['id', 'title', 'slug'])
        ->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts')
        ->with(compact(
            'posts', 'postType', 'postStatus', 'postTypePublishedCount',
            'postTypeDraftCount', 'postStatusPublished', 'postStatusDraft')
        );

    }
}
