<?php

namespace DexBarrett;

use DexBarrett\Tag;
use DexBarrett\PostType;
use DexBarrett\PostStatus;
use DexBarrett\PostCategory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class Post extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    /* Relationships */

    public function category()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function type()
    {
        return $this->belongsTo(PostType::class);
    }

    public function status()
    {
        return $this->belongsTo(PostStatus::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
