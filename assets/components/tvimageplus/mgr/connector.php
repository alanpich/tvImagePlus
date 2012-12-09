<?php
/**
 * MGR Connector
 * 
 * @package tvImagePlus
 * @copyright Alan Pich 2012
 */
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

// Load up some lexiconzzzz
$modx->lexicon->load('tvimageplus:default');
 
// Handle request 
$modx->request->handleRequest(array(
    'processors_path' => $modx->getOption('core_path').'components/tvimageplus/processors/',
    'location' => '',
));