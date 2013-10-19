<?php

if(!class_exists('ImagePlus\TV\InputRender'))
    require dirname(dirname(dirname(dirname(__FILE__)))).'/lib/autoload.php';

class ImagePlusInputRender extends ImagePlus\TV\InputRender
{
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

        $imageData = new \ImagePlus\Configuration\ImageData();
        $tvData = new \ImagePlus\Configuration\TVData();

        /* Check the tv value for a uid property
         * hydrate the data objects if is valid */
        $jsonData = json_decode($json);
        if(!is_null($jsonData)){
            $tvData->fromArray($jsonData);
            $image = $this->imagePlus->getImage($tvData->uid);
            if($image){
                $imageData->fromArray($image->toArray());
            }
        };

        //@TODO Implement new frontend form element that returns true/false instead of "Yes"/"No"
        if(isset($params['allowAltTag'])){
            $p =& $params['allowAltTag'];
            $p = ( $p=='Yes' || $p=='true' || (int)$p==1 || $p === true) ? true : false;
        }
        if(isset($params['allowBlank'])){
            $p =& $params['allowBlank'];
            $p =  ($p=='Yes' || $p=='true' || (int)$p==1 || $p === true) ? true : false;
        }
        $params['targetWidth'] = (int)$params['targetWidth'];
        $params['targetHeight'] = (int)$params['targetHeight'];

        $this->setPlaceholder('imageJSON',json_encode($imageData));
        $this->setPlaceholder('tvJSON',json_encode($tvData));
        $this->setPlaceholder('paramsJSON',json_encode($params));

        $data = (object)array(
            'value' => addslashes($json),
        );

        $this->setPlaceholder('tvData',$data);

    }

}

return "ImagePlusInputRender";