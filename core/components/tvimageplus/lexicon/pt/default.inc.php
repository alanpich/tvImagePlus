<?php

$_lang['imageplus'] = "Image+";


$_lang['tvimageplus.editor_title'] = 'Editor Image+';
$_lang['tvimageplus.edit_image'] = 'Editar Imagem';
$_lang['tvimageplus.are_you_sure'] = 'Tem a certeza que quer fazr isso?';
$_lang['tvimageplus.please_wait'] = 'Por favor espere...';


/** TV input render */
$_lang['tvimageplus.err_crop_too_small'] = 'A selecção para cortar é muito pequena';
$_lang['tvimageplus.err_crop_too_small_desc'] = 'A área seleccionada para cortar é mais pequena do que o tamanho necessário para esta imagem.'
                                               .'Isto significa que a imagem vai ser redimensionad apara ajustar. <br /><br /><strong>Não faça isto, vai fazer com que o seu site fique com mau aspecto.</strong>';

/** Input options render **/
$_lang['tvimageplus.targetwidth'] = 'Largura';
$_lang['tvimageplus.targetwidth_desc'] = 'A largura definida para a imagem final';
$_lang['tvimageplus.targetheight'] = 'Altura';
$_lang['tvimageplus.targetheight_desc'] = 'A altura definida para a imagem final';
$_lang['tvimageplus.allowAltTag'] = 'Adicionar eitqueta';
$_lang['tvimageplus.allowAltTag_desc'] = 'Permitir ao utilizador para intriduzir um titulo/etiqueta para a imagem';

/** Output options render **/
$_lang['tvimageplus.output_options'] = 'Image+ Opções de rederização';
$_lang['tvimageplus.output_type'] = 'Image+ tipo de saída';
$_lang['tvimageplus.phpThumbParams'] = 'Parametros adicionais para miniaturas';
$_lang['tvimageplus.phpThumbParams_desc'] = 'Adiciona filtros adicionais para phpThumb. Documentação pode ser encontrada <a target="_blank" href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt">aqui</a>.';
$_lang['tvimageplus.outputChunk'] = 'Saída';
$_lang['tvimageplus.outputChunk_desc'] = 'Selecione o pedaço para saida de tv. deixe em branco para saíde de url simples';


/** Output options render **/
$_lang['tvimageplus.output_render.url'] = 'URL';
$_lang['tvimageplus.output_render.url.info'] = 'Retorna o URL para a imagem cortada. Se o cachebuster está activo, é adicionado o tempo actual ao URL para garantir que a última versão está a ser usada';
$_lang['tvimageplus.output_render.chunk'] = 'Bloco';
$_lang['tvimageplus.output_render.chunk.info'] = 'O bloco selecionado vai ser chamado e vai passar os seguintes espaços reservados:';
$_lang['tvimageplus.output_render.snippet'] = 'Amostra';
$_lang['tvimageplus.output_render.snippet.info'] = 'A amostra selecionada vai ser chamada e recebe os seguinte parametros:';
$_lang['tvimageplus.output_render.datauri'] = 'Data URI';
$_lang['tvimageplus.output_render.datauri.info'] = 'Base64 codifica a imagem em dados no endereço para que a imagem fique disponivel assim que o DOM é carregado.';


$_lang['tvimageplus.select_chunk'] = 'Selecione bloco';
$_lang['tvimageplus.select_snippet'] = 'Selecione amostra';

/** Output placeholder descriptions */
$_lang['tvimageplus.placeholder.uid']       = 'Identificador único para a instancia do Image+';
$_lang['tvimageplus.placeholder.url']       = 'Endreço absoluto da imagem recortada';
$_lang['tvimageplus.placeholder.width']     = 'Largura da imagem';
$_lang['tvimageplus.placeholder.height']    = 'Altura da imagem';
$_lang['tvimageplus.placeholder.mtime']     = 'Timestamp quando é gerada a imagem em cache';
$_lang['tvimageplus.placeholder.original']  = 'Endereço absoluto para a imagem original';
$_lang['tvimageplus.placeholder.alt']       = 'Etiqueta';
$_lang['tvimageplus.placeholder.image']     = 'xPDOObject representa a imagem (Só para uso avançado)';

/** Cache regenerator render */
$_lang['tvimageplus.regenerate_cache'] = 'Actualizar cache Image+';
$_lang['tvimageplus.regenerating_cache'] = 'Actualizar cache Image+... isto pode demorar um bocado...';
$_lang['tvimageplus.regenerate_cache_desc'] = 'Actualiza a imagem recortada para todas as Image+ TVs';
$_lang['tvimageplus.regenerate_cache_simple_button'] = 'Iniciar actualiação simples';


