<?php
namespace ImagePlus\Install;

use xPDO;
use modX;

abstract class Script
{

    public function __construct(\modX $modx)
    {
        $this->modx = $modx;
        $path = $modx->getOption('tvimageplus.core_path',null,$modx->getOption('core_path').'components/tvimageplus');
        $this->imagePlus = $this->modx->addPackage('imagePlus','ImagePlus',$path);
    }

    /**
     * The main thread of the script. Override this method
     * with your own stuff
     */
    abstract function process();

    /**
     * Write info message to the log
     * @param $msg
     */
    protected function log($msg){
        $this->modx->log(xPDO::LOG_LEVEL_INFO,$msg);
    }
    /**
     * Write warning message to the log
     * @param $msg
     */
    protected function warn($msg){
        $this->modx->log(xPDO::LOG_LEVEL_WARN,$msg);
    }
    /**
     * Write error message to the log
     * @param $msg
     */
    protected function error($msg){
        $this->modx->log(xPDO::LOG_LEVEL_ERROR,$msg);
    }
    /**
     * Write fatal error message to the log
     * @param $msg
     */
    protected function fatal($msg){
        $this->modx->log(xPDO::LOG_LEVEL_FATAL,$msg);
    }
}