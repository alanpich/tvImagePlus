<?php

class ImagePlusInstallResolver
{

    /** @var  \modX */
    public $modx;

    /** @var ImagePlus\ModxService */
    public $imagePlus;


    public function __construct($object)
    {
        $this->modx = $object->xpdo;
        $path = $this->modx->getOption('tvimageplus.core_path',null,$this->modx->getOption('core_path').'components/tvimageplus/');
        $this->imagePlus = $this->modx->getService('imagePlus','ImagePlus',$path);
    }

    /**
     * Run the install script
     */
    public function run($options)
    {
        if ($this->modx) {
            $installer = new ImagePlus\Install\UpgradeController($this->modx,'tvimageplus');
            $installer->setScriptDirectory($this->imagePlus->config['install_dir']);
            return $installer->run();
        } else {
            return true;
        }
    }


    /**
     * Do a completely fresh installation (no upgrade)
     *
     * @param $options
     * @return bool
     */
    public function install($options)
    {
        $this->modx->addPackage('imageplus', $this->getCorePath());
        $manager = $this->modx->getManager();
        $manager->createObjectContainer('imagePlusImage');
        $this->modx->log(xPDO::LOG_LEVEL_ERROR, "Fresh install please");
        return true;
    }


    /**
     * Upgrade an existing installations
     *
     * @param $options
     * @return bool
     */
    public function update($options)
    {
        /*
         * Upgrade script for versions  < v2.9.61
         */
        if (version_compare($this->getInstalledVersion(), '2.9.61', '<')) {
            // Upgrade v2.x setups to v3.x
            $success = include $this->getCorePath().'upgrade/upgrade.2.9.61.php';
            if(!$success)
                return false;

        }



        return true;
    }


    /**
     * Gets the version of the currently installed package
     * and returns it as '1.2.3'
     *
     * @return string
     */
    protected function getInstalledVersion()
    {
        /** @var xPDOQuery $q */
        $q = $this->modx->newQuery('modTransportPackage', array(
            'package_name' => 'tvimageplus'
        ));
        $q->sortby('updated', 'DESC');
        $q->limit(1, 1);
        $package = array_shift($this->modx->getCollection('modTransportPackage', $q));
        $currentVersion = $package->get('version_major') . '.' . $package->get('version_minor') . '.' . $package->get('version_patch');
        return $currentVersion;
    }


    protected function getCorePath(){
        return  $this->modx->getOption('tvimageplus.core_path', null, $this->modx->getOption('core_path') . 'components/tvimageplus/');
    }


    public function log($msg){
        $this->modx->log(xPDO::LOG_LEVEL_INFO,$msg);
    }
    public function warn($msg){
        $this->modx->log(xPDO::LOG_LEVEL_WARN,$msg);
    }
    public function error($msg){
        $this->modx->log(xPDO::LOG_LEVEL_ERROR,$msg);
    }


}


$installer = new ImagePlusInstallResolver($object);
return $installer->run($options);


return true;