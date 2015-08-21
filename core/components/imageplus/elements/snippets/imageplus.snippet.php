<?php
/**
 * Snippet as alternative to Image+ TV Output Type
 *
 * @package imageplus
 * @author  Alan Pich <alan.pich@gmail.com>
 *
 * @snippet ImagePlus
 * @var string $options The type of render to perform
 *
 */

$corePath = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
$imagePlus = $modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', array(
    'core_path' => $corePath
));

$tvname = $modx->getOption('tvname', $scriptProperties, '', true);
$docid = $modx->getOption('docid', $scriptProperties, $modx->resource->get('id'), true);
$type = $modx->getOption('type', $scriptProperties, '', true);
$options = $modx->getOption('options', $scriptProperties, '', true);
$tpl = $modx->getOption('tpl', $scriptProperties, 'ImagePlus.image', true);
$value = $modx->getOption('value', $scriptProperties, '', true);
$debug = $modx->getOption('debug', $scriptProperties, '', false);

if ($value) {
    // Value is set by snippet property
    $data = json_decode($value);
    if (!$data) {
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'Unable to decode JSON in snippet property', '', 'Image+');
        if ($debug) {
            return 'Unable to decode JSON in snippet property';
        }
    }
    // No TV is used
    $tv = null;
} else {
    // Value is retreived from template variable
    $tv = $modx->getObject('modTemplateVar', array('name' => $tvname));
    if ($tv) {
        // Get the raw content of the TV
        $value = $tv->getValue($docid);
    } else {
        $modx->log(xPDO::LOG_LEVEL_ERROR, "Template Variable '{$tvname}' not found.", '', 'Image+');
        if ($debug) {
            return "Template Variable '{$tvname}' not found.";
        }
    }
}

$output = '';
// Render output
switch ($type) {
    case 'check':
        $data = json_decode($value);
        $output = ($data && $data->sourceImg->src) ? 'image' : 'noimage';
        break;
    case 'tpl':
        $output = $imagePlus->getImageURL($value, array_merge($scriptProperties, array(
            'docid' => $docid,
            'phpThumbParams' => $options,
            'outputChunk' => $tpl
        )), $tv);
        break;
    case 'thumb':
    default:
        $output = $imagePlus->getImageURL($value, array_merge($scriptProperties, array(
            'docid' => $docid,
            'phpThumbParams' => $options
        )), $tv);
        break;
}
return $output;