<?php
/*
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
 * Vapor; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package tvImagePlus
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */


class tvImagePlus
{

    public $dataStr;

    /** @var \modX  */
    public $modx;


    function __construct(modX &$modx)
    {
        $this->modx =& $modx;
        $this->loadConfig();
        $this->loadLexicon();
        $this->loadSourceMap();
    }

    //


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
            'sources' => array()
        );
    }

    //


    /**
     * Load the lexicon topic
     *
     * @todo Do it properly with MODx.lang _()
     */
    private function loadLexicon()
    {
        // This should be enough aaaarrrrrgh!!!!!
        $this->modx->lexicon->load('tvimageplus');
        $lex = $this->modx->lexicon->getFileTopic($this->modx->cultureKey, 'tvimageplus');
        $this->config['lexicon'] = $lex;
    }

    //

    /**
     * Get a map of MediaSource id => baseUrl
     *
     * @return void
     */
    private function loadSourceMap()
    {
        $sources = $this->modx->getCollection('sources.modMediaSource');
        foreach ($sources as $source) {
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
     * @param array                $params
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
            //      die('<pre>'.print_r($saved,1));
            $data->altTag = ($data->altTagOn ? (isset($saved->altTag) ? $saved->altTag : '') : false);
        }

        return $data;
    }


    /**
     * Render supporting javascrip
     */
    public function includeScriptAssets()
    {

    }


    /**
     * Check if phpThumbOf is installed
     *
     * @return bool
     */
    public function hasPhpThumbOf()
    {
        $pto = $this->modx->getObject('modSnippet', array('name' => 'phpthumbof'));
        return $pto instanceof modSnippet;
    }

    //

    /**
     * Return a scaled, cached version of the source image for front-end use
     *
     * @param string $json
     * @param array  $opts
     * @internal param array $params
     * @return string
     */
    public function getImageURL($json, $opts = array())
    {
        // Return error message if phpthumbof not found
        if (!$this->hasPhpThumbOf()) {
            return "Image+ Error: PhpThumbOf Extra not found";
        }

        // Parse json to object
        $data = json_decode($json);

        // Load up the mediaSource
        $source = $this->modx->getObject('modMediaSource', $data->sourceImg->source);
        if (!$source instanceof modMediaSource) {
            return 'Image+ Error: Invalid Media Source';
        };
        $source->initialize();

        // Grab absolute system path to image
        $imgPath = $source->getBasePath() . $data->sourceImg->src;

        // Prepare arguments for phpthumbof snippet call
        $params = array(
            'src' => $imgPath,
            'w' => $data->targetWidth,
            'h' => $data->targetHeight,
            'far' => true,
            'sx' => $data->crop->x,
            'sy' => $data->crop->y,
            'sw' => $data->crop->width,
            'sh' => $data->crop->height
        );

        // Add in output render params
        $optParams = explode('&', $opts['phpThumbParams']);
        foreach ($optParams as $oP) {
            if (empty($oP)) {
                continue;
            };
            $bits = explode('=', $oP);
            $params[$bits[0]] = $bits[1];
        }

        $options = array();
        foreach ($params as $key => $val) {
            $options[] = $key . '=' . $val;
        };
        $options = implode('&', $options);


        // Call phpthumbof for url
        $url = $this->modx->runSnippet(
            'phpthumbof',
            array(
                'options' => $options,
                'input' => $imgPath
            )
        );

        // If an output chunk is selected, parse that
        if (isset($opts['outputChunk']) && !empty($opts['outputChunk'])) {
            $chunkParams = array(
                'url' => $url,
                'alt' => $data->altTag,
                'width' => $data->targetWidth,
                'height' => $data->targetHeight
            );
            return $this->modx->getChunk($opts['outputChunk'], $chunkParams);
        } else {
            // Otherwise return raw url
            return $url;
        };
    }
    //


}

; // end class tvImagePlus
define('tvimageplus', true);
