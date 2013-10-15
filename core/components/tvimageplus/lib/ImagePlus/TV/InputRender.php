<?php
namespace ImagePlus\TV;

use ImagePlus\Configuration\ImageData;
use ImagePlus\Configuration\TVData;

class InputRender extends \modTemplateVarInputRender
{
    /** @var \ImagePlus\ModxService */
    public $imagePlus;

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


}