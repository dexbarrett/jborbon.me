<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Post;
use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use DexBarrett\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $posts = Post::with('type')
        ->with(['tags' => function($query) {
            $query->orderBy('name');
        }])
        ->where('post_type_id', 2)
        ->where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts')->with(compact('posts'));
    }
}
