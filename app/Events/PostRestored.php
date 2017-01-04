<?php
namespace DexBarrett\Events;

use DexBarrett\Post;

class PostRestored extends Event 
{
    public $post;

    public function __construct(Post $post)
    { 
        $this->post = $post;
    }
}