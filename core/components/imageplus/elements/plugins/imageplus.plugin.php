<?php
/**
 * Image+ runtime hooks - registers custom TV input & output types
 * and includes javascripts on document edit pages so that the TV
 * can be used from within MIGX
 *
 * @plugin  ImagePlusRouter
 * @package imageplus
 * @locked
 *
 * @event   OnTVInputRenderList
 * @event   OnTVOutputRenderList
 * @event   OnTVInputPropertiesList
 * @event   OnTVOutputPropertiesList
 * @event   OnTVOutputRenderPropertiesList
 * @event   OnDocFormRender
 *
 */

$corePath = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
$imageplus = $modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', array(
    'core_path' => $corePath
));

switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath . 'elements/tv/input/');
        break;
    case 'OnTVOutputRenderList':
        $modx->event->output($corePath . 'elements/tv/output/');
        break;
    case 'OnTVInputPropertiesList':
        $modx->event->output($corePath . 'elements/tv/input/options/');
        break;
    case 'OnTVOutputRenderPropertiesList':
        $modx->event->output($corePath . 'elements/tv/output/options/');
        break;
    case 'OnDocFormRender':
        $imageplus->includeScriptAssets();
        break;
};