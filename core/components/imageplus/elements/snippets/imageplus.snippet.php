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

if ($value) {
    // Attempt to decode the value as json
    $data = json_decode($value);
    if (!$data) {
        $modx->log(xPDO::LOG_LEVEL_ERROR, "[Image+] Unable to decode the value");
    }
} else {
    $tv = $modx->getObject('modTemplateVar', array('name' => $tvname));
    if ($tv) {
        // Get the raw content of the TV
        $value = $tv->getValue($docid);

        // Attempt to decode the input value as json
        $data = json_decode($value);
        if (!$data) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, "[Image+] Unable to decode json - are you sure this is an Image+ TV?");
        }
    } else {
        $modx->log(xPDO::LOG_LEVEL_ERROR, "[Image+] Template Variable '{$tvname}' not found.");
    }
}

$output = '';
if ($data) {
    // Render output
    switch ($type) {
        case 'check':
            $output = ($data->sourceImg->src) ? 'image' : 'noimage';
            break;
        case 'tpl':
            $output = ($data->sourceImg->src) ? $imagePlus->getImageURL($value, array(
                'phpThumbParams' => $options,
                'outputChunk' => $tpl
            ), $tv) : '';
            break;
        case 'thumb':
        default:
            $output = $imagePlus->getImageURL($value, array(
                'phpThumbParams' => $options), $tv
            );
            break;
    }
}
return $output;