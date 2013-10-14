<?php

namespace ImagePlus;

class ModxService
{
    /** @var  \modX */
    public $modx;

    /** @var Configuration\ModxConfiguration */
    public $config;

    /** @var  CacheManager */
    public $cacheManager;

    protected static $included_javascripts = array();
    protected static $included_stylesheets = array();
    protected static $core_javascripts_included = false;

    public $version = '3.0.0';

    /**
     * Create a new instance
     *
     * @param \modX $modx MODX Instance
     * @param array $opts Addiiional options
     */
    public function __construct(\modX $modx, $opts = array())
    {
        $this->modx = $modx;
        $this->config = new Configuration\ModxConfiguration($modx);

        // Load the lexicon
        $this->modx->lexicon->load('tvimageplus:default');

        // Load the phpThumb class
        $this->modx->loadClass('modPhpThumb',$this->modx->getOption('core_path').'model/phpthumb/',true,true);

        // Load the xPDO package
        $this->modx->addPackage('imageplus', $this->config['model_path']);

        // Ensure the db tables exist
        $mgr = $this->modx->getManager();
//        $mgr->createObjectContainer('imagePlusImage');

        // Load cache manager
        $msId = $this->config['cache_source'];
        $cacheMediaSource = $this->modx->getObject('modMediaSource', $msId);
        $cacheBasePath = $this->config['cache_path'];
        $this->cacheManager = new CacheManager($cacheMediaSource, $cacheBasePath);
    }


    /**
     * Retrieve an imagePlusImage object by id
     *
     * @param int $uid Id of image
     * @return \imagePlusImage|null
     */
    public function getImage($uid)
    {
        return $this->modx->getObject('imagePlusImage', $uid);
    }


    /**
     * Get the absolute URL to a cached image by id
     *
     * @param int $uid Id of image
     * @return string
     */
    public function getImageUrl($uid)
    {
        return $this->cacheManager->getImageUrl($uid);
    }


    /**
     * Includes the relevant javascript and css assets into a mgr
     * page for TV input rendering
     *
     * @return void
     */
    public function includeScriptAssets()
    {
        $this->includeCoreScriptAssets();
        $this->javascript('widget/imageplus.combo.browser.js');
        $this->javascript('widget/imageplus.panel.previewimage.js');
        $this->javascript('tv/input/imageplus.panel.tvinput.js');
    }

    /**
     * Includes the core library and config into a mgr page
     * (but only once)
     *
     * @return void
     */
    public function includeCoreScriptAssets()
    {
        if (self::$core_javascripts_included) {
            return;
        }

        $this->javascript('imageplus.js');
        $this->javascript('imageplus.image.js');
        $this->javascript('lib/split.js');
        $this->stylesheet('imageplus.css');
        $this->modx->regClientStartupHTMLBlock(
            '<script>
                        ImagePlus.config = ' . $this->config->toJSON() . ';
        </script>'
        );

        self::$core_javascripts_included = true;
    }

    /**
     * Include a javascript file, but only once
     *
     * @param string $file JS file (also used as identifier slug)
     * @param string $path [optional] Path to js file if not default
     */
    public function javascript($file, $path = null)
    {
        if (is_null($path)) {
            $path = $this->config['mgr_url'] . 'js/';
        }
        $url = rtrim($path, '/') . '/' . ltrim($file, '/');
        if (!in_array($url, self::$included_javascripts)) {
            $this->modx->regClientStartupScript($url);
            self::$included_javascripts[] = $url;
        };
    }

    /**
     * Include a css stylesheet file, but only once
     *
     * @param string $file CSS file (also used as identifier slug)
     * @param string $path [optional] Path to css file if not default
     */
    public function stylesheet($file, $path = null)
    {
        if (is_null($path)) {
            $path = $this->config['mgr_url'] . 'css/';
        }
        $url = rtrim($path, '/') . '/' . ltrim($file, '/');
        if (!in_array($url, self::$included_stylesheets)) {
            $this->modx->regClientCSS($url);
            self::$included_stylesheets[] = $url;
        };
    }


    /**
     * Generate an cropped image cache for an Image
     *
     * @param \imagePlusImage $image
     */
    public function generateImageCache(\imagePlusImage $image)
    {
        $phpThumb = new \modPhpThumb($this->modx,array());

        // Grab the original image
        $original = $image->getOriginalImageData();

        $phpThumb->setSourceData($original->content,$original->name);
        $phpThumb->setParameter('w',400);


        $img = false;
        if($phpThumb->GenerateThumbnail()){
            $phpThumb->RenderOutput();
            $img = $phpThumb->outputImageData;
        }

        $this->removePhpThumbTempFilesCosItDoesntCleanUpAfterItselfProperly();

        $this->cacheManager->writeCacheFile($image,$img);

    }

    /**
     * Tidy up after phpThumb because its a messy bastard and leaves it's shit everywhere
     *
     * @return void
     */
    protected function removePhpThumbTempFilesCosItDoesntCleanUpAfterItselfProperly()
    {
        /**
         * phpThumb creates cache files in the directory where
         * the script was initially called. In this case it is
         * assets/components/tvimageplus/mgr because that is
         * where the connector is. Kill them, kill them all!!!
         */
        $path = $this->config['assets_path'].'mgr/';
        foreach(glob("{$path}pThumb*") as $file){
            unlink($file);
        }
    }


}