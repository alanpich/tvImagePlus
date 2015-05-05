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

$path = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
$imagePlus = $modx->getService('imageplus', 'ImagePlus', $path);

$modx->lexicon->load('imageplus:default');

switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($path . 'elements/tv/input/');
        break;
    case 'OnTVOutputRenderList':
        $modx->event->output($path . 'elements/tv/output/');
        break;
    case 'OnTVInputPropertiesList':
        $modx->event->output($path . 'elements/tv/input/options/');
        break;
    case 'OnTVOutputRenderPropertiesList':
        $modx->event->output($path . 'elements/tv/output/options/');
        break;
    case 'OnDocFormRender':
        $imagePlus->includeScriptAssets();
        break;
};