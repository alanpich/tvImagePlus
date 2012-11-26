<?php
$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);
 
/* define package names */
define('PKG_NAME','Image+ TV');
define('PKG_NAME_LOWER','tvimageplus');
define('PKG_VERSION','2.0');
define('PKG_RELEASE','beta1');
 
/* define build paths */
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'resolvers' => $root . '_build/resolvers/',
    'plugins' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/plugins/',
    'lexicon' => $root . 'core/components/'.PKG_NAME_LOWER.'/lexicon/',
    'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
    'elements' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/',
    'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
    'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
);
unset($root);
 
/* override with your own defines here (see build.config.sample.php) */
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
 
$modx= new modX();
$modx->initialize('mgr');
echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
if(!defined('LOG_TARGET_ALREADY_SET')){
    $modx->setLogTarget('ECHO');
};
 
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category','ImagePlus');

 
// Create category vehicle -----------------------------------------------------------------
$attr = array(
		xPDOTransport::UNIQUE_KEY => 'category',
		xPDOTransport::PRESERVE_KEYS => false,
		xPDOTransport::UPDATE_OBJECT => true,
		xPDOTransport::RELATED_OBJECTS => true,
		xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
		    'Plugins' => array(
		        xPDOTransport::PRESERVE_KEYS => false,
		        xPDOTransport::UPDATE_OBJECT => true,
		        xPDOTransport::UNIQUE_KEY => 'name'
                xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
                    'PluginEvents' => array(
                        xPDOTransport::PRESERVE_KEYS => false,
                        xPDOTransport::UPDATE_OBJECT => true,
                        xPDOTransport::UNIQUE_KEY => 'id',
                     ),
			)			
		),
	);
$vehicle = $builder->createVehicle($category,$attr);


// Add file resolvers ------------------------------------------------------------------------
$modx->log(modX::LOG_LEVEL_INFO,'Adding file resolvers to category...');
$vehicle->resolve('file',array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));

 
// Add Router plugin -------------------------------------------------------------------------
	$modx->log(modX::LOG_LEVEL_INFO,'Packaging in plugin...');
	$plugins = include $sources['data'].'transport.plugins.php';
	if (empty($plugins)) $modx->log(modX::LOG_LEVEL_ERROR,'  => Could not package in plugin.');
	$category->addMany($plugins);
	$category->addMany($events);
    
    
 $builder->putVehicle($vehicle);
 
 
 /**
 * Parse the smarty readme tpl for packaging
 * @param string $path Path to tpl
 * @return string
 */
function getReadmeFile( $path ){
    global $modx;
    $modx->getService('smarty','smarty.modSmarty');
    
    $modx->smarty->assign('date',date("jS M Y g:ia"));
    $modx->smarty->assign('version',PKG_VERSION.' '.PKG_RELEASE);
    $readme = $modx->smarty->fetch($path);
    return $readme;
}//   
 // Add documentation ===========================================================
$modx->log(modX::LOG_LEVEL_INFO,'Adding documentation...');
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => getReadmeFile($sources['docs'] . 'readme.tpl'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt')
));   
    
    
 
 




/* zip up package */
$modx->log(modX::LOG_LEVEL_INFO,'Packing up transport package zip...');
$builder->pack();
 
$tend= explode(" ", microtime());
$tend= $tend[1] + $tend[0];
$totalTime= sprintf("%2.4f s",($tend - $tstart));
$modx->log(modX::LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
exit ();
