<?php
namespace DexBarrett\Listeners;

use DexBarrett\Events\PostCreated;
use DexBarrett\Events\PostDeleted;
use DexBarrett\Events\PostRestored;
use DexBarrett\Events\PostStatusChanged;
use DexBarrett\Post;
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

    public function onPostDeleted(PostDeleted $event)
    {
        if ($event->post->isOfType('post') 
            && $event->post->status->name == 'published') {
            $this->purgeContentCache();
        }
    }

    public function onPostStatusChanged(PostStatusChanged $event)
    {
        if ($event->post->isOfType('post')) {
            $this->purgeContentCache();
        }
       
    }

    public function onPostRestored(PostRestored $event)
    {
        if ($event->post->isOfType('post') 
            && $event->post->status->name == 'published') {
            $this->purgeContentCache();
        }
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

        $events->listen(
            PostRestored::class,
            'DexBarrett\Listeners\PostEventListener@onPostRestored'
        );
    }
}