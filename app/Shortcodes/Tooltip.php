<?php
namespace DexBarrett\Shortcodes;

use Maiorano\Shortcodes\Contracts\AttributeInterface;
use Maiorano\Shortcodes\Contracts\ShortcodeInterface;

class Tooltip implements ShortcodeInterface, AttributeInterface
{
    public function getName()
    {
        return 'tooltip';
    }

    public function getAttributes()
    {
        return [
            'caption' => ''
        ];
    }

    public function handle($content = null, array $atts = [])
    {
        return '<span class="post-tooltip" title="' .  $atts['caption'] . '">' . $content . '</span>';        
    }
}