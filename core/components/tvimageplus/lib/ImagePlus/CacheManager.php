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
     * @param string $basePath    Base path relative to media source root
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
        $path = str_replace($filename, '', $this->getImagePath($uid));

        if (!strlen($filename)) {
            return false;
        }

        // Ensure dir exists
        $this->ms->createContainer($path, '/');
        // Write file
        $this->ms->removeObject($path . $filename);

        $success = $this->ms->createObject($path, $filename, $data);
        return $success;

    }


    public function readCacheFile(\imagePlusImage $image)
    {
        $uid = $image->get('id');
        $filename = $this->getImageFileName($uid);
        $path = str_replace($filename, '', $this->getImagePath($uid));
        $img = $this->ms->getObjectContents($path.$filename);
        return $img['content'];
    }


    /**
     * Check if a cache file exists for an image
     *
     * @param int $uid ID of image
     * @return bool
     */
    public function cacheFileExists($uid)
    {
        $path = $this->getImagePath($uid);
        if (strlen($path)) {

            $base = $this->ms->getBasePath();
            $full = $base . $path;

            if (file_exists($full)) {
                return true;
            }
        }
        return false;
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