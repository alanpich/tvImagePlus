<?php

$_lang['imageplus'] = "Image+";


$_lang['imageplus.editor_title'] = 'Редактор Image+';
$_lang['imageplus.edit_image'] = 'Редактировать изображение';
$_lang['imageplus.alt_text'] = 'Альтернатиный текст (alt)';

/** Input options render **/
$_lang['imageplus.targetwidth'] = 'Необходимая ширина';
$_lang['imageplus.targetwidth_desc'] = 'Необходимая ширина для вывода изображения';
$_lang['imageplus.targetheight'] = 'Необходимая высота';
$_lang['imageplus.targetheight_desc'] = 'Необходимая высота для вывода изображения';
$_lang['imageplus.targetRatio'] = 'Целевая пропорция';
$_lang['imageplus.targetRatio_desc'] = '(Необязательно) Цель пропорции для вывода изображения. Если задать целевой высоты и ширины targed, это значение игнорируется.';
$_lang['imageplus.thumbnailWidth'] = 'Ширина ярлыка';
$_lang['imageplus.thumbnailWidth_desc'] = '(Необязательно) Ширина изображения в шаблоне переменной панели.';
$_lang['imageplus.allowAltTag'] = 'Атрибут Alt';
$_lang['imageplus.allowAltTag_desc'] = 'Позволяет пользователю ввести заголовок/альтернативный текст для изображения';

/** Output options render **/
$_lang['imageplus.phpThumbParams'] = 'Дополнительный параметры phpThumb';
$_lang['imageplus.phpThumbParams_desc'] = 'Добавляет дополнительный фильтры и т.д. для phpThumb. Документацию можно найти <a target="_blank" href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt">здесь</a>.';
$_lang['imageplus.outputChunk'] = 'Чанк для вывода';
$_lang['imageplus.outputChunk_desc'] = 'Выберите чанк для вывода TV. Оствьте пустым для обычного вывода текстом';
$_lang['imageplus.generateUrl'] = 'Генерировать Thumb URL';
$_lang['imageplus.generateUrl_desc'] = '(Optional) The thumb url is maybe not necessary, if you generate the thumbnail in output chunk i.e. by a pthumb output filter.';

/** Placeholder descriptions */
$_lang['imageplus.placeholder.url'] = 'URL of the thumbnail image';
$_lang['imageplus.placeholder.alt'] = 'Альтернатиный текст (alt)';
$_lang['imageplus.placeholder.width'] = 'Width of the thumbnail image (ignored when 0)';
$_lang['imageplus.placeholder.height'] = 'Height of the thumbnail image (ignored when 0)';
$_lang['imageplus.placeholder.source.src'] = 'Путь к исходному изображению';
$_lang['imageplus.placeholder.source.width'] = 'Ширина исходного изображения';
$_lang['imageplus.placeholder.source.height'] = 'Высота исходного изображения';
$_lang['imageplus.placeholder.crop.width'] = 'Crop width of the source image';
$_lang['imageplus.placeholder.crop.height'] = 'Crop height of the source image';
$_lang['imageplus.placeholder.crop.x'] = 'Crop x position of the source image';
$_lang['imageplus.placeholder.crop.y'] = 'Crop y position of the source image';
$_lang['imageplus.placeholder.options'] = 'phpThumb option string to generate the thumbnail image';
$_lang['imageplus.placeholder.crop.options'] = 'phpThumb crop option string to generate the thumbnail image';
