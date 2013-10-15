<?php

set_time_limit(0);

class ImagePlusRegenerateProcessor extends ImagePlus\Processor\AbstractProcessor {

    public function process()
    {
        $this->modx->log(xPDO::LOG_LEVEL_WARN,'[Image+] Regenerating entire cache... this might take a while...');
        $this->imagePlus->cacheManager->clearCache();

        // Get all images
        $images = $this->imagePlus->getImages();

        $total = 0;

        foreach($images as $image){
            $this->imagePlus->generateImageCache($image);
            $total++;
        }


        $this->imagePlus->removePhpThumbTempFilesCosItDoesntCleanUpAfterItselfProperly();

        return $this->success('Regeneration complete',array(
            'total' => $total,
        ));
    }

}
return 'ImagePlusRegenerateProcessor';