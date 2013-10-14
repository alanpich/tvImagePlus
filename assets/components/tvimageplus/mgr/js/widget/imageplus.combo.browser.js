ImagePlus.combo.Browser = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        hideSourceCombo: true,
        multiple: false,
        allowedFileTypes: 'png,jpg,jpeg,gif'
    });

    console.log(config);
    ImagePlus.combo.Browser.superclass.constructor.call(this,config);


    this.on('select',this.onFileSelected,this);
};
Ext.extend(ImagePlus.combo.Browser,MODx.combo.Browser,{

    onFileSelected: function(imgData){
        //@TODO Make absUrl flexible for Media Sources (currently only does web)
        var absUrl = '/'+imgData.fullRelativeUrl;

        this.fireEvent('busy');

        var data = {
            absUrl: absUrl,
            ms: this.source,
            path: imgData.fullRelativeUrl
        }

        var img = new Image();
            img.onload = function(that,data){return function(){
                that.onImageDownloaded(this,data);
            }}(this,data)
            img.src = absUrl;

    },

    onImageDownloaded: function(img,data){
        this.fireEvent('imageReady',img,data);
    }


});
Ext.reg('imageplus-combo-browser',ImagePlus.combo.Browser);