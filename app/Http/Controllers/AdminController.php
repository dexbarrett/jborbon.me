<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Post;
use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use Illuminate\Support\Facades\DB;
use DexBarrett\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index($postType = 2, $postStatus = 2)
    {
        $postTypePublished = DB::select(
            'select count(id) as count from posts where user_id = ? and post_type_id = ? and post_status_id = 2',
            [auth()->user()->id, $postType]
        );

        $postTypeDraft = DB::select(
            'select count(id) as count from posts where user_id = ? and post_type_id = ? and post_status_id = 1',
            [auth()->user()->id, $postType]
        );

        $posts = Post::with('type')
        ->with(['tags' => function($query) {
            $query->orderBy('name');
        }])
        ->where('post_type_id', $postType)
        ->where('post_status_id', $postStatus)
        ->where('user_id', auth()->user()->id)
        ->select(['id', 'title', 'slug'])
        ->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts')
        ->with(compact('posts', 'postType', 'postTypePublished', 'postTypeDraft'));
    }
}
