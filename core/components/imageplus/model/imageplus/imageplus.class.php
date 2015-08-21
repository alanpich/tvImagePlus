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

/**
 * Class ImagePlus
 */
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
    public $version = '2.4.0';

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

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path') . 'components/imageplus/');
        $assetsPath = $this->getOption('assets_path', $options, $this->modx->getOption('assets_path') . 'components/imageplus/');
        $assetsUrl = $this->getOption('assets_url', $options, $this->modx->getOption('assets_url') . 'components/imageplus/');

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
            'connectorUrl' => $assetsUrl . 'connector.php',
        ), $options);

        // set default options
        $this->options = array_merge($this->options, array(
            'sources' => $this->loadSourceMap()
        ));

        $this->checkDependencies();

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
        if (!$this->options['cropEngineClass']) {
            if (CropEngines\PhpThumbsUp::engineRequirementsMet($this->modx)) {
                $this->options['cropEngineClass'] = '\\ImagePlus\\CropEngines\\PhpThumbsUp';
            } else if (CropEngines\PhpThumbOf::engineRequirementsMet($this->modx)) {
                $this->options['cropEngineClass'] = '\\ImagePlus\\CropEngines\\PhpThumbOf';
            }
            if (!$this->options['cropEngineClass']) {
                // Handle unmet dependencies
                $this->options['hasUnmetDependencies'] = true;
                return true;
            }
        }
        $this->options['hasUnmetDependencies'] = false;
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
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.js?v=v' . $this->version);
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.panel.input.js?v=v' . $this->version);
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.window.editor.js?v=v' . $this->version);
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.migx_renderer.js?v=v' . $this->version);
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/tools/JSON2.js?v=v' . $this->version);
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/jquery/jquery.min.js?v=v' . $this->version);
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/jquery/jquery.jcrop.min.js?v=v' . $this->version);
        $this->modx->regClientStartupScript($this->options['assetsUrl'] . 'mgr/js/imageplus.jquery.imagecrop.js?v=v' . $this->version);
        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">'
            . ' ImagePlus.config = ' . json_encode($this->options) . ';'
            . ' var $jIP = jQuery.noConflict();'
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
        $engineClass = $this->getOption('cropEngineClass');

        /**
         * @var ImagePlus\CropEngines\AbstractCropEngine $cropEngine
         */
        $cropEngine = new $engineClass($this->modx, array(
            'core_path' => $this->getOption('corePath')
        ));

        // Check crop engine is usable
        if ($this->options['hasUnmetDependencies']) {
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, 'Requirements not met for crop engine.', '', 'Image+');
            return 'Image+ error - requirements not met for crop engine.';
        }

        $json = $this->prepareTvValue($json, $opts, $tv);
        return $cropEngine->getImageUrl($json, $opts, $tv);
    }

    /**
     * Prepare a JSON encoded object and return a valid JSON encoded Image+ object
     *
     * @param $json JSON value to prepare
     * @param array $opts
     * @param modTemplateVar $tv
     * @return string
     */
    public function prepareTvValue($json, $opts = array(), modTemplateVar $tv)
    {
        // Prepare value
        $decoded = json_decode($json);
        if (!$decoded) {
            // The variable does not contain an Image+ image object
            if ($json != '') {
                // Get Media Source
                /** @var modMediaSource $source */
                if ($tv) {
                    $source = $tv->getSource(($this->modx->resource) ? $this->modx->resource->get('context_key') : 'mgr');
                } else {
                    $source = $this->modx->getObject('modMediaSource', $this->modx->getOption('default_media_source'));
                }
                if (!($source && $source->getWorkingContext())) {
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, 'Invalid Media Source', '', 'Image+');
                    return '';
                }
                $source->setRequestProperties($_REQUEST);
                $source->initialize();

                // The variable contains a value and has to be converted to an Image+ image object
                $imgPath = $source->getBasePath() . $json;
                if (file_exists($imgPath)) {
                    $size = getimagesize($imgPath);
                } else {
                    $this->modx->log(xPDO::LOG_LEVEL_INFO, 'The template variabe value does not contain an existing image', '', 'Image+');
                }
                $json = json_encode(array(
                    'altTag' => '',
                    'crop' => array(
                        'height' => ($size) ? $size[1] : 0,
                        'width' => ($size) ? $size[0] : 0,
                        'x' => 0,
                        'y' => 0
                    ),
                    'sourceImg' => array(
                        'height' => ($size) ? $size[1] : 0,
                        'width' => ($size) ? $size[0] : 0,
                        'source' => $source->get('id'),
                        'src' => $json
                    ),
                    'targetHeight' => (int)$opts['targetHeight'],
                    'targetWidth' => (int)$opts['targetWidth']
                ));
            }
        }
        return $json;
    }
}

define('imageplus', true);
