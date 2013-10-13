<?php
require dirname(dirname(__FILE__)) . '/tvImagePlus.class.php';

class tvImagePlusRegenerateProcessor extends modProcessor
{
    /** @var  tvImagePlus */
    protected $helper;

    public function process()
    {
        $this->helper = new tvImagePlus($this->modx);
        // Find all image+ tvs
        $tvs = $this->modx->getCollection('modTemplateVar', array(
            'type' => 'imageplus'
        ));

        $start_time = microtime(true);
        $total = 0;

        /** @var modTemplateVar $tv */
        foreach ($tvs as $tv) {
            $tvId = (int) $tv->get('id');
            $resources = $this->modx->getCollection('modTemplateVarResource', array(
                'tmplvarid' => $tvId
            ));

            /** @var modTemplateVarResource $res */
            foreach ($resources as $res) {
                ++ $total;
                $resId = (int) $res->get('contentid');
                $json = $res->get('value');
                $attempt = $this->regenerateThumb($resId,$tvId,$json);
                if($attempt !== true){
                    return $this->failure($attempt);
                }
            }
        }

        $time = round(microtime(true) - $start_time, 4);
        return $this->success("Regenerated {$total} images in {$time}s");
    }



    protected function regenerateThumb($resId, $tvId, $json)
    {
        $data = json_decode($json);

        // Load up the media source
        $mediaSourceId = (int)$data->sourceImg->source;
        /** @var modMediaSource $ms */
        $ms = $this->modx->getObject('modMediaSource', $mediaSourceId);
        if (!$ms instanceof modMediaSource)
            return "Invalid media source id {$mediaSourceId}";
        $ms->initialize();

        // Check the image exists
        $imgPath = $data->sourceImg->src;
        if (!$imgPath)
            return $this->failure("No image path supplied");
        if (!$sourceImgData = $ms->getObjectContents($imgPath))
            return "Invalid image path {$imgPath}";

        // Load up the TV
        $tvId = (int)$tvId;
        $tv = $this->modx->getObject('modTemplateVar', $tvId);
        if (!$tv instanceof modTemplateVar)
            return "Invalid TV id {$tvId}";

        // Grab target width & height from TV config
        $settings = unserialize($tv->input_properties);
        $width = $settings['targetWidth'];
        $height = $settings['targetHeight'];

        // Load up the resource
        $resId = (int)$resId;
        $res = $this->modx->getObject('modResource', $resId);
        if (!$res instanceof modResource)
            return "Invalid resource id {$resId}";
        unset($res);

        // Generate the thumb!
        $thumbImg = $this->helper->generateImage($sourceImgData['content'], array(
            'w' => $width,
            'h' => $height,
            'far' => true,
            'sx' => $data->crop->x,
            'sy' => $data->crop->y,
            'sw' => $data->crop->width,
            'sh' => $data->crop->height
        ));

        $this->helper->cacheImage($resId, $tvId, $thumbImg);

        return true;
    }
}

return 'tvImagePlusRegenerateProcessor';


