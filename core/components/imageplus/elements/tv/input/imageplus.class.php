<?php
/**
 * Image+ Input Render
 *
 * @package imageplus
 * @subpackage input_render
 */

class ImagePlusInputRender extends modTemplateVarInputRender
{
    /**
     * Return the template path to load
     *
     * @return string
     */
    public function getTemplate()
    {
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        return $corePath . 'elements/tv/input/tpl/imageplus.render.tpl';
    }

    /**
     * Get lexicon topics
     *
     * @return array
     */
    public function getLexiconTopics()
    {
        return ['imageplus:default'];
    }

    /**
     * Process Input Render
     *
     * @param string $value
     * @param array $params
     * @return void
     */
    public function process($value, array $params = [])
    {
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        /** @var ImagePlus $imageplus */
        $imageplus = $this->modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', [
            'core_path' => $corePath
        ]);
        $version = $this->modx->getVersionData();
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

        $context = (isset ($_GET['wctx']) && $_GET['wctx']) ? $_GET['wctx'] : '';
        $obj = $this->modx->getContext($context);
        $contextSettings = ($obj) ? $obj->config : [];
        $contextSettings = array_merge($this->modx->config, $contextSettings);
        $tvName = $this->tv->get('name');

        // Prepare TV config
        $tvConfig = new stdClass();
        $tvConfig->allowBlank = !($params['allowBlank'] === 'false' || $params['allowBlank'] === 0 || $params['allowBlank'] === false);
        if (!empty($params['targetWidth']) || !empty($params['targetHeight']) || !empty($params['targetRatio'])) {
            $tvConfig->targetWidth = !empty($params['targetWidth']) ? (int)$params['targetWidth'] : null;
            $tvConfig->targetHeight = !empty($params['targetHeight']) ? (int)$params['targetHeight'] : null;
            if (!$tvConfig->targetWidth || !$tvConfig->targetHeight) {
                $targetRatio = !empty($params['targetRatio']) ? (float)$params['targetRatio'] : null;
            } else {
                $targetRatio = $tvConfig->targetWidth / $tvConfig->targetHeight;
            }
        } else {
            $targetWidth = $this->getTVConfig('target_width', $tvName, $contextSettings, isset($params['targetWidth']) && $params['targetWidth'] !== '' ? $params['targetWidth'] : null);
            $tvConfig->targetWidth = ($targetWidth) ? (int)$targetWidth : null;
            $targetHeight = $this->getTVConfig('target_height', $tvName, $contextSettings, isset($params['targetHeight']) && $params['targetHeight'] !== '' ? $params['targetHeight'] : null);
            $tvConfig->targetHeight = ($targetHeight) ? (int)$targetHeight : null;
            if (!$tvConfig->targetWidth || !$tvConfig->targetHeight) {
                $targetRatio = $this->getTVConfig('target_width', $tvName, $contextSettings, isset($params['targetRatio']) && $params['targetRatio'] !== '' ? $params['targetRatio'] : null);
                $targetRatio = ($targetRatio) ? (float)$targetRatio : null;
            } else {
                $targetRatio = $tvConfig->targetWidth / $tvConfig->targetHeight;
            }
        }
        $tvConfig->targetRatio = $targetRatio;
        $tvConfig->thumbnailWidth = (int)$this->getTVConfig('thumbnail_width', $tvName, $contextSettings, (!empty($params['thumbnailWidth'])) ? $params['thumbnailWidth'] : (($version['major_version'] >= 3) ? 400 : 150));
        $tvConfig->altTagOn = (bool)$this->getTVConfig('allow_alt_tag', $tvName, $contextSettings, $params['allowAltTag'] ?? null);
        $tvConfig->captionOn = (bool)$this->getTVConfig('allow_caption', $tvName, $contextSettings, $params['allowCaption'] ?? null);
        $tvConfig->creditsOn = (bool)$this->getTVConfig('allow_credits', $tvName, $contextSettings, $params['allowCredits'] ?? null);
        $tvConfig->mediaSource = $source->get('id');
        $tvConfig->tvId = $this->tv->get('id');
        $tvConfig->tvParams = $this->getInputOptions();

        $this->setPlaceholder('tvConfig', json_encode($tvConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Prepare value
        $this->tv->value = $imageplus->prepareTvValue($this->tv->value, $params, $this->tv);
    }

    /**
     * @param string $key
     * @param string $name
     * @param array $config
     * @param string $default
     * @return string
     */
    private function getTVConfig($key, $name, $config, $default)
    {
        if (is_null($default)) {
            // Use $config if defined and not empty
            $value = $this->modx->getOption('imageplus.' . $key, $config, $default, true);

            // TV name based
            if ($name) {
                // Use $config if defined and not empty
                $value = $this->modx->getOption('imageplus.' . $name . '.' . $key, $config, $value, true);
            }
        } else {
            $value = $default;
        }

        return $value;
    }
}

return 'ImagePlusInputRender';
