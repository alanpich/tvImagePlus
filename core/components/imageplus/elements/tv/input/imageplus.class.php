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
        // Load imageplus class
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        $imageplus = $this->modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', array(
            'core_path' => $corePath
        ));
        $version = $this->modx->getVersionData();

        // add lexicon topic
        $this->modx->controller->addLexiconTopic('imageplus:default');

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

        // For migxResourceMediaPath snippet
        $this->setPlaceholder('mediasource', $source->get('id'));

        // Prepare tv config for jsonification
        $tvConfig = new stdClass();
        $tvConfig->allowBlank = (bool)$params['allowBlank'];
        $tvConfig->targetWidth = (int)$params['targetWidth'];
        $tvConfig->targetHeight = (int)$params['targetHeight'];
        $tvConfig->targetRatio = $params['targetRatio'];
        $tvConfig->thumbnailWidth = (isset($params['thumbnailWidth']) && intval($params['thumbnailWidth'])) ? intval($params['thumbnailWidth']) : (($version['major_version'] >= 3) ? 400 : 150);
        $tvConfig->altTagOn = (bool)$params['allowAltTag'];
        $tvConfig->mediaSource = $source->get('id');
        $tvConfig->tvId = $this->tv->get('id');
        $tvConfig->tvParams = $this->getInputOptions();

        $this->setPlaceholder('tvConfig', json_encode($tvConfig));

        // Prepare value
        $this->tv->value = $imageplus->prepareTvValue($this->tv->value, $params, $source);
    }
}

return 'ImagePlusInputRender';
