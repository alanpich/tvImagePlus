<?php
/**
 * Copyright 2013 by Alan Pich <alan.pich@gmail.com>
 *
 * This file is part of ImagePlus
 *
 * ImagePlus is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ImagePlus is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ImagePlus; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package imageplus
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */

use ImagePlus\CropEngines;

class ImagePlus
{
    /**
     * A reference to the modX instance
     * @var modX $modx
     */
    public $modx;

    /**
     * The namespace
     * @var string $namespace
     */
    public $namespace = 'imageplus';

    /**
     * The version
     * @var string $version
     */
    public $version = '2.3.0';

    /**
     * The class options
     * @var array $options
     */
    public $options = array();

    /**
     * ImagePlus constructor
     *
     * @param modX $modx A reference to the modX instance.
     * @param array $options An array of options. Optional.
     */
    function __construct(modX &$modx, $options = array())
    {
        $this->modx = &$modx;

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path') . 'components/delicart/');
        $assetsPath = $this->getOption('assets_path', $options, $this->modx->getOption('assets_path') . 'components/delicart/');
        $assetsUrl = $this->getOption('assets_url', $options, $this->modx->getOption('assets_url') . 'components/delicart/');

        // Load some default paths for easier management
        $this->options = array_merge(array(
            'namespace' => $this->namespace,
            'version' => $this->version,
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'vendorPath' => $corePath . 'vendor/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'pagesPath' => $corePath . 'elements/pages/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'pluginsPath' => $corePath . 'elements/plugins/',
            'controllersPath' => $corePath . 'controllers/',
            'processorsPath' => $corePath . 'processors/',
            'templatesPath' => $corePath . 'templates/',
            'configPath' => $corePath . 'config/',
            'countryConfigPath' => $corePath . 'config/countries/',
            'connectorUrl' => $assetsUrl . 'connector.php',
        ), $options);

        // set default options
        $this->options = array_merge($this->options, array(
            'sources' => $this->loadSourceMap(),
            'has_unmet_dependencies' => $this->checkDependencies()
        ));

        $this->modx->lexicon->load('imageplus:default');
    }

    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override local options.
     * @param mixed $default The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getOption($key, $options = array(), $default = null)
    {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->options)) {
                $option = $this->options[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    /**
     * Check dependencies and raise warnings if not met
     */
    private function checkDependencies()
    {
        // Register a micro autoloader for in-house engines
        spl_autoload_register(function ($className) {
            if (strpos($className, 'ImagePlus\\CropEngines\\') === false) {
                return;
            }
            $class = str_replace('ImagePlus\\CropEngines\\', '', $className);
            $path = realpath(dirname(__FILE__) . '/../cropengines/' . $class . '.php');
            if (is_readable($path)) {
                include $path;
            }
        });

        // Do some basic intelligent sniffing
        if (!CropEngines\PhpThumbsUp::engineRequirementsMet($this->modx)
            && !CropEngines\PhpThumbOf::engineRequirementsMet($this->modx)
        ) {
            // Handle unmet dependencies
            return true;
        }
        return false;
    }

    /**
     * Get a map of MediaSource id => baseUrl
     *
     * @return array
     */
    private function loadSourceMap()
    {
        $sources = $this->modx->getCollection('sources.modMediaSource');
        $sourceMap = array();
        foreach ($sources as $source) {
            /** @var modMediaSource $source */
            $source->initialize();
            $sourceMap[$source->get('id')] = new stdClass();
            $sourceMap[$source->get('id')]->url = $source->getBaseUrl();
        };
        return $sourceMap;
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
        $data->mediaSource = $render->tv->get('source');
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
        $data->targetRatio = $params['targetRatio'];
        // Thumbnail width options
        $vers = $this->modx->getVersionData();
        $data->thumbnailWidth = (isset($params['thumbnailWidth']) && intval($params['thumbnailWidth'])) ? intval($params['thumbnailWidth']) : (($vers['major_version'] >= 3) ? 400 : 150);
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
            // Alt-tag
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
            // Alt-tag
            $data->altTag = ($data->altTagOn ? (isset($saved->altTag) ? $saved->altTag : '') : false);
        }

        return $data;
    }

    /**
     * Render supporting javascript to try and help it work with MIGX etc
     */
    public function includeScriptAssets()
    {
        $vers = $this->modx->getVersionData();
        if ($vers['major_version'] >= 3) {
            $this->modx->regClientCSS($this->options['assetsUrl'] . 'mgr/css/imageplus.css');
        } else {
            $this->modx->regClientCSS($this->options['assetsUrl'] . 'mgr/css/imageplus-22.css');
        }
        $this->modx->regClientCSS($this->options['assetsUrl'] . 'mgr/css/jquery/jquery.jcrop.min.css');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.js');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.panel.input.js');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.window.editor.js');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.migx_renderer.js');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/tools/JSON2.js');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/jquery/jquery.min.js');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/jquery/jquery.jcrop.min.js');
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.jquery.imagecrop.js');
        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">'
            . ' ImagePlus.config = ' . json_encode($this->options) . ';'
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
        $engineClass = $this->modx->getOption('imageplus.crop_engine_class', null, false);

        // Do some basic intelligent sniffing
        if (!$engineClass) {
            if (CropEngines\PhpThumbsUp::engineRequirementsMet($this->modx)) {
                $engineClass = '\\ImagePlus\\CropEngines\\PhpThumbsUp';
            } else if (CropEngines\PhpThumbOf::engineRequirementsMet($this->modx)) {
                $engineClass = '\\ImagePlus\\CropEngines\\PhpThumbOf';
            }
        }

        /**
         * @var ImagePlus\CropEngines\AbstractCropEngine $cropEngine
         */
        $cropEngine = new $engineClass($this->modx);

        // Check crop engine is usable
        if (!$cropEngine->engineRequirementsMet($this->modx)) {
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, "Requirements not met for crop engine [{$engineClass}]", '', 'Image+');
            return 'Image+ error - requirements not met for crop engine';
        }

        return $cropEngine->getImageUrl($json, $opts, $tv);
    }
}

define('imageplus', true);
