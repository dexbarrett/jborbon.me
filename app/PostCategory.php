<?php

namespace DexBarrett;

use DexBarrett\PostType;
use DexBarrett\PostStatus;
use DexBarrett\PostCategory;
use DB;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class PostCategory extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];
    
    protected $fillable = ['name'];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucfirst($name);
    }

    public static function getCategoryList()
    {
        $published = PostStatus::where('name', 'published')
            ->select(['id'])
            ->firstOrFail();

        $postType = PostType::where('name', 'post')
            ->select(['id'])
            ->firstOrFail();

        return PostCategory::select([
                'post_categories.name', 'post_categories.slug',
                DB::raw('count(post_categories.id) as post_count')
                ])
                ->join('posts', function($join) use($postType, $published) {
                    $join->on('post_categories.id', '=', 'posts.post_category_id')
                    ->where('posts.post_type_id', '=', $postType->id)
                    ->where('posts.post_status_id', '=', $published->id);
                })
                ->groupBy('post_categories.id')
                ->orderBy('post_count', 'DESC')
                ->orderBy('post_categories.name')
                ->get();
    }
}
