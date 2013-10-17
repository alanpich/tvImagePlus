<?php

/**
 * Install script for ImagePlus v2.9.89
 */
class ImagePlus_Install_2_9_89 extends ImagePlus\Install\Script
{

    /**
     * The main script
     */
    public function process()
    {
        $this->installDbTable();

        // VERY IMPORTANT
        return true;
    }

    /**
     * Create the new database table
     */
    protected function installDbTable()
    {
        $this->log("Creating DB tables");
        $manager = $this->modx->getManager();
        $this->modx->addPackage('imageplus');
        $manager->createObjectContainer('imagePlusImage');
    }

}

return 'ImagePlus_Install_2_9_89';