<?php

namespace ImagePlus\Configuration;


class ImageData
{
    public $mediasource;
    public $path;
    public $crop_x;
    public $crop_y;
    public $crop_w;
    public $crop_h;
    public $output_width;
    public $output_height;


    /**
     * Hydrate object from an array or object
     * @param $data
     */
    public function fromArray($data)
    {
        foreach($data as $key => $val){
            if(property_exists(__CLASS__,$key))
                $this->$key = $val;
        }
    }

    public function toArray(){
        return get_object_vars($this);
    }

}