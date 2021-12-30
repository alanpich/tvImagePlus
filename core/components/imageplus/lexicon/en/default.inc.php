<?php
/**
 * Default Lexicon Entries for Image+
 *
 * @package imageplus
 * @subpackage lexicon
 */

$_lang['imageplus'] = 'Image+';
$_lang['imageplus.editor_title'] = 'Image+ Editor';
$_lang['imageplus.alt_text'] = 'Alt text';
$_lang['imageplus.caption'] = 'Caption';
$_lang['imageplus.credits'] = 'Credits';

/** Input options render **/
$_lang['imageplus.input_section'] = 'Image+ Options';
$_lang['imageplus.input_section_desc'] = 'The following options could be overridden by context/system settings. Please read the <a href="https://jako.github.io/ImagePlus/usage/#contextsystem-settings" target="_blank">documentation</a> for the appropriate keys in the context/system settings.';
$_lang['imageplus.selectConfig'] = 'Predefined target sizes/aspect ratios';
$_lang['imageplus.selectConfig_desc'] = 'Select a predefined target size/aspect ratio. The definitions could be created in the system settings.';
$_lang['imageplus.selectConfigForce'] = 'Forced predefined target sizes/aspect ratios';
$_lang['imageplus.selectConfigForce_desc'] = 'Forced select a predefined crop size/aspect ratio. The definitions could be created in the system settings.';
$_lang['imageplus.targetwidth'] = 'Target (Minimal) Width';
$_lang['imageplus.targetwidth_desc'] = '(Optional, Integer) The target width for the output image. The uploaded image should have this minimal width.';
$_lang['imageplus.targetheight'] = 'Target (Minimal) Height';
$_lang['imageplus.targetheight_desc'] = '(Optional, Integer) The target height for the output image. The uploaded image should have this minimal height.';
$_lang['imageplus.targetRatio'] = 'Target Aspect Ratio';
$_lang['imageplus.targetRatio_desc'] = '(Optional, Float) The target aspect ratio for the output image as float value. If the target height and the targed width are set, this value is ignored.';
$_lang['imageplus.thumbnailWidth'] = 'Thumbnail Width';
$_lang['imageplus.thumbnailWidth_desc'] = '(Optional, Integer) The thumbnail width of the image in the template variable panel.';
$_lang['imageplus.allowAltTag'] = 'Show Alt Tag Field';
$_lang['imageplus.allowAltTag_desc'] = 'Allow user to enter a title/alt-tag for the image.';
$_lang['imageplus.allowCaption'] = 'Show Caption Field';
$_lang['imageplus.allowCaption_desc'] = 'Allow user to enter a caption for the image.';
$_lang['imageplus.allowCredits'] = 'Show Credits Field';
$_lang['imageplus.allowCredits_desc'] = 'Allow user to enter a credit for the image.';

/** Output options render **/
$_lang['imageplus.phpThumbParams'] = 'Additional phpThumb Parameters';
$_lang['imageplus.phpThumbParams_desc'] = 'Add additional filters etc for phpThumb. Documentation can be found <a href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt" target="_blank">here</a>.';
$_lang['imageplus.outputChunk'] = 'Output Chunk';
$_lang['imageplus.outputChunk_desc'] = 'Select a chunk for tv output. Leave blank for raw url output.';
$_lang['imageplus.generateUrl'] = 'Generate Thumb URL';
$_lang['imageplus.generateUrl_desc'] = '(Optional) The thumb url is maybe not necessary, if you generate the thumbnail in output chunk i.e. by a pthumb output filter.';
$_lang['imageplus.generateUrl_desc_warning'] = 'You have to activate this option, when you don\'t specify an output chunk in the output options or when you use the [[+url]] placeholder in the specified output chunk. Otherwise the image is not cropped/resized and the original image path is returned.';

/** Placeholder descriptions */
$_lang['imageplus.placeholder.url'] = 'URL of the thumbnail image';
$_lang['imageplus.placeholder.alt'] = 'Alt text';
$_lang['imageplus.placeholder.width'] = 'Width of the thumbnail image (ignored when 0)';
$_lang['imageplus.placeholder.height'] = 'Height of the thumbnail image (ignored when 0)';
$_lang['imageplus.placeholder.source.src'] = 'Path to the source image';
$_lang['imageplus.placeholder.source.width'] = 'Width of the source image';
$_lang['imageplus.placeholder.source.height'] = 'Height of the source image';
$_lang['imageplus.placeholder.crop.width'] = 'Crop width of the source image';
$_lang['imageplus.placeholder.crop.height'] = 'Crop height of the source image';
$_lang['imageplus.placeholder.crop.x'] = 'Crop x position of the source image';
$_lang['imageplus.placeholder.crop.y'] = 'Crop y position of the source image';
$_lang['imageplus.placeholder.options'] = 'phpThumb option string to generate the thumbnail image';
$_lang['imageplus.placeholder.crop.options'] = 'phpThumb crop option string to generate the thumbnail image';
$_lang['imageplus.error.image_too_small.title'] = 'Image too small';
$_lang['imageplus.error.image_too_small.msg'] = 'The selected image is too small to be used here. Please select a different image.';
$_lang['imageplus.error.image_not_found.title'] = 'Image not found';
$_lang['imageplus.error.image_not_found.msg'] = 'The image was not found and can\'t be cropped. Please select a different image.';
