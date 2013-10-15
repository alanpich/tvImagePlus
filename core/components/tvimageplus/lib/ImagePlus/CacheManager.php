<?php
namespace ImagePlus;

class CacheManager
{
    /** @var  \modMediaSource */
    public $ms;
    /**
     * @var string
     */
    private $basePath;

    /**
     * Cache manager bound to a media source
     *
     * @param \modMediaSource $mediaSource Media source to use
     * @param string          $basePath    Base path relative to media source root
     */
    public function __construct(\modMediaSource $mediaSource, $basePath = '/')
    {
        $this->ms = $mediaSource;
        $this->ms->initialize();
        $this->basePath = $basePath;
    }


    /**
     * Get absolute URL for a cached image by ID
     *
     * @param int $uid Id of image
     * @return string
     */
    public function getImageUrl($uid)
    {
        return $this->ms->getObjectUrl($this->getImagePath($uid));
    }


    /**
     * Get the path (including basePath) for a cache file
     * relative to mediaSource root
     *
     * @param int $uid ID of image
     * @return string
     */
    public function getImagePath($uid)
    {
        return $this->basePath . $this->getImageFileName($uid);
    }


    /**
     * Get the name to give to a cache file for a specified image id
     *
     * @param int $uid ID of image
     * @return string
     */
    public function getImageFileName($uid)
    {
        return $uid . '.jpg';
    }


    /**
     * Write data to a file for an image
     *
     * @param \imagePlusImage $image
     * @param                 $data
     * @return bool
     */
    public function writeCacheFile(\imagePlusImage $image, $data)
    {
        $uid = $image->get('id');
        $filename = $this->getImageFileName($uid);
        $path = str_replace($filename,'',$this->getImagePath($uid));

        if(!strlen($filename))
            return false;

        // Ensure dir exists
        $this->ms->createContainer($path,'/');
        // Write file
        $this->ms->removeObject($path.$filename);
        return $this->ms->createObject($path,$filename,$data);

    }



    /**
     * Delete all files in the cache
     *
     * @return void
     */
    public function clearCache()
    {

    }

} 