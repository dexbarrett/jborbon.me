<?php
namespace DexBarrett\Shortcodes;

use Maiorano\Shortcodes\Contracts\ShortcodeInterface;

class ResponsiveImage implements ShortcodeInterface
{
    public function getName()
    {
        return 'image';
    }

    public function handle($content = null, array $atts = [])
    {
        return sprintf(
            '<img src="%s" class="img-responsive img-thumbnail center-block" />',
             $content
        );
    }
}