<?php

class ImagePlusUploadProcessor extends ImagePlus\Processor\AbstractProcessor {

    public function process()
    {
        $uid = (int) $this->getProperty('uid');
        if(!$uid || $uid<1)
            return $this->failure("Invalud uid {$uid}");

        // Copy file to uploads dir
        $path = $this->imagePlus->config['assets_path'].'cache/uploads/'.$uid.'.jpg';
        move_uploaded_file($_FILES['file']['tmp_name'],$path);

        // Prepare the response
        $response = new \stdClass;
        $response->uid = $uid;
        $response->mediasource = 1;
        $response->path = 'assets/components/tvimageplus/cache/uploads/1.jpg';
        $response->url = 'assets/components/tvimageplus/cache/uploads/1.jpg';

        return $this->success('TV Updated',$response);
    }
}
return 'ImagePlusUploadProcessor';