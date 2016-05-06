<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Tag;
use DexBarrett\Post;
use DexBarrett\PostType;
use DexBarrett\SavePost;
use DexBarrett\PostStatus;
use DexBarrett\PostCategory;
use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use DexBarrett\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->ofType('post')
            ->select(['id', 'title', 'slug', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('front.blog.home')
            ->with(compact('posts'));
    }

    public function create($postTypeName)
    {
        $postType = PostType::where('name', $postTypeName)->firstOrFail();
        
        return view('admin.create-post')
            ->with(compact('postType'));
    }

    public function findBySlug($postSlug)
    {
        $post = Post::where('slug', $postSlug)
                ->select(['id', 'title', 'html_content', 'post_status_id', 'user_id', 'post_type_id'])
                ->firstOrFail();

        if ($post->isNotPublished() && (auth()->guest() || ! $post->publishedByUser(auth()->user()))) {
            abort(404);
        }

        return view('front.blog.viewpost')
            ->with(compact('post'));
    }

    public function findByTag($postTypeName, $tagSlug)
    {
        $tag = Tag::where('slug', $tagSlug)->select(['id', 'name'])->firstOrFail();
        $postType = PostType::where('name', $postTypeName)->firstOrFail();
        $postStatus = PostStatus::where('name', 'published')->firstOrFail();

        $posts = Post::where('post_type_id', $postType->id)
                    ->where('post_status_id', $postStatus->id)
                    ->join('post_tag', function($join) use ($tag){
                        $join->on('posts.id', '=', 'post_tag.post_id')
                             ->where('post_tag.tag_id', '=', $tag->id);
                    })
                    ->orderBy('posts.created_at', 'desc')
                    ->select(['posts.id', 'posts.title', 'posts.slug', 'posts.created_at'])
                    ->paginate(10);

        return view('front.blog.posts-by-filter')
                ->with(compact('posts'))
                ->with('filterType', 'etiqueta')
                ->with('filterName', $tag->name)
                ->with('postTypeName', $postType->desc);
    }

    public function findByCategory($postTypeName, $categorySlug)
    {
        $category = PostCategory::where('slug', $categorySlug)
            ->select(['id', 'name'])
            ->firstOrFail();  

        $postType = PostType::where('name', $postTypeName)->firstOrFail();
        $postStatus = PostStatus::where('name', 'published')->firstOrFail();

        $posts = Post::where('post_type_id', $postType->id)
                    ->where('post_status_id', $postStatus->id)
                    ->join('post_categories', function($join) use($category){
                        $join->on('posts.post_category_id', '=', 'post_categories.id')
                            ->where('post_categories.id', '=', $category->id);
                    })
                    ->orderBy('posts.created_at', 'desc')
                    ->select(['posts.id', 'posts.title', 'posts.slug', 'posts.created_at'])
                    ->paginate(10);

        return view('front.blog.posts-by-filter')
                ->with(compact('posts'))
                ->with('filterType', 'categoría')
                ->with('filterName', $category->name)
                ->with('postTypeName', $postType->desc);

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
