<?php

class tvImagePlus {

public $dataStr;


    function __construct(modX &$modx){
       $this->modx =& $modx;
       $this->loadConfig();
    }//

    
    private function loadConfig(){
        $core = $this->modx->getOption('core_path').'components/tvimageplus/';
        $assets = $this->modx->getOption('assets_url').'components/tvimageplus/';
        $this->config = array(
            'core_path' => $core,
            'assets_url' => $assets,
        );
    }//

    /**
     * Gather info about the TV
     * @param ImagePlusInputRender $render
     * @return object
     */
    public function loadTvConfig(ImagePlusInputRender $render, $value, array $params){
        $data = new stdClass;
        // Grab the ID of the assigned mediasource
        $data->mediaSource = $render->tv->getSource('web')->get('id');
        // Grab TV info
        $data->tv = new stdClass;
        $data->tv->id = $render->tv->get('id');
        $data->tv->params = $render->getInputOptions();    
        $data->tv->value = $value;
        // Misc
        $data->allowBlank = (bool)$params['allowBlank'];
        // Dimension constraints
        $data->targetWidth = (int)$params['targetWidth'];
        $data->targetHeight = (int)$params['targetHeight'];
        
        $saved = json_decode($value);
        if(is_null($saved)){
            // Crop data
            $data->crop = new stdClass();
            $data->crop->width = 0;
            $data->crop->height = 0;
            $data->crop->x = 0;
            $data->crop->y = 0;
            // Source image
            $data->sourceImg = new stdClass();
            $data->sourceImg->width = 0;
            $data->sourceImg->height = 0;
            $data->sourceImg->src = '';
            $data->sourceImg->source = 1; 
        } else {
             // Crop data
            $data->crop = new stdClass();
            $data->crop->width = $saved->crop->width;
            $data->crop->height = $saved->crop->height;
            $data->crop->x = $saved->crop->x;
            $data->crop->y = $saved->crop->y;
            // Source image
            $data->sourceImg = new stdClass();
            $data->sourceImg->width = $saved->sourceImg->width;
            $data->sourceImg->height = $saved->sourceImg->height;
            $data->sourceImg->src = $saved->sourceImg->src;
            $data->sourceImg->source = $saved->sourceImg->source;
        }
        
        return $data;        
    }//
    
    
    /**
     * Check if phpThumbOf is installed
     * @return bool
     */
    public function hasPhpThumbOf(){
        $pto = $this->modx->getObject('modSnippet',array('name'=>'phpthumbof'));
        return $pto instanceof modSnippet;
    }//
    
    /**
     * Return a scaled, cached version of the source image for front-end use
     * @param string $json
     * @param array $params
     * @return string
     */
    public function getImageURL($json, $params = array()){
        // Return error message if phpthumbof not found
        if(!$this->hasPhpThumbOf()){
            return "Image+ Error: PhpThumbOf Extra not found";
        }
    
		// Parse json to object
		$data = json_decode($json);
        
        // Load up the mediaSource
        $source = $this->modx->getObject('modMediaSource',$data->sourceImg->source);
        if(!$source instanceof modMediaSource){
            return 'Image+ Error: Invalid Media Source';
        };
        $source->initialize();
        
        // Grab absolute system path to image
        $imgPath = $source->getBasePath().$data->sourceImg->src;
        
		// Prepare arguments for phpthumbof snippet call
		$params = array(
			'src' => $imgPath,
			'w' => $data->targetWidth,
			'h' => $data->targetHeight,
			'far' => true,
			'sx' => $data->crop->x,
			'sy'=> $data->crop->y,
			'sw'=> $data->crop->width,
			'sh'=> $data->crop->height
		);
		$options = '';
		foreach($params as $key => $val){
			$options.= $key.'='.$val.'&';
		};
		
		// Call phpthumbof for url
		$url = $this->modx->runSnippet('phpthumbof',array(
				'options'=>$options,
				'input' => $imgPath
			));
		
		return $url;
	}//






};// end class tvImagePlus
define('tvimageplus',true);
