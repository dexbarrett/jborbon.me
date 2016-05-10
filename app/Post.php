<?php

namespace DexBarrett;

use DexBarrett\Tag;
use DexBarrett\PostType;
use DexBarrett\PostStatus;
use DexBarrett\PostCategory;
use DexBarrett\PostSettings;
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
        $postStatusPublished = PostStatus::where('name', 'published')
            ->select(['id'])
            ->firstOrFail();

        return $query->where('post_status_id', $postStatusPublished->id);

    }

    public function scopeOfType($query, $type)
    {
        $postTypePost = PostType::where('name', $type)
            ->select(['id'])
            ->firstOrFail();

        return $query->where('post_type_id', $postTypePost->id);
    }

    public function isNotPublished()
    {
        return ! $this->isPublished();
    }

    public function isPublished()
    {
        return strtolower($this->status->name) == 'published';
    }

    public function publishedByUser($user)
    {
        return $user->id == $this->user_id;
    }

    public function hasCommentsEnabled()
    {
        return (bool) $this->settings->enable_comments;
    }

    public function enableComments($enable)
    {
        $this->settings->enable_comments = (bool)$enable;
        $this->settings->save();
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

    public function settings()
    {
        return $this->hasOne(PostSettings::class);
    }
}
