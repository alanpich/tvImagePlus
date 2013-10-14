<?php
require dirname(dirname(dirname(dirname(__FILE__)))).'/lib/autoload.php';
if(!class_exists('ImagePlusOutputRender')) {
    class ImagePlusOutputRender extends ImagePlus\TV\OutputRender {}
}
return "ImagePlusOutputRender";