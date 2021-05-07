<?php
$_lang['imageplus'] = 'Image+';
$_lang['imageplus.editor_title'] = 'Image+ Editor';
$_lang['imageplus.alt_text'] = 'Alt text';
$_lang['imageplus.caption'] = 'Título';
$_lang['imageplus.credits'] = 'Créditos';
/** Input options render **/
$_lang['imageplus.section'] = 'Image+ Options';
$_lang['imageplus.section_desc'] = 'Las siguientes opciones pueden ser anuladas por la configuración del contexto/sistema. Lea la <a href="https://jako.github.io/ImagePlus/usage/" target="_blank">documentación</a> para conocer las claves apropiadas en la configuración del contexto/sistema.';
$_lang['imageplus.selectConfig'] = 'Tamaños predefinidos de objetivos/relación de aspectos';
$_lang['imageplus.selectConfig_desc'] = 'Seleccione una proporción predefinida de tamaño y aspecto del objetivo. Las definiciones podrían crearse en los ajustes del sistema.';
$_lang['imageplus.selectConfigForce'] = 'Tamaños de objetivos predefinidos y relaciones de aspecto forzadas';
$_lang['imageplus.selectConfigForce_desc'] = 'Seleccionar forzosamente un tamaño de cultivo/relación de aspecto predefinido. Las definiciones podrían crearse en los ajustes del sistema.';
$_lang['imageplus.targetwidth'] = 'Ancho de la imagen';
$_lang['imageplus.targetwidth_desc'] = '(Opcional, Entero) El ancho objetivo para la imagen de salida. La imagen cargada debe tener esta anchura mínima.';
$_lang['imageplus.targetheight'] = 'Alto de la imagen';
$_lang['imageplus.targetheight_desc'] = '(Opcional, Entero) La altura objetivo para la imagen de salida. La imagen cargada debe tener esta altura mínima.';
$_lang['imageplus.targetRatio'] = 'Relación de aspecto objetivo';
$_lang['imageplus.targetRatio_desc'] = '(Opcional, Float) La relación de aspecto objetivo para la imagen de salida como valor float. Si se establecen la altura y la anchura objetivo, este valor se ignora.';
$_lang['imageplus.thumbnailWidth'] = 'Anchura de las miniaturas';
$_lang['imageplus.thumbnailWidth_desc'] = '(Opcional, Entero) El ancho de la miniatura de la imagen en el panel de variables de la plantilla.';
$_lang['imageplus.allowAltTag'] = 'Etiqueta Alt';
$_lang['imageplus.allowAltTag_desc'] = 'Permitir que el usuario introduzca un título/etiqueta de alto para la imagen.';
$_lang['imageplus.allowCaption'] = 'Mostrar campo de subtítulos';
$_lang['imageplus.allowCaption_desc'] = 'Permite al usuario introducir un título para la imagen.';
$_lang['imageplus.allowCredits'] = 'Mostrar campo de créditos';
$_lang['imageplus.allowCredits_desc'] = 'Permitir al usuario introducir un crédito para la imagen.';
/** Output options render **/
$_lang['imageplus.phpThumbParams'] = 'Parámetros phpThumb adicionales';
$_lang['imageplus.phpThumbParams_desc'] = 'Añade filtros adicionales etc a phpThumb. La documentación se puede encontrar <a href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt" target="_blank">aquí</a>.';
$_lang['imageplus.outputChunk'] = 'Resultado chunk';
$_lang['imageplus.outputChunk_desc'] = 'Selecciona un chunk para obtener un resultado del tv. Dejar en vacío para obtener un resultado de la url cruda.';
$_lang['imageplus.generateUrl'] = 'Generar la URL del pulgar';
$_lang['imageplus.generateUrl_desc'] = '(Opcional) La url de la miniatura puede no ser necesaria si se genera la miniatura en el chunk de salida, es decir, mediante un filtro de salida pthumb.';
$_lang['imageplus.generateUrl_desc_warning'] = 'Tiene que activar esta opción, cuando no especifica un chunk de salida en las opciones de salida o cuando utiliza el marcador de posición [[+url]] en el chunk de salida especificado. En caso contrario, la imagen no se recortará/redimensionará y se devolverá la ruta original de la imagen.';
/** Placeholder descriptions */
$_lang['imageplus.placeholder.url'] = 'URL de la imagen en miniatura';
$_lang['imageplus.placeholder.alt'] = 'Alt text';
$_lang['imageplus.placeholder.width'] = 'Ancho de la imagen en miniatura (se ignora si es 0)';
$_lang['imageplus.placeholder.height'] = 'Altura de la imagen en miniatura (se ignora si es 0)';
$_lang['imageplus.placeholder.source.src'] = 'Ruta de acceso a la imagen de origen';
$_lang['imageplus.placeholder.source.width'] = 'Anchura de la imagen de origen';
$_lang['imageplus.placeholder.source.height'] = 'Altura de la imagen de origen';
$_lang['imageplus.placeholder.crop.width'] = 'Ancho de recorte de la imagen de origen';
$_lang['imageplus.placeholder.crop.height'] = 'Altura de recorte de la imagen de origen';
$_lang['imageplus.placeholder.crop.x'] = 'Recorte de la posición x de la imagen de origen';
$_lang['imageplus.placeholder.crop.y'] = 'Posición de recorte y de la imagen de origen';
$_lang['imageplus.placeholder.options'] = 'Cadena de opciones phpThumb para generar la imagen en miniatura';
$_lang['imageplus.placeholder.crop.options'] = 'Cadena de opciones phpThumb para generar la imagen en miniatura';
$_lang['imageplus.error.image_too_small.title'] = 'Imagen demasiado pequeña';
$_lang['imageplus.error.image_too_small.msg'] = 'La imagen seleccionada es demasiado pequeña para ser utilizada aquí. Por favor, seleccione una imagen diferente.';
$_lang['imageplus.error.image_not_found.title'] = 'Imagen no encontrada';
$_lang['imageplus.error.image_not_found.msg'] = 'La imagen no fue encontrada y no puede ser recortada. Por favor, seleccione una imagen diferente.';
/** System settings **/
$_lang['area_imageplus'] = 'Image+';
$_lang['setting_imageplus.debug'] = 'Debug';
$_lang['setting_imageplus.debug_desc'] = 'Registrar información de depuración en el registro de errores de MODX.';
$_lang['setting_imageplus.select_config'] = 'Tamaños de cultivo/relación de aspecto predefinidos';
$_lang['setting_imageplus.select_config_desc'] = 'Cree relaciones predefinidas de tamaño y aspecto de los cultivos que se pueden seleccionar en las opciones variables de la plantilla.';
$_lang['setting_imageplus.force_config'] = 'Forzar tamaños de cultivo/relaciones de aspecto predefinidas';
$_lang['setting_imageplus.force_config_desc'] = 'Forzar el uso de proporciones predefinidas de tamaño y aspecto de los cultivos.';
/** System settings grid */
$_lang['setting_imageplus.configname'] = 'Name';
