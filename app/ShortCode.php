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
}