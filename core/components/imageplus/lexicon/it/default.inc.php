<?php

$_lang['imageplus'] = 'Image+';


$_lang['imageplus.editor_title'] = 'Image+ Editor';
$_lang['imageplus.edit_image'] = 'Modifca Immagine';
$_lang['imageplus.alt_text'] = 'Alt text';

/** Input options render **/
$_lang['imageplus.targetwidth'] = 'Larghezza';
$_lang['imageplus.targetwidth_desc'] = 'La larghezza desiderata per l\'immagine finale';
$_lang['imageplus.targetheight'] = 'Altezza';
$_lang['imageplus.targetheight_desc'] = 'L\'altezza desiderata per l\'immagine finale';
$_lang['imageplus.targetRatio'] = 'Target Aspect Ratio';
$_lang['imageplus.targetRatio_desc'] = '(Optional, Float) The target aspect ratio for the output image as float value. If the target height and the targed width are set, this value is ignored.';
$_lang['imageplus.thumbnailWidth'] = 'Thumbnail Width';
$_lang['imageplus.thumbnailWidth_desc'] = '(Optional, Integer) The thumbnail width of the image in the template variable panel.';
$_lang['imageplus.allowAltTag'] = 'Tag alt';
$_lang['imageplus.allowAltTag_desc'] = 'Consente all\'utente di inserire un titolo/tag-alt per l\'immagine';

/** Output options render **/
$_lang['imageplus.phpThumbParams'] = 'Parametri aggiuntivi di phpThumb';
$_lang['imageplus.phpThumbParams_desc'] = 'Aggiungi filtri aggiuntivi ecc. per phpThumb. La documentazione può essere trovata <a target="_blank" href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt">qui</a>.';
$_lang['imageplus.outputChunk'] = 'Chunk Output';
$_lang['imageplus.outputChunk_desc'] = 'Seleziona un chunk per l\'output della variabile tv. Lascia vuoto per avere un output del semplice url';
$_lang['imageplus.generateUrl'] = 'Generate Thumb URL';
$_lang['imageplus.generateUrl_desc'] = '(Optional) The thumb url is maybe not necessary, if you generate the thumbnail in output chunk i.e. by a pthumb output filter.';

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
