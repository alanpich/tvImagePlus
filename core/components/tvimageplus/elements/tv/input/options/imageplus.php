<?php 
$root = $modx->getOption('tvimageplus.core_path',null,$modx->getOption('core_path').'components/tvimageplus/');
if(!class_exists('tvImagePlus')){ require $root.'tvImagePlus.class.php'; };
$helper = new tvImagePlus($modx);

$modx->lexicon->load('tvimageplus:default');
$a = print_r($this->getInputProperties(),1);

$modx->controller->setPlaceholder('t_width',$a);
$modx->controller->setPlaceholder('tvimagepluslexicon',json_encode($helper->config['lexicon']));
$modx->controller->addLexiconTopic('tvimageplus:default');


return $modx->smarty->fetch($root.'elements/tv/input/tpl/imageplus.options.tpl');
