<?php
namespace DexBarrett\Services\RSS;

use Carbon\Carbon;
use DexBarrett\Post;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use Suin\RSSWriter\Channel;
use Illuminate\Contracts\Cache\Repository as Cache;

class FeedBuilder {

    protected $cacheService;
    protected $cacheKey = 'rssfeed';

    public function __construct(Cache $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function render()
    {
        if ($this->cacheService->has($this->cacheKey)) {
            return $this->cacheService->get($this->cacheKey);
        }

        $feedContent = $this->buildFeed();

        $this->cacheService->put($this->cacheKey, $feedContent, Carbon::now()->addWeek());

        return $feedContent;
    }

    protected function buildFeed()
    {
        $rssFeed = new Feed;
        $channel = new Channel;

        $channel
            ->title('JBorbon blog')
            ->description('I rant and rave until I have no sense of time.')
            ->url(config('app.url'))
            ->appendTo($rssFeed);

        $publishedPosts = Post::published()
            ->ofType('post')
            ->select(['title', 'slug', 'html_content'])
            ->latest('published_at')
            ->take(30)
            ->get();

        foreach ($publishedPosts as $post) {
            $rssItem = new Item;

            $rssItem
                ->title($post->title)
                ->url(config('app.url') . '/' . $post->slug)
                ->description($post->html_content)
                ->appendTo($channel);
        }

        return $rssFeed->render();
    }

    public function clearCache()
    {
        $this->cache->forget($this->cacheKey);
    }

}