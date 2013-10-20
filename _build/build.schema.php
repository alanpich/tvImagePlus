<?php
/**
 * xPDO Schema Generation
 *
 * @package Translations
 */
require_once dirname(__FILE__).'/build.config.php';
require_once PKG_ROOT.'config.core.php';


include_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);

echo php_sapi_name() == "cli" ? '' : '<pre>';

$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modelDir = PKG_CORE.'model/';
$schemaFile = PKG_BUILD.'schema/imageplus.mysql.schema.xml';

$manager= $modx->getManager();
$generator= $manager->getGenerator();

if (!is_dir($modelDir)) { $modx->log(modX::LOG_LEVEL_ERROR,"Model directory not found [{$modelDir}]"); die(); }
if (!file_exists($schemaFile)) { $modx->log(modX::LOG_LEVEL_ERROR,"Schema file not found! [{$schemaFile}]"); die(); }
$generator->parseSchema($schemaFile,$modelDir);

echo "\n";
exit();