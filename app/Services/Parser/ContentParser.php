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
            'method' => 'parse',
            'setters' => [
                'setUrlsLinked' => [false]
            ]
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

            $filterClass = app()->make($params['class']);
            $this->callFilterSetters($filterName, $filterClass);
            
            $stages[] = [$filterClass, $params['method']];
        }

        $this->pipeline = new Pipeline($stages);

    }

    public function parse($input)
    {
        return $this->pipeline->process($input);
    }

    protected function filterHasSetters($filter)
    {
        return array_key_exists('setters', $this->filters[$filter]);
    }

    protected function callFilterSetters($filterName, $filterClass)
    {
        if (! $this->filterHasSetters($filterName)) {
            return;
        }

        foreach ($this->filters[$filterName]['setters'] as $method => $args) {
            call_user_func_array([$filterClass, $method], $args);
        }

    }
}