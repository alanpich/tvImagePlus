<?php
/**
 * @package imageplus
 * @subpackage plugin
 */

namespace TreehillStudio\ImagePlus\Plugins\Events;

use TreehillStudio\ImagePlus\Plugins\Plugin;

class OnManagerPageBeforeRender extends Plugin
{
    public function process()
    {
        $this->modx->controller->addLexiconTopic('imageplus:default');
        $this->modx->controller->addLexiconTopic('imageplus:setting');
        $this->imageplus->includeScriptAssets();
    }
}
