ImagePlus.panel.TVInput = function(config) {
    config = config || {};

    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,layout: 'column'
        ,width: 360
        ,border: false
        ,margin: 0
        ,padding:0
        ,style: {
            marginTop: '10px'
        }
        ,items: [{
            xtype: 'imageplus-imagepreview'
            ,width: 300
            ,height: 85
            ,text: 'Drop files here or click to upload'
//            ,url: ImagePlus.config.connector_url
//            ,params: {
//                action: 'image/upload'
//            }
//            ,unstyled: true
        },{
            xtype: 'imageplus-panel-imagecontrols'
            ,width: 30
            ,margin: 0
            ,padding:0
            ,listeners: {
                 upload: {fn: this.uploadImage,scope:this}
                ,browse: {fn: this.browseImages,scope: this}
                ,crop: {fn: this.cropImage,scope:this}
                ,clear: {fn: this.clearData,scope:this}
            }
        }]

    });
    ImagePlus.panel.TVInput.superclass.constructor.call(this,config);

};
Ext.extend(ImagePlus.panel.TVInput,MODx.Panel,{

    /**
     * Browse the server for images using MODX browser
     *
     * @returns void
     */
    browseImages: function(){
        if(!this.fileBrowser){
            this.fileBrowser = MODx.load({
                xtype: 'modx-browser'
                ,listeners: {
                    select: {fn:function(img){
                        var mediasource = parseInt(img.image.split('=').reverse().shift()),
                            path = img.relativeUrl,
                            url = img.relativeUrl
                        this.onSourceImageSelected(mediasource,path,url)
                    },scope:this}
                }
            });
        }
        this.fileBrowser.show();
    },

    /**
     * Show a file uploaded to select image from computer
     *
     * @returns void
     */
    uploadImage: function(){
        alert('Show file uploader');
    },

    /**
     * Show the image cropping window
     *
     * @returns void
     */
    cropImage: function(){
        alert('show crop window');
    },

    /**
     * Clear out all data and leave empty
     *
     * @return void
     */
    clearData: function(){
        alert('clear out data');
    },

    /**
     * Set the selected image to use
     *
     * @param mediasource {Number} Media Source ID
     * @param path {String} Path to image relative to Media Source root
     * @param url {String} Absolute URL for source image
     */
    onSourceImageSelected: function(mediasource,path,url){
        console.warn("Setting source image %s:%s:%s",mediasource,path,url);
    },


    /**
     * Asynchronously load an image and then pass it to a callback
     *
     * Callback function will receive 2 arguments -
     *   the first is {Bool} true on load, false on error
     *   the second is {Image} the image
     *
     * @param url {String} URL of image to load
     * @param cb  {Function} Callback function
     * @returns void
     */
    loadImage: function(url,cb){
        var img = new Image();
            img.onload = function(cb){return function(){
                cb(true,this);
            }}(cb)
            img.onerror = function(cb){return function(){
                cb(false,this);
            }}(cb)
        img.src = url;
    }


});
Ext.reg('imageplus-panel-tvinput',ImagePlus.panel.TVInput);