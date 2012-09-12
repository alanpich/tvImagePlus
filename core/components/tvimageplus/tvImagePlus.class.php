<?php

class tvImagePlus {

public $dataStr;


public static function getImageURL( $json, &$modx){
		// Parse json to object
		$data = json_decode($json);
		
		// Prepare arguments for phpthumbof snippet call
		$imgPath = $data->mediasource->path.$data->source->path.$data->source->filename;
		$params = array(
			'src' => $imgPath,
			'w' => $data->constraint->width,
			'h' => $data->constraint->height,
			'far' => true,
			'zc' => true
		);
		$options = '';
		foreach($params as $key => $val){
			$options.= $key.'='.$val.'&';
		};
		
		// Call phpthumbof for url
		$url = $modx->runSnippet('phpthumbof',array(
				'options'=>$options,
				'input' => $imgPath
			));
		
		return $url;
	}//






};// end class tvImagePlus
define('tvimageplus',true);
