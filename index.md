---
layout: master
title: Image+ ModX Component
---

Image+ is an extension for MODX Revolution that enables image cropping and advanced
options for images used in Template Variables (TVs).

An new <abbr title="Template Variable">TV</abbr> type gives developers the power to forcibly control
the size and ratio of user uploaded images. Once size constraints are set, users
are prompted to crop their selected image using a GUI cropping tool in the browser,
and optionally set an alt-tag or title for the image.

<!--
<p class="row gallery">
    <a href="images/screenshot-1.png"
       rel="shadowbox[Screenshots]"
       class="col-md-3 col-xs-6">
        <img src="images/screenshot-1.png" class="img-thumbnail img-responsive" />
    </a>
    <a href="images/screenshot-2.png" rel="shadowbox[Screenshots]" class="col-md-3 col-xs-6">
        <img src="images/screenshot-2.png" class="img-thumbnail img-responsive" />
    </a>
    <a href="images/screenshot-1.png" rel="shadowbox[Screenshots]" class="col-md-3 col-xs-6">
        <img src="images/screenshot-1.png" class="img-thumbnail img-responsive" />
    </a>
    <a href="images/screenshot-1.png" rel="shadowbox[Screenshots]" class="col-md-3 col-xs-6">
        <img src="images/screenshot-1.png" class="img-thumbnail img-responsive" />
    </a>
</p>
-->


### Requirements
-------------------------------
* MODX Revolution 2.2.4+
* PHP v5.3+


### Features
-------------------------------
* Visual Image cropping tool integrated into the MODX manager interface
* Option to constrain one or both width & height of the output image
* User image crop can be forced to remain at pre-set ratio
* Use a chunk as an output template to get placeholders for url, height, width & alt-tag

