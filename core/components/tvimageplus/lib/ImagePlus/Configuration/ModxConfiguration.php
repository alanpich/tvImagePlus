<?php

namespace ImagePlus\Configuration;

class ModxConfiguration implements \ArrayAccess
{
    /** @var  \modX */
    protected $modx;

    /** @var  array */
    protected $conf = array();

    public function __construct(\modX $modx)
    {
        $this->modx = $modx;

        $this->loadDefaults();
    }

    protected function loadDefaults()
    {
        $core = $this->modx->getOption('tvimageplus.core_path',null,$this->modx->getOption('core_path').'components/tvimageplus/');
        $assets_path = $this->modx->getOption('tvimageplus.assets_path',null,$this->modx->getOption('assets_path').'components/tvimageplus/');
        $assets_url = $this->modx->getOption('tvimageplus.assets_url',null,$this->modx->getOption('assets_url').'components/tvimageplus/');

        $mgr_url = $assets_url.'mgr/';

        $this->conf = array(
            'core_path' => $core,
            'model_path' => $core.'model/',
            'processor_path' => $core.'processors/',
            'assets_path' => $assets_path,
            'assets_url' => $assets_url,
            'mgr_url' => $mgr_url,
            'connector_url' => $mgr_url.'connector.php',
            'cache_source' => 1,
            'cache_path' => 'assets/components/tvimageplus/cache/',
        );
    }


    /**
     * Get configuration as json object
     *
     * @return string
     */
    public function toJSON(){
        $conf = new \stdClass;
        foreach($this->conf as $key => $val){
            $conf->$key = $this->offsetGet($key);
        }
        return json_encode($conf);
    }


    /**
     * Whether a offset exists
     *
     * @param mixed $offset An offset to check for.
     * @return boolean true on success or false on failure.
     *                      The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->conf[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset The offset to retrieve.
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        // First, check for a systemSetting override
        $sysName = 'tvimageplus.'.$offset;
        $opt = $this->modx->getOption($sysName,null,null);
        if(!is_null($opt))
            return $opt;

        if(!isset($this->conf[$offset]))
            return null;

        return $this->conf[$offset];
    }

    /**
     * Offset to set
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception("Method ImagePlus\\ModxConfiguration::offsetSet has not been implementd");
    }

    /**
     * Offset to unset
     */
    public function offsetUnset($offset)
    {
        throw new \Exception("Method ImagePlus\\ModxConfiguration::offsetUnset has not been implementd");
}
}