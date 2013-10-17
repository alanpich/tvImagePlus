<?php
function getPluginContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}

/* create the plugin object */
$plugin= $modx->newObject('modPlugin');
$plugin->set('id',1);
$plugin->set('name', 'ImagePlus');
$plugin->set('description', PKG_NAME.' '.PKG_VERSION.'-'.PKG_RELEASE.' :: Image+ runtime hooks - registers custom TV input & output types and includes javascripts on document edit pages so that the TV can be used from within MIGX');
$plugin->set('plugincode', getPluginContent(PKG_CORE . 'elements/plugins/ImagePlus.php'));
$plugin->set('category', 0);

/* add plugin events */
$events = array();

$event = $modx->newObject('modPluginEvent');
$event->set('event','OnTVInputPropertiesList');
$event->set('priority',0);
$event->set('propertyset',0);
$events[] = $event;

$event = $modx->newObject('modPluginEvent');
$event->set('event','OnTVInputRenderList');
$event->set('priority',0);
$event->set('propertyset',0);
$events[] = $event;

$event = $modx->newObject('modPluginEvent');
$event->set('event','OnTVOutputRenderList');
$event->set('priority',0);
$event->set('propertyset',0);
$events[] = $event;

$event = $modx->newObject('modPluginEvent');
$event->set('event','OnTVOutputRenderPropertiesList');
$event->set('priority',0);
$event->set('propertyset',0);
$events[] = $event;

$event = $modx->newObject('modPluginEvent');
$event->set('event','OnDocFormRender');
$event->set('priority',0);
$event->set('propertyset',0);
$events[] = $event;

$event = $modx->newObject('modPluginEvent');
$event->set('event','OnManagerPageBeforeRender');
$event->set('priority',0);
$event->set('propertyset',0);
$events[] = $event;

$plugin->addMany($events);
unset($events);

/* create vehicle for plugin */
$attributes= array(
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'PluginEvents' => array(
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::UNIQUE_KEY => array('pluginid','event'),
        ),
    ),
);
$vehicle = $builder->createVehicle($plugin, $attributes);
$modx->log(modX::LOG_LEVEL_INFO,'Added ImagePlus plugin');
