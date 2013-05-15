<?php
/**
 * Image+ runtime hooks - registers custom TV input & output types
 * and includes javascripts on document edit pages so that the TV
 * can be used from within MIGX
 *
 * @plugin  ImagePlusRouter
 * @package tvimageplus
 * @locked
 *
 * @event   OnTVInputRenderList
 * @event   OnTVOutputRenderList
 * @event   OnTVInputPropertiesList
 * @event   OnTVOutputPropertiesList
 * @event   OnDocFormRender
 *
 */

$corePath = $modx->getOption(
    'tvimageplus.core_path',
    null,
    $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/tvimageplus/'
);
$assetsUrl = $modx->getOption(
    'tvimageplus.assets_url',
    null,
    $modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/tvimageplus/js/mgr/'
);

$modx->lexicon->load('tvimageplus:default');

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
        include $corePath."tvImagePlus.class.php";
        $helper = new tvImagePlus($modx);
        $helper->includeScriptAssets();
        break;
};