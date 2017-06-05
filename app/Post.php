<?php

namespace DexBarrett;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use DexBarrett\PostCategory;
use DexBarrett\PostSettings;
use DexBarrett\PostStatus;
use DexBarrett\PostType;
use DexBarrett\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements SluggableInterface
{
    use SluggableTrait;
    use SoftDeletes;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at',
        'deleted_at'
    ];

    /* Mutators */

    public function setPostStatusIdAttribute($statusID)
    {
        $statusPublished = PostStatus::where('name', 'published')
            ->select(['id'])
            ->first();

        if (is_null($this->published_at) && $statusID == $statusPublished->id) {
            $this->published_at = Carbon::now();
        }

        $this->attributes['post_status_id'] = $statusID;
    }

    /* Query Scopes */

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

    /* Custom Methods */

    public function isNotPublished()
    {
        return ! $this->isPublished();
    }

    public function isPublished()
    {
        return strtolower($this->status->name) == 'published' 
                && ! $this->trashed();
    }

    public function isOfType($type)
    {
        return strtolower($this->type->name) == strtolower($type);
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

    public static function findByUuid($uuid)
    {
        return static::where('uuid', $uuid)->firstOrFail();
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
