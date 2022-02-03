<?php
/**
 * @package imageplus
 * @subpackage plugin
 */

namespace TreehillStudio\ImagePlus\Plugins\Events;

use TreehillStudio\ImagePlus\Plugins\Plugin;

class OnTVInputRenderList extends Plugin
{
    public function process()
    {
        $this->modx->event->output($this->imageplus->getOption('corePath') . 'elements/tv/input/');
    }
}
