<?php

require dirname(dirname(__FILE__)) . '/tvImagePlus.class.php';

class tvImagePlusGenerateImageProcessor extends modProcessor
{
    /** @var  tvImagePlus */
    public $helper;

    public function process()
    {
        $this->helper = new tvImagePlus($this->modx);

        // Load up the media source
        $mediaSourceId = (int)$this->getProperty('ms');
        /** @var modMediaSource $ms */
        $ms = $this->modx->getObject('modMediaSource', $mediaSourceId);
        if (!$ms instanceof modMediaSource)
            return $this->failure("Invalid media source id {$mediaSourceId}");
        $ms->initialize();

        // Check the image exists
        $imgPath = $this->getProperty('img');
        if (!$imgPath)
            return $this->failure("No image path supplied");
        if (!$sourceImgData = $ms->getObjectContents($imgPath))
            return $this->failure("Invalid image path {$imgPath}");

        // Load up the TV
        $tvId = (int)$this->getProperty('tv');
        $tv = $this->modx->getObject('modTemplateVar', $tvId);
        if (!$tv instanceof modTemplateVar)
            return $this->failure("Invalid TV id {$tvId}");

        // Grab target width & height from TV config
        $settings = unserialize($tv->input_properties);
        $width = $settings['targetWidth'];
        $height = $settings['targetHeight'];

        // Load up the resource
        $resId = (int)$this->getProperty('res');
        $res = $this->modx->getObject('modResource', $resId);
        if (!$res instanceof modResource)
            return $this->failure("Invalid resource id {$resId}");
        unset($res);


        // Gather crop dimensions
        $cx = (int)$this->getProperty('x');
        $cy = (int)$this->getProperty('y');
        $cw = (int)$this->getProperty('w');
        $ch = (int)$this->getProperty('h');

        // Generate the thumb!
        $thumbImg = $this->helper->generateImage($sourceImgData['content'], array(
            'w' => $width,
            'h' => $height,
            'far' => true,
            'sx' => $cx,
            'sy' => $cy,
            'sw' => $cw,
            'sh' => $ch
        ));


        $this->helper->cacheImage($resId, $tvId, $thumbImg);

        return $this->success();
    }

}

return 'tvImagePlusGenerateImageProcessor';