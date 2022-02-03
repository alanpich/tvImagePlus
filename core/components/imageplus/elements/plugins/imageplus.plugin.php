<?php
/**
 * Image+ Runtime Hooks
 *
 * @package imageplus
 * @subpackage plugin
 *
 * @var modX $modx
 * @var array $scriptProperties
 */

$className = 'TreehillStudio\ImagePlus\Plugins\Events\\' . $modx->event->name;

$corePath = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
/** @var ImagePlus $imageplus */
$imageplus = $modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', [
    'core_path' => $corePath
]);

if ($imageplus) {
    if (class_exists($className)) {
        $handler = new $className($modx, $scriptProperties);
        if (get_class($handler) == $className) {
            $handler->run();
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR, $className. ' could not be initialized!', '', 'ImagePlus Plugin');
        }
    } else {
        $modx->log(xPDO::LOG_LEVEL_ERROR, $className. ' was not found!', '', 'ImagePlus Plugin');
    }
}

return;
