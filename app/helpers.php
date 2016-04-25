<?php
function formatTagsAsLabels(array $tags) {
    return implode(' ',array_map(function($tag){
            return '<a href="#" class="tag-link"><span class="label label-danger post-tag"><i class="fa fa-tag"></i> ' .  $tag['name'] . '</span></a>';
    }, $tags));
}