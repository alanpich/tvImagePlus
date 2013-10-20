<?php

class ImagePlusUpdateProcessor extends ImagePlus\Processor\AbstractProcessor {

    public function process()
    {
        $uid = (int) $this->getProperty('uid');
        if(!$uid || $uid<1)
            return $this->failure("Invalud uid {$uid}");

        $image = $this->imagePlus->getImage($uid);
        if(!$image)
            return $this->failure("Unable to load ImagePlusImage #{$uid}");

        $json = $this->getProperty('data');
        if(!$json)
            return $this->failure('Invalid request');

        $data = json_decode($json);

        if(isset($data->crop->mediasource)){
            $image->set('mediasource',$data->crop->mediasource);
        }
        if(isset($data->crop->path)){
            $image->set('path',$data->crop->path);
        }
        if(isset($data->crop->crop_x))
            $image->set('crop_x',$data->crop->crop_x);
        if(isset($data->crop->crop_y))
            $image->set('crop_y',$data->crop->crop_y);
        if(isset($data->crop->crop_w))
            $image->set('crop_w',$data->crop->crop_w);
        if(isset($data->crop->crop_h))
            $image->set('crop_h',$data->crop->crop_h);
        if(isset($data->crop->output_width))
            $image->set('output_width',$data->crop->output_width);
        if(isset($data->crop->output_height))
            $image->set('output_height',$data->crop->output_height);


        if(!$image->save())
            return $this->failure("Failed to save image");

        $tvData = (object)array_merge((array)$data->tv,array(
            'url' => $image->getCacheUrl(),
            'original' => $image->getOriginalImageUrl(),
            'version' => $this->imagePlus->version,
        ));


        return $this->success('TV Updated',(object)array(
            'tv' => $tvData
        ));
    }
}
return 'ImagePlusUpdateProcessor';