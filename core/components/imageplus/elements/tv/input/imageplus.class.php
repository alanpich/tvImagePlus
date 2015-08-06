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
class ImagePlusInputRender extends modTemplateVarInputRender
{
    public function getTemplate()
    {
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        return $corePath . 'elements/tv/input/tpl/imageplus.render.tpl';
    }

    public function getLexiconTopics()
    {
        return array('imageplus:default');
    }

    // Override the default TV render because of a isnumeric/intval bug,
    // that does not allow a floatval in the input options
    public function render($value, array $params = array())
    {
        $this->setPlaceholder('tv', $this->tv);
        $this->setPlaceholder('id', $this->tv->get('id'));
        $this->setPlaceholder('ctx', isset($_REQUEST['ctx']) ? $_REQUEST['ctx'] : 'web');
        $this->setPlaceholder('params', $params);

        if (!empty($params)) {
            foreach ($params as $k => $v) {
                if ($v === 'true') {
                    $params[$k] = TRUE;
                } elseif ($v === 'false') {
                    $params[$k] = FALSE;
                } elseif (is_numeric($v) && ((int)$v == $v)) {
                    $params[$k] = intval($v);
                } elseif (is_numeric($v)) {
                    $params[$k] = (float)($v);
                }
            }
        }
        $this->_loadLexiconTopics();
        $output = $this->process($value, $params);

        $tpl = $this->getTemplate();
        return !empty($tpl) ? $this->modx->controller->fetchTemplate($tpl) : $output;
    }

    public function process($value, array $params = array())
    {
        $this->modx->lexicon->load('imageplus:default');

        // Load imageplus class
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        $imageplus = $this->modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', array(
            'core_path' => $corePath
        ));

        // Load required javascripts & register global config
        $imageplus->includeScriptAssets();

        // Get Media Source
        /** @var modMediaSource $source */
        $source = $this->tv->getSource(($this->modx->resource) ? $this->modx->resource->get('context_key') : 'mgr');
        if (!$source) return '';
        if (!$source->getWorkingContext()) {
            return '';
        }
        $source->setRequestProperties($_REQUEST);
        $source->initialize();
        $this->setPlaceholder('mediasource',$source->get('id'));

        // Prepare tv config for jsonification
        $tvConfig = $imageplus->loadTvConfig($this, $value, $params);
        $tvConfig->mediaSource = $source->get('id');
        $this->setPlaceholder('imageplusconfig', json_encode($tvConfig));
        $this->setPlaceholder('tvValue', $value);
        $this->setPlaceholder('tvparams', json_encode($this->getInputOptions()));
        $this->setPlaceholder('lexicon', json_encode($this->modx->lexicon->fetch('imageplus.', true)));
        $this->setPlaceholder('imgData', $this->getImageDataJSON($value, $params, $source));
        $this->setPlaceholder('config', json_encode($imageplus->options));
    }

    private function getImageDataJSON($value, $params, &$source)
    {
        $value = json_decode($value);

        $data = new stdClass;

        // Grab MediaSource info
        //$source = $this->modx->getObject('modMediaSource', ($this->tv->get('source')) ? $this->tv->get('source') : $this->modx->getOption('default_media_source'));
        $data->mediasource = new stdClass;
        if ($source){
            $properties = $source->getProperties();        
            $data->mediasource->id = $source->get('id');
            $data->mediasource->path = (isset($properties['basePath'])) ? $properties['basePath']['value'] : $this->modx->getOption('base_path');
            $data->mediasource->url = (isset($properties['baseUrl'])) ? $properties['baseUrl']['value'] : $this->modx->getOption('base_url');    
        }

        // Grab constraint info
        $data->constraint = new stdClass;
        $data->constraint->width = empty($params['targetWidth']) ? 0 : (int)$params['targetWidth'];
        $data->constraint->height = empty($params['targetHeight']) ? 0 : (int)$params['targetHeight'];
        $data->constraint->ratio = empty($params['targetRatio']) ? false : $params['targetRatio'];

        // Generate ratio value
        if ($data->constraint->width > 0 && $data->constraint->height > 0) {
            // If both width/height constraints set, use that for ratio calc
            $data->constraint->ratio = $data->constraint->width / $data->constraint->height;
        } else {
            // If ratio is not set
            if (!$data->constraint->ratio) {
                if (isset($value->source->width) && isset($value->source->height)) {
                    // Use source image size for ratio
                    $data->constraint->ratio = $value->source->width / $value->source->height;
                } else {
                    // Fail safe (and square)
                    $data->constraint->ratio = false;
                }
            }
        }

        // Grab source image info (if it exists yet)
        if (isset($value->source)) {
            $data->source = new stdClass;
            $data->source->height = $value->source->height;
            $data->source->width = $value->source->width;
            $data->source->path = $value->source->path;
            $data->source->filename = $value->source->filename;
            $data->source->size = $value->source->size;
        } else {
            $data->source = false;
        }

        // Grab crop params (if they exist yet)
        if (isset($value->crop)) {
            $data->crop = new stdClass;
            $data->crop->x = $value->crop->x;
            $data->crop->y = $value->crop->y;
            $data->crop->width = $value->crop->width;
            $data->crop->height = $value->crop->height;
        }

        return json_encode($data);
    }

}

return 'ImagePlusInputRender';
