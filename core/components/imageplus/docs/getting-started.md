## Creating a new Template Variable

Once Image+ is installed, you can create Template Variables [TV] in the normal way, but instead of setting the **Input 
Type** in Input Options to *Image*, select *Image+* instead.

For most use cases, you should also set the **Output Type** in Output Options to *Image+*. This allows you to control 
the image output on a resource.

## The cropping tool

When using an *Image+* TV, you could select an image exactly the same way as in a normal *Image* TV. Once an image 
is selected, a cropping window is displayed and you could select the area of the image to use. The original image is 
not changed and so you can upload a single image, and re-use it in several places at different sizes (and crops with 
multiple Image+ TVs) around the site.

If you want to change the cropping area, you have to click on the crop trigger of the Image+ TV. 

In the cropping window you have to drag the handles of the dotted box to change the cropping area. If the TV was 
configured with size constraints or an aspect ratio, the crop area will be restricted to match this aspect ratio.

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
