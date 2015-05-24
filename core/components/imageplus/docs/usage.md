## Input Options

In *Image+* you could control the final size and aspect ratio of selected images. There are several extended input 
options available for of an *Image+* TV:

**Target Height/Width**

Images can be constrained to a minimal height and/or width with **Target height** and **Target width**. If both values 
are set, the target aspect ratio of the output image is calculated with this values.

**Target Aspect Ratio**
 
The aspect ratio for the output image could be restricted with **Target Aspect Ratio**. If target height and target 
width are set, this value is ignored and the calculated aspect ratio of target height and target width is used.
 
If you set only one value of **Target Height** or **Target Width** and leave empty **Target Aspect Ratio**, the size of 
the crop is not restricted to any aspect ratio.

**Alt Tag Field**

*Image+* TVs can also contain an **Alt Tag Field**, which is an additional text input, that is stored with each image. 
It could be output alongside the image i.e. as an alt-tag or title-tag.

In order to outpt the alt text in a *Image+* TV placeholder, you will need to select an chunk in the **Output Options**. 
You could also use the ImagePlus snippet and specify a template chunk in the snippet call options.

**Allow Empty**

If **Allow Empty** is set to **No**, you will not be able to save a resource until you have selected an image and 
cropped it.

## Output Options

There are several extended output options available for of an *Image+* TV:

**Additional phpThumb Parameters**

As default an *Image+* TV returns an relative URL to an cropped (and maybe constrained) image that is scaled by 
phpThumb. With this output option, you could assign several additional phpThumb parameters that are used to generate 
the thumbnail image.

**Output Chunk**

If you select an **Output Chunk** the TV output is rendered with that chunk. Select the chunk name from the dropdown. 
Several placeholders are possible in that chunk to customize the output:

Placeholder | Description
------------|------------
url | URL of the thumbnail image
alt | Alt text
width | Minimal width of the thumbnail image
height | Minimal height of the thumbnail image
source.src | URL of the source image
source.width | Width of the source image
source.height | Height of the source image
crop.width | Crop width of the thumbnail image
crop.height | Crop height of the thumbnail image
crop.x | Crop x position of the thumbnail image
crop.y | Crop y position of the thumbnail image
options | Crop engine full option string to generate the thumbnail image
crop.options | Crop engine crop option string to generate the thumbnail image

All options could be displayed with the 

**Generate Thumb URL**

If you create the thumbnail in output chunk i.e. by a pthumb output filter, you could disable the generation of the 
internal thumb URL. 

## Snippet
The Snippet gives you a second option to render the TV value. With the template variable output options you are 
restricted to one output size per template variable, with the snippet you could generate several sizes. The following 
properties could be set in the snippet call:

Property | Description
------------|------------
tvname | Name of the Image+ TV
docid | Resource where the Image+ TV value is received from
type | Type of the snippet output. Could be set to `check` [^1], `tpl` [^2] and `thumb` [^3]
options | Extended phpThumb options for the image [^4]
tpl | Template chunk for the snippet output [^5]

**Example**

```
[[ImagePlus? 
&tvname=`imageplus` 
&docid=`1`
&options=`w=100` 
&type=`tpl` 
&tpl=`ImagePlus.demo`
]]
```

Will output the content of the template variable with the name *imageplus* of resource *1* and the extended phpThumb option *&w=100* (width: 100px) in the parsed *ImagePlus.demo* chunk.

[^1]: Outputs *image* if the Image+ TV contains an image, otherwise *noimage*.
[^2]: Outputs the parsed template set by **tpl** property for retreived Image+ TV value (with additional options set by the **options** property) 
[^3]: Outputs the thumbnail URL for retreived Image+ TV value (with additional options set by the **options** property)
[^4]: See [phpThumb readme](http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt) for possible options. Maybe not all options are valid in your installation (because of crop engine limitations or server restricions).
[^5]: The template chunk placeholder are the same as in the output chunk of the template variable.

<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwik.partout.info/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 13]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//piwik.partout.info/piwik.php?idsite=13" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
