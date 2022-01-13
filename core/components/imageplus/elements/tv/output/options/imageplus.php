<?php
/**
 * Image+ Output Options Render
 *
 * Copyright 2013-2015 by Alan Pich <alan.pich@gmail.com>
 * Copyright 2015-2021 by Thomas Jakobi <office@treehillstudio.com>
 *
 * @package imageplus
 * @subpackage outputoptions_render
 *
 * @author Alan Pich <alan.pich@gmail.com>
 * @author Thomas Jakobi <office@treehillstudio.com>
 * @copyright Alan Pich 2013-2015
 * @copyright Thomas Jakobi 2015-2021
 */

/** @var \modX $modx */
$corePath = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
/** @var ImagePlus $imageplus */
$imageplus = $modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', [
    'core_path' => $corePath
]);

return $modx->smarty->fetch($corePath . 'elements/tv/output/tpl/imageplus.options.tpl');
