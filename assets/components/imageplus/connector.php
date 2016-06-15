<?php
/**
 * Image+ connector
 *
 * Copyright 2013-2015 by Alan Pich <alan.pich@gmail.com>
 * Copyright 2015 by Thomas Jakobi <thomas.jakobi@partout.info>
 *
 * @package imageplus
 * @subpackage connector
 *
 * @author Alan Pich <alan.pich@gmail.com>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @copyright Alan Pich 2013-2015
 * @copyright Thomas Jakobi 2015
 *
 * @var modX $modx
 */
// Allow anonymous users for web processors and restrict actions to that folder including subfolders with restricted chars
if (isset($_REQUEST['action']) && strpos($_REQUEST['action'], 'web/') === 0) {
    $_REQUEST['action'] = 'web/' . preg_replace('#[^a-z0-9/_-]#i', '', str_replace('web/', '', $_REQUEST['action']));
    define('MODX_REQP', false);
}

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
$imageplus = $modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', array(
    'core_path' => $corePath
));

// Set HTTP_MODAUTH for web processors
if (defined('MODX_REQP') && MODX_REQP === false) {
    $_SERVER['HTTP_MODAUTH'] = $modx->user->getUserToken($modx->context->get('key'));
}

// Handle request
$modx->request->handleRequest(array(
    'processors_path' => $imageplus->getOption('processorsPath'),
    'location' => ''
));