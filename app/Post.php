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

    public function scopePublished($query)
    {
        return $query->where('post_status_id', 2)
                     ->orderBy('created_at', 'desc');

    }

    /* Relationships */

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function type()
    {
        return $this->belongsTo(PostType::class, 'post_type_id');
    }

    public function status()
    {
        return $this->belongsTo(PostStatus::class, 'post_status_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
