<?php

class ImagePlusUpdateProcessor extends ImagePlus\Processor\AbstractProcessor {

    public function process()
    {
        $uid = (int) $this->getProperty('uid');
        if(!$uid || $uid<1)
            return $this->failure("Invalud uid {$uid}");

        $image = $this->imagePlus->getImage($uid);

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