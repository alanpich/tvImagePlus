<?php
/**
 * ImagePlus Upgrade Script
 *
 * @versions lt v3.0.0
 */

/** @var ImagePlusInstallResolver $this */

$this->warn("Upgrading from pre-v3.0.0");
set_time_limit(0);

class ImagePlusUpgrade_3_0_0 extends ImagePlus\AbstractUpgradeScript
{

    protected $imagePlusTvNames = array();

    /**
     * Run the upgrade
     * @return bool
     */
    public function run()
    {
        $this->installDbTable();

        $this->removeOldRouterPlugin();

        $this->upgradeTVValues();

        // VERY IMPORTANT - install will fail without this
        return true;
    }


    /**
     * Create the new database table
     */
    protected function installDbTable()
    {
        $manager = $this->modx->getManager();
        $manager->createObjectContainer('imagePlusImage');
        $this->warn("New database schema imported");
    }


    /**
     * Remove the legacy plugin to allow the new one to
     * take over
     */
    protected function removeOldRouterPlugin()
    {
        /** @var modPlugin $oldPlugin */
        $oldPlugin = $this->modx->getObject('modPlugin', array(
            'name' => 'ImagePlusRouter'
        ));
        if ($oldPlugin instanceof modPlugin) {
            $oldPlugin->remove();
            $this->warn("Legacy plugin removed");
        }
    }


    /**
     * Upgrade any existing tv values
     */
    protected function upgradeTVValues()
    {
        // Find all image+ TVs
        $tvs = $this->modx->getCollection('modTemplateVar', array(
            'type' => 'imageplus'
        ));
        $this->warn("Updating TV values for " . count($tvs) . " TVs");
        /** @var modTemplateVar $tv */
        foreach ($tvs as $tv) {
            $this->warn("Processing TV [" . $tv->get('name') . "]");
            $this->imagePlusTvNames[] = $tv->get('name');
            $instances = $tv->getMany('TemplateVarResources');
            $done = 0;
            $total = count($instances);

            /** @var modTemplateVarResource $tvInstance */
            foreach ($instances as $tvInstance) {

                $currentValue = trim($tvInstance->get('value'));
                $updatedValue = $this->upgradeTVValue($currentValue);
                $tvInstance->set('value', json_encode($updatedValue));
                $tvInstance->save();

                ++$done;
                $this->log("- Instance updated ({$done}/{$total})");
            }
        }
    }


    /**
     * Transform a TV Value from pre-3.0 to the current standard
     *
     * @param string $value TV current value
     * @return string
     */
    protected function upgradeTVValue($value)
    {
        $newValue = $value;

        // Empty - ignore
        if (!strlen($value)) {
            return '';
        }

        // Cant decode JSON - must be broken - clear it out
        $data = json_decode($value);
        if (is_null($data)) {
            $this->warn("Unable to parse TV value, skipping...");
            return '';
        }

        // v2.x style data, update it please
        if (!isset($data->uid)) {
            return $this->upgradev2TVValue($data);
        }

        return $newValue;
    }


    /**
     * Parse a v2.x json tv value and reformat into a v3 compatible object
     *
     * @param $data
     * @return \ImagePlus\Configuration\TVData
     */
    protected function upgradev2TVValue($data)
    {
        $imageData = new ImagePlus\Configuration\ImageData();
        $tvData = new ImagePlus\Configuration\TVData();
        $tvData->version = '3.0.0';


        // Alt-tag is easy
        if (isset($data->altTag))
            $tvData->alt = $data->altTag;

        // Source image
        if (isset($data->sourceImg) && isset($data->sourceImg->src)) {
            $imageData->path = $data->sourceImg->src;
            $imageData->mediasource = isset($data->sourceImg->source) ? $data->sourceImg->source : 1;
        }

        if (isset($data->targetWidth))
            $imageData->output_width = $data->targetHeight;

        if (isset($data->targetHeight))
            $imageData->output_height = $data->targetHeight;


        // Crop locations
        if (isset($data->crop)) {
            $crop_x = isset($data->crop->x) ? $data->crop->x : false;
            $crop_y = isset($data->crop->y) ? $data->crop->y : false;
            $crop_w = isset($data->crop->width) ? $data->crop->width : false;
            $crop_h = isset($data->crop->height) ? $data->crop->height : false;

            // Only set crop params if they are all there
            if ($crop_x !== false && $crop_y !== false && $crop_w !== false && $crop_h !== false) {
                $imageData->crop_x = $crop_x;
                $imageData->crop_y = $crop_y;
                $imageData->crop_w = $crop_w;
                $imageData->crop_h = $crop_h;

                // If we have a crop, create a record
                /** @var imagePlusImage $image */
                $image = $this->imagePlus->createImage($imageData->toArray());

                $image->save();

                $tvData->url = $this->imagePlus->getImageUrl($image->get('id'));

                $tvData->uid = $image->get('id');
            } else {
                $this->warn("Invalid json data, skipping");
                return $data;
            }
        }
        return $tvData;
    }


}

$script = new ImagePlusUpgrade_3_0_0($this->modx);
return $script->run();
