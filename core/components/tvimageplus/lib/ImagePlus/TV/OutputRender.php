<?php
namespace ImagePlus\TV;

class OutputRender extends \modTemplateVarOutputRender
{

    /**
     * Load up the ImagePlus service for tools and such
     *
     * @param \modTemplateVar $tv
     * @param array           $config
     */
    public function __construct(\modTemplateVar $tv, array $config = array())
    {
        parent::__construct($tv, $config);
        $path = $this->modx->getOption(
            'tvimageplus.core_path',
            null,
            $this->modx->getOption('core_path') . 'components/tvimageplus/'
        );
        $this->imagePlus = $this->modx->getService('imagePlus', 'ImagePlus', $path);
    }


    public function process($value, array $params = array())
    {
        $data = json_decode($value);
        if(isset($data->url)){
            return $data->url;
        }
    }
    //

} 