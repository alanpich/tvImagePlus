<?php class ImagePlusOutputRender extends modTemplateVarOutputRender {
    public function process($value,array $params = array()) {
    
    	// Load the helper library if its not already here
    	if(!defined('tvimageplus')){ require_once $this->modx->getOption('core_path').'components/tvimageplus/tvImagePlus.class.php'; };
    	
    	return tvImagePlus::getImageURL($value,$this->modx);
    }
}
return 'ImagePlusOutputRender';
