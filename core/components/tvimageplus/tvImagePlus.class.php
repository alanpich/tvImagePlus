<?php
/**
 * Copyright 2013 by Alan Pich <alan.pich@gmail.com>
 *
 * This file is part of tvImagePlus
 *
 * tvImagePlus is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * tvImagePlus is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * tvImagePlus; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package tvImagePlus
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */

use tvImagePlus\CropEngines;

class tvImagePlus
{

    public $dataStr;

    /** @var \modX */
    public $modx;

    public $config;


    function __construct(modX &$modx)
    {
        $this->modx =& $modx;
        $this->loadConfig();
        $this->loadLexicon();
        $this->loadSourceMap();
        $this->checkDependencies();
    }

    /**
     * Load default configuration
     */
    private function loadConfig()
    {
        $core = $this->modx->getOption(
            'tvimageplus.core_path',
            null,
            $this->modx->getOption('core_path') . 'components/tvimageplus/'
        );
        $assets = $this->modx->getOption(
            'tvimageplus.assets_url',
            null,
            $this->modx->getOption('assets_url') . 'components/tvimageplus/'
        );
        $this->config = array(
            'core_path' => $core,
            'assets_url' => $assets,
            'connectorUrl' => $assets . 'mgr/connector.php',
            'sources' => array(),
            'crop_icon' => $this->modx->getOption('tvimageplus.crop_icon', null, $assets . "mgr/icons/icon.crop.png"),
            'has_unmet_dependencies' => false,
        );
    }

    /**
     * Check dependencies and raise warnings if not met
     */
    private function checkDependencies()
    {
        // Register a micro autoloader for in-house engines
        spl_autoload_register(function ($className) {
            if (strpos($className, 'tvImagePlus\\CropEngines\\') === false)
                return;

            $class = str_replace('tvImagePlus\\CropEngines\\', '', $className);
            $path = dirname(__FILE__) . '/lib/CropEngines/' . $class . '.php';
            if (is_readable($path))
                include $path;

        });

        // Do some basic intelligent sniffing
            if( ! CropEngines\PhpThumbsUp::engineRequirementsMet($this->modx)
             && ! CropEngines\PhpThumbOf::engineRequirementsMet($this->modx) ){
                // Handle unmet dependencies
                $this->config['has_unmet_dependencies'] = TRUE;
            }
    }

    /**
     * Load the lexicon topic
     *
     * @todo Do it properly with MODx.lang _()
     */
    private function loadLexicon()
    {
        $lexicon = $this->modx->lexicon;
        $modx = $this->modx;
        $mgr_lang = $modx->getOption('manager_language');

        $lexicon->load('tvimageplus');

        if (in_array($mgr_lang, $lexicon->getLanguageList('tvimageplus'))) {
            $lang = $mgr_lang;
        } else {
            $lang = 'en';
        }

        $this->config['lexicon'] = $lexicon->getFileTopic($lang, 'tvimageplus');
    }

    /**
     * Get a map of MediaSource id => baseUrl
     *
     * @return void
     */
    private function loadSourceMap()
    {
        $sources = $this->modx->getCollection('sources.modMediaSource');
        foreach ($sources as $source) {
            /** @var modMediaSource $source */
            $source->initialize();
            $this->config['sources'][$source->get('id')] = new stdClass();
            $this->config['sources'][$source->get('id')]->url = $source->getBaseUrl();
        };
    }

