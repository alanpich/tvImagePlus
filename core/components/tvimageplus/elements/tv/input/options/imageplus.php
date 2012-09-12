<?php 
$root = $modx->getOption('core_path').'components/tvimageplus/elements/tv/input/';

$modx->lexicon->load('tvimageplus:default');
$a = print_r($this->getInputProperties(),1);

$modx->controller->setPlaceholder('t_width',$a);


return $modx->smarty->fetch($root.'tpl/imageplus.options.tpl');
