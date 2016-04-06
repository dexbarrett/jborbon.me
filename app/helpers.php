<?php
function formatTagsAsLabels(array $tags) {
    return implode('',array_map(function($tag){
            return ' <span class="label label-danger post-tag">' .  $tag['name'] . '</span>';
    }, $tags));
}