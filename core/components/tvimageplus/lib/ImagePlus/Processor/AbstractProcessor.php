<?php
namespace ImagePlus\Processor;

/**
 * Extends native modProcessor class to automatically load up the
 * ImagePlus\ModxService helper every time
 *
 * @package ImagePlus
 */
abstract class AbstractProcessor extends \modProcessor
{
    /** @var \ImagePlus\ModxService */
    protected $imagePlus;

    /**
     * Creates a modProcessor object.
     *
     * @param \modX $modx A reference to the modX instance
     * @param array $properties An array of properties
     */
    function __construct(\modX & $modx,array $properties = array()) {
        parent::__construct($modx,$properties);
        $path = $this->modx->getOption('tvimageplus.core_path',null,$this->modx->getOption('core_path').'components/tvimageplus/');
        $this->imagePlus = $this->modx->getService('imagePlus','ImagePlus',$path);
    }
} 