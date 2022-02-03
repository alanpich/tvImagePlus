<?php
/**
 * Image+ Output Render
 *
 * @package imageplus
 * @subpackage output_render
 */

class ImagePlusOutputRender extends modTemplateVarOutputRender
{
    /**
     * Process Output Render
     *
     * @param string $value
     * @param array $params
     * @return string
     */
    public function process($value, array $params = [])
    {
        // Load imageplus class
        $corePath = $this->modx->getOption('imageplus.core_path', null, $this->modx->getOption('core_path') . 'components/imageplus/');
        $imageplus = $this->modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', [
            'core_path' => $corePath
        ]);

        $params = array_merge([
            'docid' => ($this->modx->resource) ? $this->modx->resource->get('id') : 0
        ], $params);

        return $imageplus->getImageURL($value, $params, $this->tv);
    }
}

return 'ImagePlusOutputRender';
