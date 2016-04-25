<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Tag;
use DexBarrett\Post;
use DexBarrett\PostType;
use DexBarrett\SavePost;
use DexBarrett\PostStatus;
use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use DexBarrett\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->select(['id', 'title', 'slug', 'created_at'])
            ->paginate(10);

        return view('front.blog.home')
            ->with(compact('posts'));
    }

    public function create()
    {
        return view('admin.create-post');
    }

    public function findBySlug($postSlug)
    {
        $post = Post::where('slug', $postSlug)
                ->select(['id', 'title', 'html_content'])
                ->firstOrFail();

        return view('front.blog.viewpost')
            ->with(compact('post'));
    }

    public function findByTag($tagSlug)
    {
        $tag = Tag::where('slug', $tagSlug)->firstOrFail();
        $postType = PostType::where('name', 'post')->firstOrFail();
        $postStatus = PostStatus::where('name', 'published')->firstOrFail();

        $posts = Post::where('post_type_id', $postType->id)
                    ->where('post_status_id', $postStatus->id)
                    ->join('post_tag', function($join) use ($tag){
                        $join->on('posts.id', '=', 'post_tag.post_id')
                             ->where('post_tag.tag_id', '=', $tag->id);
                    })
                    ->select(['posts.id', 'posts.title', 'posts.slug', 'posts.created_at'])
                    ->paginate(10);

        return view('front.blog.viewpost-by-tag')
                ->with(compact('posts'))
                ->with('tagName', $tag->name);
    }       

    public function store(SavePost $savePost)
    {
        $data = collect(request()->all())
            ->put('user_id', auth()->user()->id)
            ->toArray();
        
        if (! $savePost->create($data)) {
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
