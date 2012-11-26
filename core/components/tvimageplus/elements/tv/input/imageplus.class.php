<?php

class ImagePlusInputRender extends modTemplateVarInputRender {
    
    /* @var tvImagePlus $helper */
    private $helper;
    
    public function getTemplate() {
    	  return dirname(__FILE__).'/tpl/imageplus.inputrender.tpl';
    }//
    
    
    public function process($value,array $params = array()) {
        // Load helper class
        if(!class_exists('tvImagePlus')){ 
            require $this->modx->getOption('core_path').'components/tvimageplus/tvImagePlus.class.php'; };
        $this->helper = new tvImagePlus($this->modx);

        // Load required javascripts & register global config
        $this->modx->regClientCSS($this->helper->config['assets_url'].'mgr/css/jquery/jquery.jcrop.min.css');
        $this->modx->regClientStartupScript($this->helper->config['assets_url'].'mgr/js/tvimageplus.js');
        $this->modx->regClientStartupScript($this->helper->config['assets_url'].'mgr/js/tvimageplus.panel.input.js');
        $this->modx->regClientStartupScript($this->helper->config['assets_url'].'mgr/js/tvimageplus.window.editor.js');
        $this->modx->regClientStartupScript($this->helper->config['assets_url'].'mgr/js/tools/JSON2.js');
        $this->modx->regClientStartupScript($this->helper->config['assets_url'].'mgr/js/jquery/jquery.min.js');
        $this->modx->regClientStartupScript($this->helper->config['assets_url'].'mgr/js/jquery/jquery.jcrop.min.js');
        $this->modx->regClientStartupScript($this->helper->config['assets_url'].'mgr/js/tvimageplus.jquery.imagecrop.js');
        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">'
                                              .' tvImagePlus.config = '.json_encode($this->helper->config).';'
                                              .'</script>');
        
        // Prepare tv config for jsonification
        $tvConfig = $this->helper->loadTvConfig($this,$value,$params);
        $this->setPlaceholder('tvimageplusconfig',json_encode($tvConfig));
        $this->setPlaceholder('tvValue',$value);


        $this->setPlaceholder('mediasource',$this->tv->getSource('web')->get('id'));
        $this->setPlaceholder('tvparams',json_encode($this->getInputOptions()));

        $this->setPlaceholder('imgData',$this->getImageDataJSON($value,$params)); 
        return 'arse'; 	 
    	
    }
    
    
private function getImageDataJSON($value,$params){
		$I = json_decode($value);
		$Opts = $this->getInputOptions();
		
		$data = new stdClass;
		
		// Grab MediaSource info
		$MS = $this->tv->getSource('web')->toArray();
		$data->mediasource = new stdClass;
		$data->mediasource->id = $MS['id'];
		$data->mediasource->path = !isset($MS['properties']['basePath'])? $this->modx->getOption('base_path') : $MS['properties']['basePath']['value'];
		$data->mediasource->url = !isset($MS['properties']['baseUrl'])? $this->modx->getOption('base_url') : $MS['properties']['baseUrl']['value'];
		unset($MS);
		
		// Grab constraint info
		$data->constraint = new stdClass;
		$data->constraint->width =  empty($params['targetWidth']) ? 0 : (int) $params['targetWidth'];
		$data->constraint->height = empty($params['targetHeight'])? 0 : (int) $params['targetHeight'];
		
		// Generate ratio value
		if( $data->constraint->width >0 && $data->constraint->height >0 ){
			// If both width/height constraints set, use that for ratio calc
			$data->constraint->ratio = $data->constraint->width/$data->constraint->height;
		} else 
		if( isset($I->source->width) && isset($I->source->height) ){
			// Use source image size for ratio
			$data->constraint->ratio = $I->source->width / $I->source->height;
		} else {
			// Fail safe (and square)
			$data->constraint->ratio = false;
		};
		
		// Grab source image info (if it exists yet)
		if( isset($I->source) ){
			$data->source = new stdClass;
			$data->source->height = $I->source->height;
			$data->source->width = $I->source->width;
			$data->source->path = $I->source->path;
			$data->source->filename = $I->source->filename;
			$data->source->size = $I->source->size;
		} else {
			$data->source = false;
		};
		
		// Grab crop params (if they exist yet)
		if( isset($I->crop)){
			$data->crop = new stdClass;
			$data->crop->x = $I->crop->x;
			$data->crop->y = $I->crop->y;
			$data->crop->width = $I->crop->width;
			$data->crop->height = $I->crop->height;
		};
			
		return json_encode($data);
    }//

}
return 'ImagePlusInputRender';