    /**
     * Gather info about the TV
     *
     * @param ImagePlusInputRender $render
     * @param                      $value
     * @param array $params
     * @return object
     */
    public function loadTvConfig(ImagePlusInputRender $render, $value, array $params)
    {
        $data = new stdClass;
        // Grab the ID of the assigned mediasource
        $data->mediaSource = $render->tv->getSource('web')->get('id');
        // Grab TV info
        $data->tv = new stdClass;
        $data->tv->id = $render->tv->get('id');
        $data->tv->params = $render->getInputOptions();
        $data->tv->value = $value;
        // Misc
        $data->allowBlank = (bool)$params['allowBlank'];
        // Dimension constraints
        $data->targetWidth = (int)$params['targetWidth'];
        $data->targetHeight = (int)$params['targetHeight'];
        // Alt-tag options
        $data->altTagOn = (isset($params['allowAltTag']) && $params['allowAltTag'] == 'Yes');

        $saved = empty($value) ? null : json_decode($value);
        if (is_null($saved)) {
            // Crop data
            $data->crop = new stdClass();
            $data->crop->width = 0;
            $data->crop->height = 0;
            $data->crop->x = 0;
            $data->crop->y = 0;
            // Source image
            $data->sourceImg = new stdClass();
            $data->sourceImg->width = 0;
            $data->sourceImg->height = 0;
            $data->sourceImg->src = '';
            $data->sourceImg->source = 1;
            $data->altTag = ($data->altTagOn ? '' : false);
        } else {
            // Crop data
            $data->crop = new stdClass();
            $data->crop->width = $saved->crop->width;
            $data->crop->height = $saved->crop->height;
            $data->crop->x = $saved->crop->x;
            $data->crop->y = $saved->crop->y;
            // Source image
            $data->sourceImg = new stdClass();
            $data->sourceImg->width = $saved->sourceImg->width;
            $data->sourceImg->height = $saved->sourceImg->height;
            $data->sourceImg->src = $saved->sourceImg->src;
            $data->sourceImg->source = $saved->sourceImg->source;
            $data->altTag = ($data->altTagOn ? (isset($saved->altTag) ? $saved->altTag : '') : false);
        }

        return $data;
    }

    /**
     * Render supporting javascript to try and help it work with MIGX etc
     */
    public function includeScriptAssets()
    {
        $this->modx->regClientCSS($this->config['assets_url'] . 'mgr/css/jquery/jquery.jcrop.min.css');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/tvimageplus.js');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/tvimageplus.panel.input.js');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/tvimageplus.window.editor.js');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/tvimageplus.migx_renderer.js');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/tools/JSON2.js');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/jquery/jquery.min.js');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/jquery/jquery.jcrop.min.js');
        $this->modx->regClientStartupScript($this->config['assets_url'] . 'mgr/js/tvimageplus.jquery.imagecrop.js');
        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">'
        . ' tvImagePlus.config = ' . json_encode($this->config) . ';'
        . ' for(i in tvImagePlus.config.lexicon){ MODx.lang[i] = tvImagePlus.config.lexicon[i] }'
        . '</script>');
    }

    /**
     * Return a scaled, cached version of the source image for front-end use
     *
     * @param string $json
     * @param array $opts
     * @param modTemplateVar $tv
     * @internal param array $params
     * @return string
     */
    public function getImageURL($json, $opts = array(), modTemplateVar $tv)
    {

        // Check system settings for crop engine override
        $engineClass = $this->modx->getOption('tvimageplus.crop_engine_class', null, false);

        // Do some basic intelligent sniffing
        if (!$engineClass) {
            if( CropEngines\PhpThumbsUp::engineRequirementsMet($this->modx)) {
                $engineClass = '\\tvImagePlus\\CropEngines\\PhpThumbsUp';
            }
            else if( CropEngines\PhpThumbOf::engineRequirementsMet($this->modx)) {
                $engineClass = '\\tvImagePlus\\CropEngines\\PhpThumbOf';
            }
        }

        /**
         * @var tvImagePlus\CropEngines\AbstractCropEngine $cropEngine
         */
        $cropEngine = new $engineClass($this->modx);

        // Check crop engine is usable
        if (!$cropEngine->engineRequirementsMet($this->modx)) {
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, "Image+ :: Requirements not met for Crop Engine [{$engineClass}]");
            return 'IMAGE+ ERROR - requirements not met for crop engine';
        }

        return $cropEngine->getImageUrl($json, $opts, $tv);
    }

//    /**
//     * Check if a snippet exists by name
//     *
//     * @param string $snippet Name of snippet to check for
//     * @return bool
//     */
//    protected function snippetExists($snippet)
//    {
//        $obj = $this->modx->getObject('modSnippet', array(
//            'name' => $snippet
//        ));
//        return $obj instanceof modSnippet;
//    }

}
define('tvimageplus', true);
