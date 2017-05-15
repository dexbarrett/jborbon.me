<?php
namespace DexBarrett\Shortcodes;

use Maiorano\Shortcodes\Contracts\ShortcodeInterface;

class ResponsiveVideo implements ShortcodeInterface
{
    public function getName()
    {
        return 'video';
    }

    public function handle($content = null, array $atts = [])
    {
    
    return <<<MARKUP
        <div class="embed-responsive embed-responsive-16by9">
        <iframe src="$content"  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
MARKUP;

    }
}