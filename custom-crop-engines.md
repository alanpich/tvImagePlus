---
layout: master
title: Custom Crop Engines
---

## Using custom Cropping Engines
---------------------------------
Image+ comes pre-packed with support for using popular image
manipulation extensions. At the current time, supported engines
are phpThumbOf and phpThumbsUp

v2.2 has been rewritten to decouple the cropping engine from the
rest of the TV process to make it easier to change which engine
is used for cropping.

Enabling support for other image manipulation libraries can be
acheived by creating a new PHP class extending
`tvImagePlus\CropEngines\AbstractCropEngine`

<p class="alert alert-info"><strong>Note</strong> At this time, (pre-v2.2.0) while the abstractCropEngine
exists and is usable, there is no easy way to inject custom
engine classes into the core without hacking.</p>

A crop engine class requires two methods:

````php
<?php

class myCustomCropEngine
  extends tvImagePlus\CropEngines\AbstractCropEngine {

  /**
   * Checks for any dependencies. Returns true if all are met,
   * or false if there is an issue
   *
   * @param \modX $modx MODX instance
   * @return bool
   */
  public static function engineRequirementsMet(\modX $modx)
  {
    return true;
  }


  /**
   * Parse image+ data and return a url for the cropped
   * version of the image
   *
   * @param $json
   * @param array $opts
   * @param \modTemplateVar $tv
   * @return string
   */
  public function getImageUrl(
        $json,
        $opts = array(),
        \modTemplateVar $tv)
  {
    /* ... */
  }

}

````