<?php
class imagePlusImage extends xPDOSimpleObject
{
    /** @var \xPDO */
    protected $modx;

    /** @var ImagePlus\ModxService */
    protected $imagePlus;

    public function __construct(\xPDO & $xpdo)
    {
        parent::__construct($xpdo);
        $this->modx = $xpdo;

        $path = $this->modx->getOption(
            'tvimageplus.core_path',
            null,
            $this->modx->getOption('core_path') . 'components/tvimageplus/'
        );
        $this->imagePlus = $this->modx->getService('imagePlus', 'ImagePlus', $path);
    }

    /**
     * Returns an absolute URL to the original image
     * that this crop was taken from
     *
     * @return string
     */
    public function getOriginalImageUrl()
    {
        $msId = $this->get('mediasource');
        if ($msId < 1) {
            return '';
        }

        /** @var modMediaSource $ms */
        $ms = $this->xpdo->getObject('modMediaSource', $msId);
        $ms->initialize();

        $url = $ms->getObjectUrl($this->get('path'));
        return $url;
    }


    /**
     * Returns an object with info about of the original image
     * that this crop was taken from, and the file's content
     *
     * @return string
     */
    public function getOriginalImageData()
    {
        $msId = $this->get('mediasource');
        $path = $this->get('path');
        if ($msId < 1 || is_null($path) || !strlen($path) ) {
            return null;
        }

        /** @var modMediaSource $ms */
        $ms = $this->xpdo->getObject('modMediaSource', $msId);
        $ms->initialize();

        $info = $ms->getObjectContents($path);

        if(!is_readable($info['path']))
            return null;

        $i = exif_imagetype($info['path']);

        $img = (object)array(
            'name' => $info['basename'],
            'mime' => image_type_to_mime_type($i),
            'ext'  => image_type_to_extension($i,false),
            'content' => $info['content'],
        );
        return $img;
    }


    /**
     * Gets absolute url for an image
     *
     * @return string
     */
    public function getCacheUrl()
    {
        return $this->imagePlus->cacheManager->getImageUrl($this->get('id')) .'?v='.$this->get('mtime');
    }


    public function getAsDataUri()
    {
        return $this->imagePlus->cacheManager->readCacheFile($this);
    }


    /**
     * Override default save method to also regenerate cache image
     *
     * @param null $cacheFlag
     * @return bool
     */
    public function save($cacheFlag = null)
    {
        $this->set('mtime',time());

        // If crop width & height is zero, image is killed so delete cache file
        if($this->get('crop_width')==0&&$this->get('crop_height')==0){
            $this->imagePlus->cacheManager->deleteCacheFile($this);
        }

        if (!parent::save()) {
            $this->modx->log(xPDO::LOG_LEVEL_ERROR,"[Image+] Failed to save xPDOObject for Image #".$this->get('id'));
            return false;
        }

        if($this->get('crop_w')<1 || $this->get('crop_h')<1){
            return true;
        }

        return $this->imagePlus->generateImageCache($this);
    }


    /**
     * Render output as a URL with an mtime parameter
     * for cachebusting
     *
     * @return string
     */
    public function renderUrl()
    {
        return $this->getCacheUrl();
    }

    /**
     * Render a snippet using this image's data as params
     * and return the output
     *
     * @param string|int $snippet Name or ID of snippet
     * @return string
     */
    public function renderSnippet($snippet)
    {
        $params = $this->asParams();
        if(is_numeric($snippet)){
            $snippet = $this->modx->getObject('modSnippet',$snippet);
            if($snippet instanceof modSnippet){
                return $snippet->process($params);
            } else {
                $this->modx->log(xPDO::LOG_LEVEL_ERROR,"Snippet {$snippet} does not exist");
            }
        } else {
            return $this->modx->runSnippet($snippet,$params);
        }
        return '';
    }

    /**
     * Render a chunk using this image's data as params
     * and return the input
     *
     * @param string|int $chunk Name or ID of the chunk
     * @return string
     */
    public function renderChunk($chunk)
    {
        $params = $this->asParams();
        if(is_numeric($chunk)){
            $chunk = $this->modx->getObject('modChunk',$chunk);
            if($chunk instanceof modChunk){
                return $chunk->process($params);
            } else {
                $this->modx->log(xPDO::LOG_LEVEL_ERROR,"Chunk {$chunk} does not exist");
            }
        } else {
            return $this->modx->parseChunk($chunk,$params);
        }
        return '';
    }

    /**
     * Render image as a base-64 encoded dataUri
     *
     * @return string
     */
    public function renderDataUri()
    {
        $cm = $this->imagePlus->cacheManager;
        $file = $cm->getCacheFile($this);
        //@TODO Finish this method
        return json_encode($file);
   }

}