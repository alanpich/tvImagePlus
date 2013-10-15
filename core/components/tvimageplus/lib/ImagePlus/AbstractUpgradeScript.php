<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alan
 * Date: 15/10/13
 * Time: 15:42
 * To change this template use File | Settings | File Templates.
 */

namespace ImagePlus;


class AbstractUpgradeScript
{

    /** @var  \modX */
    public $modx;

    /** @var  \ImagePlus\ModxService */
    public $imagePlus;

    public function __construct(\modX $modx){
        $this->modx = $modx;
        $path = $this->modx->getOption('tvimageplus.core_path',null,$this->modx->getOption('core_path').'components/tvimageplus/');
        $this->imagePlus = $modx->getService('imagePlus','ImagePlus',$path);
    }



    public function run(){
        return true;
    }


    public function log($msg){
        $this->modx->log(\xPDO::LOG_LEVEL_INFO,$msg);
    }
    public function warn($msg){
        $this->modx->log(\xPDO::LOG_LEVEL_WARN,$msg);
    }
    public function error($msg){
        $this->modx->log(\xPDO::LOG_LEVEL_ERROR,$msg);
    }
}