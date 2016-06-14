# Image+

Image+ is an advanced image custom template variable type for MODx Revolution. The dimensions for the uploaded image can 
(optionally) be configured to constrain a minimal width and/or height. The image crop could be forced to remain at a 
pre-set ratio. A graphical tool could be used to crop the image to the required dimensions/proportions.

### Requirements

* MODX Revolution 2.2.4+
* PHP v5.3+
* MODX Cropping Engine i.e. [pThumb](http://modx.com/extras/package/pthumb)

### Features

* Visual Image cropping tool integrated into the MODX manager interface.
* Option to constrain minimal width and/or height for the uploaded image. 
* User image crop can be forced to remain at pre-set ratio.
* Use a chunk as an output template and fill placeholders with url, height, width, alt-tag, phpthumb options etc of the 
  cropped uploaded image.

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
