<?php

/**
 * Image+ Input Render
 *
 * Copyright 2013-2015 by Alan Pich <alan.pich@gmail.com>
 * Copyright 2015-2016 by Thomas Jakobi <thomas.jakobi@partout.info>
 *
 * @package imageplus
 * @subpackage input_render
 *
 * @author Alan Pich <alan.pich@gmail.com>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @copyright Alan Pich 2013-2015
 * @copyright Thomas Jakobi 2015-2016
 */
class ImagePlusInputRender extends modTemplateVarInputRender
{
    /**
     * Return the template path to load
     * @return string
     */
    public function getTemplate()
    {
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        return $corePath . 'elements/tv/input/tpl/imageplus.render.tpl';
    }

    /**
     * @return array
     */
    public function getLexiconTopics()
    {
        return array('imageplus:default');
    }

    /**
     * Override the default TV render because of a isnumeric/intval bug, that does not allow a floatval in the input
     * options - fixed in MODX Revolution 2.3.4 (https://github.com/modxcms/revolution/pull/12452)
     * @param string $value
     * @param array $params
     * @return mixed|string|void
     */
    public function render($value, array $params = array())
    {
        $this->setPlaceholder('tv', $this->tv);
        $this->setPlaceholder('id', $this->tv->get('id'));
        $this->setPlaceholder('ctx', isset($_REQUEST['ctx']) ? $_REQUEST['ctx'] : 'web');
        $this->setPlaceholder('params', $params);

        if (!empty($params)) {
            foreach ($params as $k => $v) {
                if ($v === 'true') {
                    $params[$k] = true;
                } elseif ($v === 'false') {
                    $params[$k] = false;
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

    /**
     * @param string $value
     * @param array $params
     * @return void|mixed
     */
    public function process($value, array $params = array())
    {
        // Load imageplus class
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        $imageplus = $this->modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', array(
            'core_path' => $corePath
        ));
        $version = $this->modx->getVersionData();

        // Load required javascripts & register global config
        $imageplus->includeScriptAssets();

        // Get Media Source
        /** @var modMediaSource $source */
        $source = $this->tv->getSource(($this->modx->resource) ? $this->modx->resource->get('context_key') : 'mgr');
        if (!$source || !$source->getWorkingContext()) {
            return;
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
        $tvConfig->captionOn = (bool)$params['allowCaption'];
        $tvConfig->creditsOn = (bool)$params['allowCredits'];
        $tvConfig->mediaSource = $source->get('id');
        $tvConfig->tvId = $this->tv->get('id');
        $tvConfig->tvParams = $this->getInputOptions();

        $this->setPlaceholder('tvConfig', json_encode($tvConfig));

        // Prepare value
        $this->tv->value = $imageplus->prepareTvValue($this->tv->value, $params, $this->tv);
    }
}

return 'ImagePlusInputRender';
