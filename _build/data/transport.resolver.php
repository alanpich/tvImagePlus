<?php

/** @var \modX $modx */
$modx = $object->xpdo;
$manager = $modx->getManager();
$modx->addPackage('imageplus',$modx->getOption('tvimageplus.core_path',null,$modx->getOption('core_path').'components/tvimageplus/model/'));
$manager->createObjectContainer('ImagePlusImage');

return true;