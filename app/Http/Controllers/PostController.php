<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Events\PostDeleted;
use DexBarrett\Events\PostRestored;
use DexBarrett\Http\Controllers\Controller;
use DexBarrett\Http\Requests;
use DexBarrett\Post;
use DexBarrett\PostCategory;
use DexBarrett\PostStatus;
use DexBarrett\PostType;
use DexBarrett\SavePost;
use DexBarrett\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->ofType('post')
            ->select(['id', 'title', 'slug', 'published_at'])
            ->orderBy('published_at', 'desc')
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
        $post = Post::withTrashed()
                ->where('slug', $postSlug)
                ->select(['id', 'title', 'slug', 'html_content', 'post_status_id', 'user_id', 'post_type_id', 'deleted_at'])
                ->firstOrFail();
        if ($post->isNotPublished() && (auth()->guest() || ! $post->publishedByUser(auth()->user()))) {
            abort(404);
        }

        return view('front.blog.viewpost')
            ->with(compact('post'))
            ->with('postUrl', $post->slug);
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
                    ->orderBy('posts.published_at', 'desc')
                    ->select(['posts.id', 'posts.title', 'posts.slug', 'posts.published_at'])
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
                    ->orderBy('posts.published_at', 'desc')
                    ->select(['posts.id', 'posts.title', 'posts.slug', 'posts.published_at'])
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

        $postCreated = $savePost->create($data);

        if (! $postCreated) {
            return redirect()->back()
                ->withInput()
                ->withErrors($savePost->errors());
        }

        return redirect()->action('PostController@edit', ['post' => $postCreated->id])
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

    public function destroy($postID, $forceDelete)
    {
        $post = Post::withTrashed()->findOrFail($postID);

        event(new PostDeleted($post));

        if((bool)$forceDelete)
        {
            $post->tags()->detach();
            $post->settings->delete();
            $post->forceDelete();
        } else {
            $post->delete();
        }
        

        return redirect()->back();
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->restore();

        event(new PostRestored($post));

        return redirect()->back();
    }
}
