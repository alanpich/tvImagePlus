<?php
/**
 * Output filter as alternative to Image+ TV Output Type
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

// If tag is empty, return nothing
if (!strlen($input))
    return '';

// Attempt to decode the input value as json
$data = json_decode($input);
if (is_null($data)) {
    $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[Image+] Unable to decode json - are you sure this is an ImagePlus TV?");
    return '';
}

// Extract render type
$outputParams = explode(':', $options, 2);
$outputType = array_shift($outputParams);

// Render output
switch ($outputType) {
    case 'pthumb':
        // Run pthumb snippet
        $params = (!empty($outputParams)) ? '&' . trim(array_shift($outputParams), '&') : '';
        $crop = array(
            'sx' => $data->crop->x,
            'sy' => $data->crop->y,
            'sw' => $data->crop->width,
            'sh' => $data->crop->height,
        );

        $params = http_build_query($crop) . $params;
        $output = $modx->runSnippet('pthumb', array(
            'input' => $data->sourceImg->src,
            'options' => $params
        ));
        break;
    default:
        $output = $imagePlus->getImageURL($input);
}
return $output;