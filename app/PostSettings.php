<?php

namespace DexBarrett;

use DexBarrett\Post;
use Illuminate\Database\Eloquent\Model;

class PostSettings extends Model
{
    protected $fillable = ['enable_comments'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
