<?php

function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$snippets = array();

/**
 * Demo Output Snippet
 */
$s = $modx->newObject('modSnippet');
$s->fromArray(array(
        'name' => 'ImagePlus.demo',
        'description' => 'Demo output snippet for Image+',
        'snippet' => getSnippetContent(PKG_CORE.'elements/snippets/ImagePlus.demo.php'),
    ));
$snippets[] = $s;
$modx->log(xPDO::LOG_LEVEL_INFO,"Added snippet 'ImagePlus.demo' to package");

/**
 * Image renderer snippet
 */
$s = $modx->newObject('modSnippet');
$s->fromArray(array(
        'name' => 'image',
        'description' => 'Dynamic output renderer for Image+',
        'snippet' => getSnippetContent(PKG_CORE.'elements/snippets/image.php'),
    ));
$snippets[] = $s;
$modx->log(xPDO::LOG_LEVEL_INFO,"Added snippet 'image' to package");
