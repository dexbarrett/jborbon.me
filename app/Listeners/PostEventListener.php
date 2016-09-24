<?php
namespace DexBarrett\Listeners;

use DexBarrett\Post;
use DexBarrett\Events\PostCreated;
use DexBarrett\Events\PostDeleted;
use DexBarrett\Events\PostStatusChanged;
use DexBarrett\Services\RSS\FeedBuilder;
use DexBarrett\Services\Sitemap\SitemapBuilder;

class PostEventListener
{
    protected $sitemapBuilder;
    protected $feedBuilder;

    public function __construct(SitemapBuilder $sitemapBuilder, FeedBuilder $feedBuilder)
    {
        $this->sitemapBuilder = $sitemapBuilder;
        $this->feedBuilder = $feedBuilder;
    }

    public function onPostCreated(PostCreated $event)
    {    
        if ($event->post->isOfType('post') && $event->post->isPublished()) {
            $this->purgeContentCache();
        }
    }

    public function onPostDeleted()
    {
        $this->purgeContentCache();
    }

    public function onPostStatusChanged()
    {
       $this->purgeContentCache();
    }

    protected function purgeContentCache()
    {
        $this->sitemapBuilder->clearCache();
        $this->feedBuilder->clearCache();
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