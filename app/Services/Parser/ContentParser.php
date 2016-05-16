<?php
namespace DexBarrett\Services\Parser;

use League\Pipeline\Pipeline;
use AlfredoRamos\ParsedownExtra\ParsedownExtraLaravel as MarkdownParser;

class ContentParser
{

    // filters are applied in the order they appear in this array
    protected $filters = [

        'markdown' => [
            'class' => MarkdownParser::class,
            'method' => 'parse'
        ],

        'shortcode' => [
            'class' => 'shortcode', // <-- had to point to key in Laravel's container to get instance with shortcodes properly registered
            'method' => 'compile'
        ]
    ];

    protected $pipeline;

    public function __construct()
    {
        $stages = [];

        foreach ($this->filters as $filterName => $params) {
            $stages[] = [app()->make($params['class']), $params['method']];
        }

        $this->pipeline = new Pipeline($stages);

    }

    public function parse($input)
    {
        return $this->pipeline->process($input);
    }
}