<?php

namespace ImagePlus\Configuration;


class TVData
{
    public $uid;
    public $url;
    public $alt;
    public $version;


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

    /**
     * Return data as a simple array
     * @return array
     */
    public function toArray(){
        return get_object_vars($this);
    }

}