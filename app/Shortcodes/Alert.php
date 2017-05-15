<?php
namespace DexBarrett\Shortcodes;

use Maiorano\Shortcodes\Contracts\AttributeInterface;
use Maiorano\Shortcodes\Contracts\ShortcodeInterface;

class Alert implements ShortcodeInterface, AttributeInterface
{
    public function getName()
    {
        return 'alert';
    }

    public function getAttributes()
    {
        return [
            'type' => 'info'
        ];
    }

    public function handle($content = null, array $atts = [])
    {
        return '<div class="alert alert-' . $atts['type'] . '">' . $content . '</div>';         
    }
}