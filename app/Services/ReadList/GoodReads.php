<?php
namespace DexBarrett\Services\ReadList;

use Carbon\Carbon;
use SimpleXMLElement;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;

class GoodReads
{
    protected $cache;
    protected $httpClient;
    protected $config;
    protected $url = 'https://goodreads.com/review/list.xml';
    protected $cacheKey = 'readlist';

    public function __construct(Cache $cache, HttpClient $httpClient, Config $config)
    {
        $this->cache = $cache;
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function getReadList()
    {
        if ($this->cache->has($this->cacheKey)) {
            return $this->cache->get($this->cacheKey);
        }

        $readList = $this->getReadListContent();

        $this->cache->put(
            $this->cacheKey,
            $readList,
            Carbon::now()->addDay()
        );

        return $readList;
    }


    protected function buildReadListUrl()
    {
        $config = $this->config->get('readlist.goodreadsParams');

        return sprintf('%s?%s', $this->url, http_build_query($config));
    }

protected function getReadListContent()
    {
        $responseContent = $this->httpClient
            ->get($this->buildReadListUrl())
            ->getBody();

        return $this->parseResponse($responseContent);
    }

    protected function parseResponse($content)
    {
        $xml = new SimpleXMLElement($content, LIBXML_NOCDATA);

        $reviews = $xml->xpath('//review');

        $books = array_map(function($item) {
            return [
                'title' => (string)$item->book->title,
                'author' => (string)$item->book->authors->author->name,
                'format' => (string)$item->book->format,
                'rating' => (int)$item->rating,
                'imageUrl' => (string)$item->book->image_url,
                'startedAt' => Carbon::parse((string)$item->started_at)->format('d/m/Y'),
                'finishedAt' => Carbon::parse((string)$item->read_at)->format('d/m/Y'),
                'url' => (string)$item->book->link,
                'review' => trim((string)$item->body)
            ];
        }, $reviews);
        

        return $books;
    }

}