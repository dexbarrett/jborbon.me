<?php
function formatTagsAsLabels(array $tags, $postType) {
    return implode(' ',array_map(function($tag) use ($postType) {
            $url = action('PostController@findByTag', ['tagslug' => $tag['slug'], 'postType' => $postType]);
            return '<a href="' . $url . '" class="tag-link"><span class="label label-danger post-tag"><i class="fa fa-tag"></i> ' .  $tag['name'] . '</span></a>';
    }, $tags));
}