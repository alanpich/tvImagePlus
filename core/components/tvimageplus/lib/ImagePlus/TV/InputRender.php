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


    /**
     * Returns path to smarty template to use for rendering
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->imagePlus->config['core_path'] . 'elements/tv/input/tpl/imageplus.input.tpl';
    }


    /**
     * Prepare TV data for output on resource page
     *
     * @param string $value
     * @param array  $params
     * @return void
     */
    public function process($value, array $params = array())
    {
        $json = $value;

        $imageData = new ImageData();
        $tvData = new TVData();

        $jsonData = json_decode($json);
        if(!is_null($jsonData)){
            $tvData->fromArray($jsonData);
            $image = $this->imagePlus->getImage($tvData->uid);
            if($image){
                $imageData->fromArray($image->toArray());
            }
        }

        $this->setPlaceholder('imageJSON',json_encode($imageData));
        $this->setPlaceholder('tvJSON',json_encode($tvData));

        $data = (object)array(
            'value' => addslashes($json),
        );

        $this->setPlaceholder('tvData',$data);

    }
} 