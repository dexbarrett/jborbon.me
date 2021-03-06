<?php
namespace DexBarrett\Services\RSS;

use DateTime;
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
            ->feedUrl(action('FeedController@render'));

        $publishedPosts = Post::published()
            ->ofType('post')
            ->select(['title', 'slug', 'html_content', 'published_at'])
            ->latest('published_at')
            ->take(30)
            ->get();

        $channel->pubDate(
            $publishedPosts
            ->first()
            ->published_at->getTimestamp()
        )->appendTo($rssFeed);

        foreach ($publishedPosts as $post) {
            $rssItem = new Item;

            $rssItem
                ->title($post->title)
                ->url(action('PostController@findBySlug', ['slug' => $post->slug]))
                ->description($post->html_content)
                ->contentEncoded($post->html_content)
                ->pubDate($post->published_at->getTimestamp())
                ->guid(action('PostController@findBySlug', ['slug' => $post->slug]), true)
                ->preferCdata(true)
                ->appendTo($channel);
        }

        return $rssFeed->render();
    }

    public function clearCache()
    {
        $this->cacheService->forget($this->cacheKey);
    }

}