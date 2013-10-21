<?php

function getChunkContent($filename) {
    $o = file_get_contents($filename);
    return $o;
}
$chunks = array();

/**
 * Demo Output Snippet
 */
$s = $modx->newObject('modChunk');
$s->fromArray(array(
        'name' => 'ImagePlus.demo',
        'description' => 'Demo output chunk for Image+',
        'snippet' => getChunkContent(PKG_CORE.'elements/chunks/ImagePlus.demo.html'),
    ));
$chunks[] = $s;
$modx->log(xPDO::LOG_LEVEL_INFO,"Added chunk 'ImagePlus.demo' to package");
