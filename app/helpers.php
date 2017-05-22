<?php
function formatTagsAsLabels(array $tags, $postType) {
    return implode(' ',array_map(function($tag) use ($postType) {
            $url = action('PostController@findByTag', ['tagslug' => $tag['slug'], 'postType' => $postType]);
            return '<a href="' . $url . '" class="tag-link"><span class="label label-danger post-tag"><i class="fa fa-tag"></i> ' .  $tag['name'] . '</span></a>';
    }, $tags));
}

function getBookReviewIcons($score)
{
    $maxScore = 5;
    $onIconClass = 'fa fa-fw fa-thumbs-up';
    $offIconClass = 'fa fa-fw fa-thumbs-o-up';

    $onIcons = array_fill(0, $score, $onIconClass);
    $offIcons = array_fill(0, $maxScore - $score, $offIconClass);

    $icons = array_merge($onIcons, $offIcons);

    $iconMarkup = array_map(function($item) {
        return sprintf('<i class="%s"></i>', $item);
    }, $icons);

    return implode('&nbsp;', $iconMarkup);
}