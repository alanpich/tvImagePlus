<?php
/**
 * ImagePlus Snippet as alternative to Image+ TV Output Type
 *
 * @package imageplus
 * @subpackage snippet
 *
 * @var modX $modx
 * @var array $scriptProperties
 */

use TreehillStudio\ImagePlus\Snippets\ImagePlus;

$corePath = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
/** @var ImagePlus $imageplus */
$imageplus = $modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', [
    'core_path' => $corePath
]);

$snippet = new ImagePlus($modx, $scriptProperties);
if ($snippet instanceof TreehillStudio\ImagePlus\Snippets\ImagePlus) {
    return $snippet->execute();
}
return 'TreehillStudio\ImagePlus\Snippets\ImagePlus class not found';