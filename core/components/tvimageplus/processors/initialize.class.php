<?php

class ImagePlusInitializeProcessor extends ImagePlus\Processor\AbstractProcessor {

    public function process(){

        $newImage = $this->modx->newObject('imagePlusImage');
        $newImage->save();
        $newImageId = $newImage->get('id');

        return $this->success("TV Initialized",array(
                'id' => $newImageId
            ));

        return $this->failure('ImagePlusInitializeProcessor::process has not been implemented yet');
    }
}
return 'ImagePlusInitializeProcessor';