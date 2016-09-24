<?php

namespace DexBarrett\Http\Controllers;

use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use DexBarrett\Services\RSS\FeedBuilder;
use DexBarrett\Http\Controllers\Controller;

class FeedController extends Controller
{
    public function render(FeedBuilder $feedBuilder)
    {
        return response($feedBuilder->render(), 200)
            ->header('Content-Type', 'application/xml');
    }
}
