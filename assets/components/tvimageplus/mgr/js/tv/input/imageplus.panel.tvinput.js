ImagePlus.panel.TVInput = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,layout: 'column'
        ,width: 390
        ,margin: 0
        ,padding:0
        ,isBusy: false
        ,tvElId: false
        ,style: {
            marginTop: '10px'
        }
        ,items: [
            this.createPreviewPanel(),
            this.createControlButtons()
        ]
    });
    ImagePlus.panel.TVInput.superclass.constructor.call(this,config);

    // Set the source image defaults
    this.sourceImage = {
        mediasource: null,
        path: null,
        url: null,
        width: null,
        height: null,
        ratio: null
    }

    // Set the actual image defaults
    this.image = {
        url: null,
        img: null,
        crop_x: 0,
        crop_y: 0,
        crop_w: 0,
        crop_h: 0,
        width: 0,
        height: 0
    }

};
Ext.extend(ImagePlus.panel.TVInput,MODx.Panel,{


    afterRender: function(){
        this.supr().afterRender.call(this);

        // Show loading mask while initializing
       this.mask("Initializing...");

        // Check that this TV has been initialized
        // and is ready to use
        Ext.onReady(Ext.createDelegate(this.initialize,this));
    },


    /**
     * Initializes a fresh TV for use
     *
     * @returns void
     */
    initialize: function(){

        // Grab the tv input element
        var elId = 'imageplus-tmp-value-'+this.tvId,
            tmpEl = document.getElementById(elId),
            tvValue = tmpEl.innerHTML,
            tvId = this.tvId;

        tmpEl.parentNode.removeChild(tmpEl);

        Ext.Ajax.request({
            url: ImagePlus.config.connector_url,
            params: {
                action: 'initialize',
                value: tvValue,
                tvId: tvId
            },
            scope: this,
            success: this.onInitializeResponse
        });
    },

    /**
     * Handles the response from server to complete
     * the TV intialization
     *
     * @returns void
     */
    onInitializeResponse: function(response,options){
        console.log("RESPONSE ",arguments);

        this.onInitializationComplete();
    },


    /**
     * Fired once the TV has confirmed to itself
     * that it is fully ready to perform its function.
     *
     * @returns void
     */
    onInitializationComplete: function(){
        // Create the FineUploader
        Ext.defer(this.createUploader,1000,this);

        // We're ready! Hide the loadmask!
        this.unmask();
    },


    /**
     * Create a loadMask when the TV is busy
     *
     * @param msg {String} The message to display
     * @returns void
     */
    mask: function(msg){
        msg = msg||'Loading...';
        this.loadMask = new Ext.LoadMask(this.previewPanel.el,{
            msg: msg,
            removeMask: true
        });
        this.loadMask.show();
        this.isBusy = true;
    },

    /**
     * Remove the loadMask to resume normal operation
     *
     * @returns void
     */
    unmask: function(){
        if(this.loadMask){
            this.loadMask.hide();
            this.loadMask.destroy();
        }
        this.isBusy = false;
    },

    /**
     * Create the Image Preview panel
     *
     * @returns {ImagePlus.panel.ImagePreview}
     */
    createPreviewPanel: function(){
        if(!this.previewPanel){
            this.previewPanel = MODx.load({
                xtype: 'imageplus-panel-imagepreview'
                ,width: 300
            });
        }
        this.previewPanel.on('imageuploaded',Ext.createDelegate(function(data){
            this.onSourceImageSelected(
                data.mediasource,
                data.path,
                ImagePlus.mediaSourceUrlMap[data.mediasource] + data.url
            );
        },this));
        return this.previewPanel;
    },

    /**
     * Create the panel holding the control buttons,
     * and attach listeners to the events it emits
     *
     * @returns {ImagePlus.panel.ImageControls}
     */
    createControlButtons: function(){
        this.controlButtons = MODx.load({
            xtype: 'imageplus-panel-imagecontrols',
            listeners: {
                browse: {fn: this.browseImages,scope: this}
                ,crop: {fn: this.cropImage,scope:this}
                ,clear: {fn: this.clearData,scope:this}
            }
        });
        return this.controlButtons;
    },


    /**
     * Create an instance of FineUploader to use
     * for uploading files
     *
     * @returns void
     */
    createUploader: function(){
        // Gather the DOM elements for bindings
        var previewEl = this.previewPanel.el.dom,
            buttonEl = this.controlButtons.uploadButton.el.dom;

        this.uploader = new qq.FineUploaderBasic({
            debug: true,
            request: {
                endpoint: ImagePlus.config.connector_url,
                params: {
                    action: 'upload',
                    HTTP_MODAUTH: MODx.siteId,
                    inputName: 'file'
                }
            },
            allowedExtensions: [
                'jpg','jpeg',
                'png',
                'gif'
            ],
            // The 'click me' element
            button: previewEl,
            extraButtons: [{
                element: buttonEl
            }],
            camera: {
                ios: true
            },
            paste: {
                targetElement: previewEl
            },
            callbacks: {
                onUpload: Ext.createDelegate(this.onUploadDone,this)
            }
        });
    },

    /**
     * Browse the server for images using MODX browser
     *
     * @returns void
     */
    browseImages: function(){
        if(this.isBusy) return;

        if(!this.fileBrowser){
            this.fileBrowser = MODx.load({
                xtype: 'modx-browser'
                ,listeners: {
                    select: {fn:function(img){
                        var mediasource = parseInt(img.image.split('=').reverse().shift()),
                            path = img.relativeUrl,
                            url = ImagePlus.mediaSourceUrlMap[mediasource] + img.relativeUrl
                        this.onSourceImageSelected(mediasource,path,url)
                    },scope:this}
                }
            });
        }
        this.fileBrowser.show();
    },

    /**
     * Show the image cropping window
     *
     * @returns void
     */
    cropImage: function(){
        if(this.isBusy) return;
        alert('show crop window');
    },

    /**
     * Clear out all data and leave empty
     *
     * @return void
     */
    clearData: function(){
        if(this.isBusy) return;

        // Set the source image defaults
        this.sourceImage = {
            mediasource: null,
            path: null,
            url: null,
            width: null,
            height: null,
            ratio: null
        }

        // Set the actual image defaults
        this.image = {
            url: null,
            img: null,
            crop_x: 0,
            crop_y: 0,
            crop_w: 0,
            crop_h: 0,
            width: 0,
            height: 0
        }

        this.previewPanel.clearImage();
    },

    /**
     * Set the selected image to use
     *
     * @param mediasource {Number} Media Source ID
     * @param path {String} Path to image relative to Media Source root
     * @param url {String} URL for source image
     */
    onSourceImageSelected: function(mediasource,path,url){

        this.sourceImage = {
            mediasource: mediasource,
            path: path,
            url: url
        }

        this.loadImage(url,Ext.createDelegate(this.onSourceImageLoaded,this));
    },

    /**
     * Receives a loaded Image object of the source image
     *
     * @param success {Boolean} True if the image loaded ok
     * @param img {Image} The source image
     * @returns void
     */
    onSourceImageLoaded: function(success,img){
        if(!success){
            MODx.msg.alert("Image+ Error","Failed to load image");
            return;
        }
        this.sourceImage.width = img.width;
        this.sourceImage.height = img.height;
        this.sourceImage.ratio = img.width/img.height;

        this.previewPanel.setImage(img);
    },


    /**
     * Asynchronously load an image and then pass it to a callback
     *
     * Callback function will receive 2 arguments -
     *   the first is {Bool} true on load, false on error
     *   the second is {Image} the image
     *
     * @param url {String}   URL of image to load
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
        img.src = url+'?t='+new Date().getTime();
    }


});
Ext.reg('imageplus-panel-tvinput',ImagePlus.panel.TVInput);