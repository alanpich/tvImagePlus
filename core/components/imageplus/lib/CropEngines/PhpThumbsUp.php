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

namespace ImagePlus\CropEngines;

/**
 * Class PhpThumbsUp
 *
 * Uses the phpthumbsup extra to generate cropped images
 *
 * @package imageplus
 * @subpackage ImagePlus\CropEngines
 */
class PhpThumbsUp extends AbstractCropEngine
{
    /**
     * Checks that all requirements are met for using
     * this engine
     *
     * @param \modX $modx
     * @return bool True if engine is usable
     */
    public static function engineRequirementsMet(\modX $modx)
    {
        $pto = $modx->getObject('modSnippet', array('name' => 'phpthumbsup'));
        return $pto instanceof \modSnippet;
    }

    /**
     * Parse image+ data and return a url for the cropped
     * version of the image
     *
     * @param $json
     * @param array $opts
     * @param \modTemplateVar $tv
     * @return string
     */
    public function getImageUrl($json, $opts = array(), \modTemplateVar $tv)
    {

        // Parse json to object
        $data = json_decode($json);

        // If data is null, json was invalid or empty.
        // This is almost certainly because the TV is empty
        if (is_null($data)) {
            $this->modx->log(\xPDO::LOG_LEVEL_INFO, "Image+ TV renderer failed to parse JSON");
            return $tv->default_text;
        }

        // Load up the mediaSource
        $source = $this->modx->getObject('modMediaSource', $data->sourceImg->source);
        if (!$source instanceof \modMediaSource) {
            return 'Image+ Error: Invalid Media Source';
        };
        $source->initialize();

        // Grab absolute system path to image
        $imgPath = $data->sourceImg->src;

        // Prepare arguments for phpthumbof snippet call
        $params = array(
            'w' => $data->targetWidth,
            'h' => $data->targetHeight,
            'far' => true,
            'sx' => $data->crop->x,
            'sy' => $data->crop->y,
            'sw' => $data->crop->width,
            'sh' => $data->crop->height
        );

        // Add in output render params
        $options = array();
        if (isset($opts['phpThumbParams'])) {
            $optParams = explode('&', $opts['phpThumbParams']);
            foreach ($optParams as $oP) {
                if (empty($oP)) {
                    continue;
                };
                $bits = explode('=', $oP);
                $params[$bits[0]] = $bits[1];
            }

            foreach ($params as $key => $val) {
                $options[] = $key . '=' . $val;
            };
        };
        $options = implode('&', $options);


        // Call phpthumbof for url
        $url = $this->modx->runSnippet(
            'phpthumbsup',
            array(
                'options' => $options,
                'input' => $imgPath
            )
        );

        $url = str_replace('%2F', '/', $url);

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

}
