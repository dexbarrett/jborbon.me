<?php
namespace DexBarrett;

use DexBarrett\Tag;
use DexBarrett\Post;
use DexBarrett\PostSettings;
use DexBarrett\Services\Parser\ContentParser;
use DexBarrett\Events\PostCreated;
use DexBarrett\Events\PostStatusChanged;

use DexBarrett\Services\Validation\PostValidator;

class SavePost
{
    protected $postValidator;
    protected $contentParser;

    public function __construct(PostValidator $postValidator, ContentParser $contentParser)
    {
        $this->postValidator = $postValidator;
        $this->contentParser = $contentParser;
    }

    public function create(array $data)
    {
        if ($this->dataIsNotValid($data)) {
            return false;
        }

        $post = new Post;
        $post->title = $data['title'];
        $post->markdown_content = $data['content'];

        $post->html_content = $this->contentParser->parse($data['content']);
        
        $post->user_id = $data['user_id'];
        $post->post_category_id = $this->parseCategory($data['category']);
        $post->post_type_id = $data['post_type'];
        $post->post_status_id = $data['status'];

        $post->save();
        $post->tags()->attach($this->parseTags($data['tags']));

        $settings = new PostSettings([
            'enable_comments' => array_get($data, 'enable_comments', 0)
        ]);

        $post->settings()->save($settings);

        event(new PostCreated($post));

        return $post;
    }

    public function update(Post $post, array $data)
    {
        $statusChanged = $post->status->id != $data['status'];

        if ($this->dataIsNotValid($data)) {
            return false;
        }
    
        $post->title = $data['title'];
        $post->markdown_content = $data['content'];

        $post->html_content = $this->contentParser->parse($data['content']);

        $post->post_category_id = $this->parseCategory($data['category']);
        $post->post_status_id = $data['status'];

        $post->save();
        $post->tags()->sync($this->parseTags($data['tags']));

        $post->enableComments(array_get($data, 'enable_comments', 0));

        if ($statusChanged) {
            event(new PostStatusChanged($post));
        }

        return true;
    }

    public function errors()
    {
        return $this->postValidator->errors();
    }

    protected function dataIsNotValid(array $input)
    {
        return ! $this->postValidator->validate($input);
    }

    protected function parseCategory($category)
    {
        $foundCategory = PostCategory::find($category);

        if ($foundCategory) {
            return $foundCategory->id;
        }

        return PostCategory::create(['name' => $category])->id;
    }

    protected function parseTags($tags)
    {
        return array_map(function($tag) {
            if (! is_numeric($tag)) {
                return Tag::create(['name' => $tag])->id;
            }
            return $tag;
        }, $tags);
    }
}