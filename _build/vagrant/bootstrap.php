<?php

// Load up the modx instance
define('MODX_API_MODE', true);
require '/var/www/index.php';

/**
 * @var modX $modx
 */


// Create the namespace
$namespace = $modx->newObject('modNamespace');
$namespace->set('name', 'tvimageplus');
$namespace->set('path', '{core_path}components/tvimageplus/');
$namespace->set('assets_path', '{assets_path}components/tvimageplus/');
$namespace->save();


// Create the plugin
$plugin = $modx->newObject('modPlugin');
$plugin->set('name', 'ImagePlus');
$plugin->set('static', true);
$plugin->set('static_file', 'core/components/tvimageplus/elements/plugins/ImagePlus.php');
$plugin->set('source',1);
$plugin->set('locked',true);

$eventNames = array(
    'OnTVInputRenderList',
    'OnTVOutputRenderList',
    'OnTVInputPropertiesList',
    'OnTVOutputPropertiesList',
    'OnDocFormRender',
    'OnTVOutputRenderPropertiesList'
);
$events = array();
foreach($eventNames as $evt){
    $event = $modx->newObject('modPluginEvent');
    $event->set('event', $evt);
    $events[] = $event;
}
$plugin->addMany($events);
$plugin->save();


// Clear the cache
$modx->cacheManager->refresh();