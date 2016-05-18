<?php
namespace DexBarrett;

class ShortCode {
    
    public function alert($attr, $content = null, $name = null)
    {
        $options = ['type' => 'info'];
        $options = array_merge($options, $attr);

        return '<div class="alert alert-' . $options['type'] . '">' . $content . '</div>';    
    }

    public function tooltip($attr, $content = null, $name = null)
    {
        return '<span class="post-tooltip" title="' .  $attr['caption'] . '">' . $content . '</span>';
    }

    public function video($attr, $content = null, $name = null)
    {
        return <<<MARKUP
        <div class="embed-responsive embed-responsive-16by9">
        <iframe src="$content"  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
MARKUP;
    }

    public function image($attr, $content = null, $name = null)
    {
        return sprintf('<img src="%s" class="img-responsive img-thumbnail center-block" />', $content);
    }
}