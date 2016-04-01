<?php
namespace DexBarrett;

class ShortCode {
    
    public function register($attr, $content = null, $name = null)
    {
        $options = ['type' => 'info'];
        $options = array_merge($options, $attr);

        return '<div class="alert alert-' . $options['type'] . '">' . $content . '</div>';    
    }

}