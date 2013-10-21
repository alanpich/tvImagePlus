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
        $this->modx->loadClass('modPhpThumb', $this->modx->getOption('core_path') . 'model/phpthumb/', true, true);

        // Load the xPDO package
        $this->modx->addPackage('imageplus', $this->config['model_path']);

        // Ensure the db tables exist
        $mgr = $this->modx->getManager();
        //      $mgr->createObjectContainer('ImagePlusImage');

        // Load cache manager
        $msId = $this->config['cache_source'];
        $cacheMediaSource = $this->modx->getObject('modMediaSource', $msId);
        $cacheBasePath = $this->config['cache_path'];
        $this->cacheManager = new CacheManager($cacheMediaSource, $cacheBasePath);
    }


    /**
     * Retrieve an ImagePlusImage object by id
     *
     * @param int $uid Id of image
     * @return \ImagePlusImage|null
     */
    public function getImage($uid)
    {
        return $this->modx->getObject('ImagePlusImage', $uid);
    }

    public function getImages($filter = array())
    {
        return $this->modx->getCollection('ImagePlusImage', $filter);
    }

    public function createImage($data)
    {
        $img = $this->modx->newObject('ImagePlusImage');
        $img->fromArray($data);
        return $img;
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
        $this->javascript('widget/imageplus.combo.easyupload.js');
        $this->javascript('widget/imageplus.panel.previewimage.js');
        $this->javascript('widget/imageplus.window.croptool.js');
        $this->javascript('lib/jquery.min.js');
//        $this->javascript('lib/jquery.Jcrop.js');
        $this->javascript('lib/jquery.Jcrop.min.js');
        $this->javascript('lib/jquery.color.js');
        $this->javascript('tv/input/imageplus.panel.tvinput.js');
        $this->stylesheet('jquery.Jcrop.min.css');
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
        $this->javascript('imageplus.migx_renderer.js');
        $this->javascript('widget/imageplus.window.regeneratecache.js');
        $this->javascript('widget/imageplus.combo.snippet.js');
        $this->javascript('widget/imageplus.combo.chunk.js');
        $this->javascript('lib/stackblur.js');
        $this->javascript('lib/split.js');
        $this->stylesheet('imageplus.css');
        $this->modx->regClientStartupHTMLBlock('<script>
            ImagePlus.config = ' . $this->config->toJSON() . ';
            ImagePlus.mediaSourceUrlMap = ' . json_encode($this->getMediaSourceBaseUrls()) . ';
        </script>');
        $this->modx->regClientStartupHTMLBlock("<script>
            MODx.lang = Ext.apply(MODx.lang, " . $this->getLexiconJSON() . ");
        </script>");


        self::$core_javascripts_included = true;
    }


    /**
     * Load the contents of a javascript file, wrap it in <script>
     * tags, and return the string ready to write onto a page
     *
     * @param string $file JS file (also used as identifier slug)
     * @param string $path [optional] Path to js file if not default
     * @throws \Exception
     * @return string
     */
    public function javascriptAsInlineScript($file, $path = null)
    {
        if (is_null($path)) {
            $path = $this->config['assets_path'] . 'mgr/js/';
        }
        $filePath = rtrim($path,'/').'/'.ltrim($file,'/');
        if(!is_readable($filePath))
            throw new \Exception("Unable to load javascript file $filePath");

        $content = file_get_contents($filePath);
        return "<script>{$content}</script>";
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
     * @param \ImagePlusImage $image
     * @return bool
     */
    public function generateImageCache(\ImagePlusImage $image)
    {
        $uid = $image->get('id');

        $phpThumb = new \modPhpThumb($this->modx, array());

        // Grab the original image
        $original = $image->getOriginalImageData();

        if (is_null($original)) {
            $this->modx->log(\xPDO::LOG_LEVEL_ERROR, "[Image+] Failed to generate image for #{$uid} as source image at [" . $image->get('source') . ':' . $image->get('path') . "] is null");
            return false;
        }

        $phpThumb->setSourceData($original->content, $original->name);
        $phpThumb->setParameter('cache_source_enabled', false);

        if ($image->get('output_width') > 0)
            $phpThumb->setParameter('w', $image->get('output_width'));
        if ($image->get('output_height') > 0)
            $phpThumb->setParameter('h', $image->get('output_height'));
        $phpThumb->setParameter('sx', $image->get('crop_x'));
        $phpThumb->setParameter('sy', $image->get('crop_y'));
        $phpThumb->setParameter('sw', $image->get('crop_w'));
        $phpThumb->setParameter('sh', $image->get('crop_h'));
        $phpThumb->setParameter('q', 95);

        if ($image->get('output_width') > 0 && $image->get('output_height') > 0) {
            $phpThumb->setParameter('zc', false);
        } else {
            $phpThumb->setParameter('zc', true);
        }


        $img = false;
        if ($phpThumb->GenerateThumbnail()) {
            $phpThumb->RenderOutput();
            $img = $phpThumb->outputImageData;
            $this->cacheManager->writeCacheFile($image, $img);
            $this->removePhpThumbTempFilesCosItDoesntCleanUpAfterItselfProperly();
        } else {
            $this->modx->log(\xPDO::LOG_LEVEL_ERROR, "[Image+] Failed to generate image for #{$uid}");
            return false;
        }


        return true;
    }

    /**
     * Tidy up after phpThumb because its a messy bastard and leaves it's shit everywhere
     *
     * @return void
     */
    public function removePhpThumbTempFilesCosItDoesntCleanUpAfterItselfProperly()
    {
        /**
         * phpThumb creates cache files in the directory where
         * the script was initially called. In this case it is
         * assets/components/tvimageplus/mgr because that is
         * where the connector is. Kill them, kill them all!!!
         */
        $path = $this->config['assets_path'] . 'mgr/';
        foreach (glob("{$path}pThumb*") as $file) {
            unlink($file);
        }
    }


    /**
     * Return a JSON-encoded string containing the
     * Image+ lexicon for injecting into the MODx.lang object
     *
     * @return string
     */
    protected function getLexiconJSON()
    {
        $lex = $this->modx->lexicon;
        //@TODO make this use the correct language
        $ip = $lex->getFileTopic('en', 'tvimageplus');
        return json_encode($ip);
    }


    /**
     * Get an array of all mediasources in the format
     *   array( [ID] => [Base Url] )
     *
     * @return array
     */
    public function getMediaSourceBaseUrls()
    {
        $array = array();
        $sources = $this->modx->getCollection('modMediaSource');
        foreach ($sources as $src) {
            /** @var \modFileMediaSource $src */
            $src->initialize();
            $array[$src->get('id')] = $src->getBaseUrl();
        }
        return $array;
    }

}