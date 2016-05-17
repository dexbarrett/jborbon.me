<?php
namespace DexBarrett\Listeners;

use DexBarrett\Post;
use DexBarrett\Events\PostCreated;
use DexBarrett\Events\PostDeleted;
use DexBarrett\Events\PostStatusChanged;
use DexBarrett\Services\Sitemap\SitemapBuilder;

class PostEventListener
{
    protected $sitemapBuilder;

    public function __construct(SitemapBuilder $sitemapBuilder)
    {
        $this->sitemapBuilder = $sitemapBuilder;
    }

    public function onPostCreated(PostCreated $event)
    {    
        if ($event->post->isOfType('post') && $event->post->isPublished()) {
            $this->purgeSitemapCache();
        }
    }

    public function onPostDeleted()
    {
        $this->purgeSitemapCache();
    }

    public function onPostStatusChanged()
    {
       $this->purgeSitemapCache();
    }

    protected function purgeSitemapCache()
    {
        $this->sitemapBuilder->clearCache();
    }
    
    public function subscribe($events)
    {
        $events->listen(
            PostCreated::class,
            'DexBarrett\Listeners\PostEventListener@onPostCreated'
        );

        $events->listen(
            PostDeleted::class,
            'DexBarrett\Listeners\PostEventListener@onPostDeleted'
        );

        $events->listen(
            PostStatusChanged::class,
            'DexBarrett\Listeners\PostEventListener@onPostStatusChanged'
        );
    }
}