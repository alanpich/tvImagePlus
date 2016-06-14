## Install from MODX Extras

Search for Image+ in the Package Manager of a MODX installation and install it in there.

## Manual installation

If you can't access the MODX Extras Repository in your MODX installation, you can manually install Image+.

* Download the transport package from [MODX Extras](http://modx.com/extras/package/imageplustvinput)
  (or one of the pre built transport packages in [_packages](https://github.com/Jako/ImagePlus/tree/master/_packages))
* Upload the zip file to your MODX installation's `core/packages` folder.
* In the MODX Manager, navigate to the Package Manager page, and select 'Search locally for packages' from the dropdown 
  button.
* Image+ should now show up in the list of available packages. Click the corresponding 'Install' button and follow 
  instructions to complete the installation.

## Build it from source

To build and install the package from source you could use [Git Package Management](https://github.com/TheBoxer/Git-Package-Management). 
The GitHub repository of Image+ contains a [config.json](https://github.com/Jako/ImagePlus/blob/master/_build/config.json) 
to build that package locally. Use this option, if you want to debug Image+ and/or contribute bugfixes and enhancements.

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
