<?php
function formatTagsAsLabels(array $tags) {
    return implode(' ',array_map(function($tag){
            $url = action('PostController@findByTag', ['tagslug' => $tag['slug']]);
            return '<a href="' . $url . '" class="tag-link"><span class="label label-danger post-tag"><i class="fa fa-tag"></i> ' .  $tag['name'] . '</span></a>';
    }, $tags));
}