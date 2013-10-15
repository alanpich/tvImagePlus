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
        return $this->imagePlus->cacheManager->getImageUrl($this->get('id'));
    }


    /**
     * Override default save method to also regenerate cache image
     *
     * @param null $cacheFlag
     * @return bool
     */
    public function save($cacheFlag = null)
    {
        if (!parent::save()) {
            return false;
        }

        if($this->get('crop_w')<1 || $this->get('crop_h')<1){
            return true;
        }

        return $this->imagePlus->generateImageCache($this);
    }

}