<?php
namespace DexBarrett\Services\Sitemap;

use Carbon\Carbon;
use DexBarrett\Post;
use Tackk\Cartographer\Sitemap;
use Tackk\Cartographer\ChangeFrequency;
use Illuminate\Contracts\Cache\Repository as Cache;

class SitemapBuilder {

    protected $sitemap;
    protected $cache;
    protected $cacheKey = 'sitemap';

    public function __construct(Sitemap $sitemap, Cache $cache)
    {
        $this->sitemap = $sitemap;
        $this->cache = $cache;
    }

    public function render()
    {
        if ($this->cache->has($this->cacheKey)) {
            return $this->cache->get($this->cacheKey);
        }

        $sitemapContent = $this->buildSitemap();

        $this->cache->put($this->cacheKey, $sitemapContent, Carbon::now()->addWeek());

        return $sitemapContent;
    }

    public function clearCache()
    {
        $this->cache->forget($this->cacheKey);
    }

    protected function buildSitemap()
    {
        $lastModifiedPost = Post::published()
            ->ofType('post')
            ->select(['updated_at'])
            ->latest('updated_at')
            ->first();

        $publishedPosts = Post::published()
                ->ofType('post')
                ->select(['slug', 'updated_at'])
                ->orderBy('updated_at', 'desc')
                ->get();

        $this->sitemap->add(
            url('/'), $lastModifiedPost->updated_at->format('Y-m-d'),
            ChangeFrequency::WEEKLY
        );

        foreach ($publishedPosts as $post) {

            $this->sitemap->add(
                config('app.url') . '/' . $post->slug,
                $post->updated_at->format('Y-m-d'),
                ChangeFrequency::MONTHLY
            );
        }

        return $this->sitemap->toString();
    }

}