<?php
function getPluginContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$plugins = array();
 
$plugins[0]= $modx->newObject('modPlugin');
$plugins[0]->fromArray(array(
    'id' => 0,
    'name' => 'ImagePlus',
    'description' => 'Required by ModX <2.3 to route class calls properly',
    'plugincode' => getPluginContent($sources['plugins'].'plugin.ImagePlus.php'),
    'locked' => true
),'',true,true);
$properties = array();// include $sources['data'].'properties/properties.doodles.php';
$plugins[0]->setProperties($properties);
unset($properties);



// Add events to plugins
$events = array();
$events[] = $modx->newObject('modPluginEvent',array(
		'event' =>	'OnTVInputPropertiesList'
	));
$events[] = $modx->newObject('modPluginEvent',array(
		'event' =>	'OnTVInputRenderList'
	));
$events[] = $modx->newObject('modPluginEvent',array(
		'event' =>	'OnTVOutputRenderList'
	));
$events[] = $modx->newObject('modPluginEvent',array(
		'event' =>	'OnTVOutputRenderPropertiesList'
	));
$events[] = $modx->newObject('modPluginEvent',array(
		'event' =>	'OnManagerPageBeforeRender'
	));

$plugins[0]->addMany($events);
  
 
return $plugins;
