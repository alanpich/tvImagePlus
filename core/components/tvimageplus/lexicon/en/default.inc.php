<?php

$_lang['imageplus'] = "Image+";


$_lang['tvimageplus.editor_title'] = 'Image+ Editor';
$_lang['tvimageplus.edit_image'] = 'Edit Image';
$_lang['tvimageplus.are_you_sure'] = 'Are you sure you want to do this?';
$_lang['tvimageplus.please_wait'] = 'Please wait...';


/** TV input render */
$_lang['tvimageplus.err_crop_too_small'] = 'Crop selection is too small';
$_lang['tvimageplus.err_crop_too_small_desc'] = 'The crop area you have selected is smaller than the size needed for this image.'
                                               .'This means the image will be scaled up to fit. <br /><br /><strong>Please don\'t do this, it will make the site look terrible.</strong>';

/** Input options render **/
$_lang['tvimageplus.targetwidth'] = 'Target Width';
$_lang['tvimageplus.targetwidth_desc'] = 'The target width for the output image';
$_lang['tvimageplus.targetheight'] = 'Target Height';
$_lang['tvimageplus.targetheight_desc'] = 'The target height for the output image';
$_lang['tvimageplus.allowAltTag'] = 'Alt tag field';
$_lang['tvimageplus.allowAltTag_desc'] = 'Allow user to enter a title/alt-tag for the image';

/** Output options render **/
$_lang['tvimageplus.output_options'] = 'Image+ Rendering Options';
$_lang['tvimageplus.output_type'] = 'Image+ Output Type';
$_lang['tvimageplus.phpThumbParams'] = 'Additional phpThumb parameters';
$_lang['tvimageplus.phpThumbParams_desc'] = 'Add additional filters etc for phpThumb. Documentation can be found <a target="_blank" href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt">here</a>.';
$_lang['tvimageplus.outputChunk'] = 'Output chunk';
$_lang['tvimageplus.outputChunk_desc'] = 'Select a chunk for tv output. Leave blank for raw url output';


/** Output options render **/
$_lang['tvimageplus.output_render.url'] = 'URL';

$_lang['tvimageplus.output_render.chunk'] = 'Chunk';
$_lang['tvimageplus.output_render.chunk.info'] = 'The selected chunk will be called and passed the following placeholders:';

$_lang['tvimageplus.output_render.snippet'] = 'Snippet';
$_lang['tvimageplus.output_render.snippet.info'] = 'The selected snippet will be called and passed the following parameters:';
$_lang['tvimageplus.output_render.snippet.params'] = '&lt;?php
/**
 * @param int    $uid       Unique identifier for this Image+ instance
 * @param string $url       Absolute URL of the cropped image
 * @param int    $width     Image width
 * @param int    $height    Image height
 * @param int    $mtime     Timestamp when cached image was generated
 * @param string $original  Absolute URL to the original (source) image
 */';


$_lang['tvimageplus.output_render.image'] = 'Image';
$_lang['tvimageplus.output_render.datauri'] = 'Data URI';
$_lang['tvimageplus.select_chunk'] = 'Select chunk';
$_lang['tvimageplus.select_snippet'] = 'Select snippet';

/** Output placeholder descriptions */
$_lang['tvimageplus.placeholder.uid'] = 'Unique identifier for the Image+ instance';
$_lang['tvimageplus.placeholder.url'] = 'Absolute URL of the cropped image';
$_lang['tvimageplus.placeholder.width'] = 'Image width';
$_lang['tvimageplus.placeholder.height'] = 'Image height';
$_lang['tvimageplus.placeholder.mtime'] = 'Timestamp when cached image was generated';
$_lang['tvimageplus.placeholder.original'] = 'Absolute URL to the original (source) image';
$_lang['tvimageplus.placeholder.image'] = 'xPDOObject representing the image (Advanced use only)';

/** Cache regenerator render */
$_lang['tvimageplus.regenerate_cache'] = 'Regenerate Image+ cache';
$_lang['tvimageplus.regenerating_cache'] = 'Regenerating Image+ cache... this could take a while...';
$_lang['tvimageplus.regenerate_cache_desc'] = 'Regenerates cropped images for all Image+ TVs';
$_lang['tvimageplus.regenerate_cache_simple_button'] = 'Start simple regeneration';


