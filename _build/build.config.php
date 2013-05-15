<?php

define('PKG_NAME', 'Image+ TV');
define('PKG_NAMESPACE', 'tvimageplus');
define('PKG_VERSION','2.1.5');
define('PKG_RELEASE','beta');


define('PKG_ROOT',dirname(dirname(__FILE__)).'/');
define('PKG_CORE',PKG_ROOT.'core/components/'.PKG_NAMESPACE.'/');
define('PKG_ASSETS',PKG_ROOT.'assets/components/'.PKG_NAMESPACE.'/');
define('PKG_BUILD',PKG_ROOT.'_build/');
define('PKG_COMMIT',Tools::getGitCommitId(PKG_ROOT));
require PKG_ROOT.'config.core.php';

$sources = array(
    'root' => PKG_ROOT,
    'build' => PKG_BUILD,
    'data' => PKG_BUILD . 'data/',
    'resolvers' => PKG_BUILD . 'resolvers/',
    'elements' => PKG_CORE . 'elements/',
    'plugins' => PKG_CORE . 'elements/plugins/',
    'lexicon' => PKG_CORE . 'lexicon/',
    'docs' => PKG_CORE . 'docs/',
    'source_assets' => PKG_ASSETS,
    'source_core' => PKG_CORE
);


