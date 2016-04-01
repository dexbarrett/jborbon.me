<?php
namespace DexBarrett;

use DexBarrett\Post;
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
        $post->html_content = $this->markdownParser->parse($data['content']);
        $post->user_id = 1;
        $post->post_category_id = $data['category'];
        $post->post_type_id = 2;
        $post->post_status_id = $data['status'];

        $post->save();
        $post->tags()->attach($data['tags']);

        return true;
    }

    public function update(Post $post, array $data)
    {
        if ($this->dataIsNotValid($data)) {
            return false;
        }

        $post->title = $data['title'];
        $post->markdown_content = $data['content'];
        $post->html_content = $this->markdownParser->parse($data['content']);
        $post->post_category_id = $data['category'];
        $post->post_status_id = $data['status'];

        $post->save();
        $post->tags()->sync($data['tags']);

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
}