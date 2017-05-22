<?php

namespace DexBarrett\Http\Controllers;

use DexBarrett\Http\Controllers\Controller;
use DexBarrett\Http\Requests;
use DexBarrett\Services\ReadList\GoodReads;
use Illuminate\Http\Request;

class ReadListController extends Controller
{
    public function getReadList(GoodReads $goodReads)
    {
        return view('front.readlist')
            ->with('readList', $goodReads->getReadList());
    }
}
