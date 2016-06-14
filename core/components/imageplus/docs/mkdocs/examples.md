## Examples

**Image+* could be used for several purposes. On this page you find some examples how to use it:

### MIGX

If you want to use *Image+* in MIGX you could define all *Image+* TV properties with a JSON string in the 'Configs' textarea in the MIGX formtabs field configuration. The following properties are possible:

```
{
"targetWidth":"",
"targetHeight":"",
"targetRatio":"",
"thumbnailWidth":"",
"allowAltTag":""
}
```

And you also have to change the *Input TV Type* to `imageplus`.

You could show the thumbnail in the grid column by setting the renderer to 'ImagePlus.MIGX_Renderer'. In prior MIGX versions you have to raw edit a MIGX configuration for that. 

To use that *Image+*-MIGX-Field in the Frontend, call the `ImagePlus`-Snippet with just the value-parameter being the name of this MIGX-Field: 

```
[[ImagePlus? 
  &value=`[[+migxImagePlusField]]`
]]
```

This will get you the prepared URL for the cropped image, instead of the raw JSON-Object.

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

### getResources

In order for the TV to be parsed with getResources, make sure you add the following line to your getResources call:

```
&processTVs=`name_of_your_tv`
```

### Responsive images

If you want to display responsive images with and without the crop, you could use the ImagePlus snippet.

**Snippet Call**
```
[[ImagePlus? 
&tvname=`yourtvname` 
&type=`tpl` 
&options=`&w=320`
&tpl=`tplResponsiveImage`
&pagetitle=`[[*pagetitle]]`
]]
```
  
  
**Chunk tplResponsiveImage**
```
<picture>
    <source media="(min-width: 36em)"
            srcset="[[+source.src:pthumb=`w=1024`]] 1024w,
                [[+source.src:pthumb=`w=640`]] 640w,
                [[+source.src:pthumb=`w=320`]] 320w"
            sizes="33.3vw"/>
    <source srcset="[[+source.src:pthumb=`[[+crop.options]]&w=640`]] 2x,
                [[+source.src:pthumb=`[[+crop.options]]&w=320`]] 1x"/>
    <img src="[[+url]]" alt="[[+alt:default=`[[+pagetitle]]`]]"/>
</picture>
```
