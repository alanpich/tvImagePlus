<?php

define('PKG_NAME',"ImagePlus");
define('PKG_NAMESPACE',"tvimageplus");
define('PKG_VERSION',"2.9.82");
define('PKG_RELEASE',"beta");



// Usually don't need to edit below here -----------------------------------------------
define('DS',DIRECTORY_SEPARATOR);
define('PKG_ROOT',dirname(dirname(__FILE__)).DS);
define('PKG_CORE',PKG_ROOT.'core'.DS.'components'.DS.PKG_NAMESPACE.DS);
define('PKG_ASSETS',PKG_ROOT.'assets'.DS.'components'.DS.PKG_NAMESPACE.DS);
define('PKG_BUILD',PKG_ROOT.'_build'.DS);
require(PKG_BUILD.'tools/build.tools.php');
define('PKG_COMMIT',Tools::getGitCommitId(PKG_ROOT));