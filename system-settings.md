---
layout: master
title: System Settings
---

## System Settings
-------------------------------

Several *Image+* settings can be overridden using
MODX System Settings. This allows you to change the
behaviour of all *Image+* instances accross your site.

### Available System Settings
-------------------------------
* `tvimageplus.debug`  -  if **true** enables debug mode,
   which looks ugly but provides more info for developers;
* `tvimageplus.cache_media_source`  -  The Media Source
   to use to store cropped images. Defaults to 1 (Filesystem)
* `tvimageplus.cache_path`  -  Path (relative to Media Source
   root) to the directory used for storing cropped images.
   Defaults to `/assets/components/tvimageplus/cache/`