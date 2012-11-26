<?php
$corePath = $modx->getOption('core_path',null,MODX_CORE_PATH).'components/tvimageplus/';
$assetsUrl = $modx->getOption('assets_url',null,MODX_ASSETS_URL).'components/tvimageplus/js/mgr/';

$modx->lexicon->load('tvimageplus:default');

switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath.'elements/tv/input/');
        break;
    case 'OnTVOutputRenderList':
        $modx->event->output($corePath.'elements/tv/output/');
        break;
    case 'OnTVInputPropertiesList':
        $modx->event->output($corePath.'elements/tv/input/options/');
        break;
    case 'OnTVOutputRenderPropertiesList':
        $modx->event->output($corePath.'elements/tv/output/options/');
        break;
};