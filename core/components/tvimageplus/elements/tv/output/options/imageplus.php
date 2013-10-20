<?php

$path = $modx->getOption('tvimageplus.core_path',null,$modx->getOption('core_path').'components/tvimageplus/');
/** @var ImagePlus $imagePlus */
$imagePlus = $modx->getService('imagePlus','ImagePlus',$path);
$imagePlus->includeCoreScriptAssets();

$imagePlus->javascript('widget/imageplus.combo.outputtype.js');


$inlineJavascript = $imagePlus->javascriptAsInlineScript('widget/imageplus.combo.outputtype.js');
$inlineJavascript.= $imagePlus->javascriptAsInlineScript('tv/output/imageplus.panel.tvoutputoptions.js');

$modx->controller->setPlaceholder('tvimagepluslexicon',json_encode($imagePlus->config['lexicon']));
$modx->controller->setPlaceholder('inlineJavascript',$inlineJavascript);
$modx->controller->addLexiconTopic('tvimageplus:default');

return $modx->smarty->fetch($path.'elements/tv/output/options/imageplus.options.tpl');
