<?php
/**
 * @package imageplus
 * @subpackage plugin
 */

namespace TreehillStudio\ImagePlus\Plugins\Events;

use TreehillStudio\ImagePlus\Plugins\Plugin;

class OnTVOutputRenderPropertiesList extends Plugin
{
    public function process()
    {
        $this->modx->event->output($this->imageplus->getOption('corePath') . 'elements/tv/output/options/');
    }
}
