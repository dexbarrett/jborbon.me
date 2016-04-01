<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Post;
use DexBarrett\SavePost;
use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use DexBarrett\Http\Controllers\Controller;

class PostController extends Controller
{

    public function create()
    {
        return view('admin.create-post');
    }

    public function store(SavePost $savePost)
    {
        
        if (! $savePost->create(request()->all())) {
            return redirect()->back()
                ->withInput()
                ->withErrors($savePost->errors());
        }

        return redirect()->back()
            ->with('message', 'El post se ha creado correctamente');
    }

    public function edit($postID)
    {
        $post = Post::findOrFail($postID);
        $selectedTags = $post->tags->pluck('id')->toArray();

        return view('admin.edit-post')
            ->with(compact('post', 'selectedTags'));

    }

    public function update(SavePost $savePost, $postID)
    {

        $post = Post::findOrFail($postID);

        if (! $savePost->update($post, request()->all())) {
            return redirect()->back()
                ->withInput()
                ->withErrors($savePost->errors());
        }

        return redirect()->back()
            ->with('message', 'El post se ha actualizado correctamente');
    }       
}
