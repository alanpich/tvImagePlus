---
layout: master
title: Output Options
---

## Image+ TV Output type
---------------------------

The *Image+* **TV Output Type** offers several different method of rendering
an image onto a page. The default, and simplest of these is URL, which will
output a simple url onto the page pointing to you image. Other options are
available for more advanced and dynamic usage of the TV.

### URL
---------
The URL output type simple outputs the URL of your image onto the page. This can
be used to populate and image tag or background-image css property on the page.
#### Example
````html
<img src="[[*myTV]]" />
````


### Chunk
------------
The Chunk output type allows you to select a chunk to use for rendering the TV's
output. Select the chunk you want to use from the dropdown menu, and it will be
called whenever you use your TV on a page. Several placeholders are passed to the
chunk to allow you to customize the output.
#### Available Placeholders
````html
[[+uid]]      Unique identifier for this image
[[+url]]      Url of the image
[[+width]]    Width of the image
[[+height]]   Height of the image
[[+alt]]      Alt text
[[+original]] Url of the original (uncropped) image
[[+mtime]]    Timestamp the image was generated
````


### Snippet
---------------
The Snippet output type allows you use a snippet for rendering the TV's output.
Select the snippet you want to use from the dropdown menu, and it will be called
whenever you use your TV on a page. Several variables are passed to the snippet
to allow you to customize the output.
#### Available variables
````php
<?php
/**
 * @param int     $uid       Unique identifier for the Image+ instance
 * @param string  $url       Absolute URL of the cropped image
 * @param int     $width     Image width
 * @param int     $height    Image height
 * @param int     $mtime     Timestamp when cached image was generated
 * @param string  $original  Absolute URL to the original (source) image
 */
````


### Data URI
---------------
If for whatever reason you can't load your image in the normal way, you can also
output the image as a [Data URI](http://en.wikipedia.org/wiki/Data_URI_scheme). This will mean it is available as soon as the DOM
loads, but may slow down your page load time as the amount of data it outputs can
be very large.