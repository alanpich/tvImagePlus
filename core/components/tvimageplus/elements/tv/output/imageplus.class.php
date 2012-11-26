<?php 
class ImagePlusOutputRender extends modTemplateVarOutputRender {
    public function process($value,array $params = array()) {
    	// Load the helper library if its not already here
    	if(!class_exists('tvImagePlus')){ require_once $this->modx->getOption('core_path').'components/tvimageplus/tvImagePlus.class.php'; };
    	$this->helper = new tvImagePlus($this->modx);
        
    	return $this->helper->getImageURL($value,$params);
    }//
}
return 'ImagePlusOutputRender';
