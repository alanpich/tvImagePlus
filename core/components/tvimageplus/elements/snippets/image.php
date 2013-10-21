<?php
/**
 * Image+ Output Renderer Snippet
 * 
 * Alternative to Image+ TV Output Type
 *
 * @package ImagePlus
 * @author  Alan Pich <alan.pich@gmail.com>
 *
 * @snippet image
 * @var string $options The type of render to perform
 *
 */

$path = $modx->getOption('tvimageplus.core_path',null,
		$modx->getOption('core_path').'components/tvimageplus/');
$imagePlus = $modx->getService('imagePlus','ImagePlus',$path);

// If tag is empty, return nothing
if(!strlen($input))
	return '';

// Attempt to decode the input value as json
$data = json_decode($input);
if(is_null($data)){
	$this->modx->log(xPDO::LOG_LEVEL_ERROR,"[Image+] Unable to decode json - are you sure this is an ImagePlus TV?");
	return '';
}

// Check decoded data for a uid
if(!isset($data->uid)){
	$this->modx->log(xPDO::LOG_LEVEL_ERROR,"[Image+] Image uid not found");
	return '';
}

// Grab the image
$uid = $data->uid;
$image = $imagePlus->getImage($uid);

// Extract render type
$bits = explode(':',str_replace(' ','',strtolower($options)),2);
$outputType = array_shift($bits);

// Render output
switch($outputType){

	case 'snippet':
		if(count($bits)<1){
			$modx->log(xPDO::LOG_LEVEL_ERROR,"[Image+] Snippet name not specified");
			return '';
		}
		$snippet = array_shift($bits);
		return $image->renderSnippet($snippet);
		break;

	case 'chunk':
		if(count($bits)<1){
			$modx->log(xPDO::LOG_LEVEL_ERROR,"[Image+] Chunk name not specified");
			return '';
		}
		$chunk = array_shift($bits);
		return $image->renderChunk($chunk);
		break;

	case 'datauri':
		return $image->renderDataUri();
		break;

	default:
		return $image->renderUrl();
}