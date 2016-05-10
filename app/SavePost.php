<?php
namespace DexBarrett;

use Shortcode;
use DexBarrett\Tag;
use DexBarrett\Post;
use DexBarrett\PostSettings;
use DexBarrett\Services\Validation\PostValidator;
use AlfredoRamos\ParsedownExtra\ParsedownExtraLaravel;

class SavePost
{
    protected $markdownParser;
    protected $postValidator;

    public function __construct(ParsedownExtraLaravel $markdownParser, PostValidator $postValidator)
    {
        $this->markdownParser = $markdownParser;
        $this->postValidator = $postValidator;
    }

    public function create(array $data)
    {
        if ($this->dataIsNotValid($data)) {
            return false;
        }

        $post = new Post;
        $post->title = $data['title'];
        $post->markdown_content = $data['content'];

        $post->html_content = Shortcode::compile(
            $this->markdownParser->parse($data['content'])
        );
        
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

        return true;
    }

    public function update(Post $post, array $data)
    {
        if ($this->dataIsNotValid($data)) {
            return false;
        }
    
        $post->title = $data['title'];
        $post->markdown_content = $data['content'];

        $post->html_content = Shortcode::compile(
            $this->markdownParser->parse($data['content'])
        );

        $post->post_category_id = $this->parseCategory($data['category']);
        $post->post_status_id = $data['status'];

        $post->save();
        $post->tags()->sync($this->parseTags($data['tags']));

        $post->enableComments(array_get($data, 'enable_comments', 0));

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