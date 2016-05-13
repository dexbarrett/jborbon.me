<?php

namespace DexBarrett\Http\Controllers;

use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use DexBarrett\Http\Controllers\Controller;
use DexBarrett\Services\Sitemap\SitemapBuilder as Sitemap;

class SitemapController extends Controller
{
    public function render(Sitemap $sitemap)
    {
        return response($sitemap->render(), 200)
            ->header('Content-Type', 'text/xml');
    }
}
