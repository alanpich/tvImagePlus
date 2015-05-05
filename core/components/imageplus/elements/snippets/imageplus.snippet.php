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

$path = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
$imagePlus = $modx->getService('imageplus', 'ImagePlus', $path);

$tvname = $modx->getOption('tvname', $scriptProperties, '');
$docid = $modx->getOption('docid', $scriptProperties, $modx->resource->get('id'));
$type = $modx->getOption('type', $scriptProperties, '');
$options = $modx->getOption('options', $scriptProperties, '');
$tpl = $modx->getOption('tpl', $scriptProperties, 'ImagePlus.image');

$tv = $modx->getObject('modTemplateVar', array('name' => $tvname));
if ($tv) {
    /* get the raw content of the TV */
    $value = $tv->getValue($docid);

    // Attempt to decode the input value as json
    $data = json_decode($value);
    if (is_null($data)) {
        $modx->log(xPDO::LOG_LEVEL_ERROR, "[Image+] Unable to decode json - are you sure this is an ImagePlus TV?");
        return '';
    }

    // Render output
    switch ($type) {
        case 'check':
            $output = ($data->sourceImg->src) ? 'image' : 'noimage';
            break;
        case 'tpl':
            $output = ($data->sourceImg->src) ? $modx->getChunk($tpl, array(
                'url' => $imagePlus->getImageURL($value, array('phpThumbParams' => $options)),
                'alt' => $data->altTag
            )) : '';
            break;
        case 'thumb':
        default:
            $output = $imagePlus->getImageURL($value, array('phpThumbParams' => $options));
            break;
    }
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR, "[Image+] Template Variable '{$tvname}' not found.");
    $output = '';
}
return $output;