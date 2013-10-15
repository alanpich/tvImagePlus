ImagePlus.panel.TVInput = function(config) {
    config = config || {};

    /** xtype of component to use for image selection */
    var xtypeSourceImageSelect = 'imageplus-combo-browser';

    /**
     * Config defaults
     */
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,anchor: 300
        ,tvElId: config.tvElId || false
        ,value: config.value || ''
        ,tv: config.tv || {
            url: '',
            alt: '',
            uid: 0,
            version: '3.0.0'
        }
        ,params: config.params || {}
        ,image: config.image || {
            mediasource: 1,
            path: '',
            crop_x: 0,
            crop_y: 0,
            crop_w: 0,
            crop_h: 0,
            output_width: 0,
            output_height: 0
        }
        ,listeners: {
            afterrender: {fn:this.onAfterRender,scope:this}
        }
        ,items: [{
            xtype: 'compositefield',
            width: 400,
            items:[{
                xtype: xtypeSourceImageSelect,
                source: config.image.mediasource || 1,
                openTo: ImagePlus.getPathDir(config.image.path) || '',
                value:  config.image.path || '',
                listeners: {
                    imageReady: {fn:this.onSourceImageSelected,scope:this},
                    busy: {fn: this.onBusy,scope:this}
                }
            },{
                xtype: 'button',
                text: 'Edit Image',
                id: 'imageplus-button-editimage',
                scope: this,
                handler: this.showCropTool
            }]
        },{
            xtype: 'imageplus-panel-previewimage'
        },{
            xtype: 'textfield',
            id: 'imageplus-textfield-alttext',
            fieldLabel: 'Alt Text',
            listeners: {
                change: {fn:this.onUpdateAltTextField,scope:this}
            }
        }]
    });
    ImagePlus.panel.TVInput.superclass.constructor.call(this,config);

};
Ext.extend(ImagePlus.panel.TVInput,MODx.Panel,{

    /**
     * Fires once the panel has been rendered onto the page
     *
     * @returns void
     */
    onAfterRender: function(){

        this.previewImage = this.getComponent('imageplus-panel-previewimage');
        this.altTextField = this.getComponent('imageplus-textfield-alttext');
        this.altTextField.setValue(this.tv.alt);

        this.editButton = this.getComponent('imageplus-button-editimage');

        if(this.tv.uid > 0){
            this.onInitializationComplete();
        } else {
            this.initializeTV();
        }
    },

    /**
     * Fired when AJAX initialization is complete
     * and the TV is ready for use
     *
     * @returns void
     */
    onInitializationComplete: function(){
        this.onReady();
        this.updateTVInput();
        this.updatePreviewImage();
    },

    /**
     * Fires once an image has been selected, and
     * loaded into the browser for manipulation
     *
     * @param img {Image}
     * @returns void
     */
    onSourceImageSelected: function(img,data){
        this.image.mediasource = data.ms;
        this.image.path = data.path;
        this.sourceDataUrl = '/'+this.image.path;
        this.tv.url = img.src;
        this.onReady();
        this.updateTVInput();
        this.updatePreviewImage();
        this.persistData();
    },

    /**
     * Fired when the component is set to 'busy',
     * blocking interaction from the user and
     * displaying a please-wait message
     *
     * @returns void
     */
    onBusy: function(){
        this.getLoadMask().show();
    },

    /**
     * Fired when the component stops being 'busy',
     * and can allow user interaction again
     *
     * @returns void
     */
    onReady: function(){
        this.getLoadMask().hide();
    },

    /**
     * Fired when the alt-text field value has changed
     *
     * @returns void
     */
    onUpdateAltTextField: function(){
        this.tv.alt = this.altTextField.getValue();
        this.updateTVInput();
    },

    /**
     * Initialize the TV by getting a uid for it
     *
     * @returns void
     */
    initializeTV: function(){
        this.onBusy();
        setTimeout(function(that){ return function(){
            MODx.Ajax.request({
                url: ImagePlus.config.connector_url,
                params: {
                    action: 'initialize'
                },
                listeners: {
                    success: {fn: function(response){
                        console.log(response);
                        that.tv.uid = response.object.id;
                        that.onInitializationComplete();
                    },scope:that}
                }
            })
        }}(this),1000);
    },

    /**
     * Returns the load mask component, initializing
     * it if it doesn't already exist
     *
     * @returns {Ext.LoadMask}
     */
    getLoadMask: function(){
        if(!this.loadMask){
            this.loadMask = new Ext.LoadMask(this.container,{
                msg: 'Please wait...'
            });
        }
        return this.loadMask;
    },

    /**
     * Create & display a cropping tool for
     * editing the image crop dimensions
     *
     * @returns void
     */
    showCropTool: function(){

        if(this.$cropToolDiv){ this.$cropToolDiv.destroy() }

        this.onBusy();

        var img = new Image();
        //noinspection JSValidateTypes
        img.onload = function(ths){return function(){
                ths._showCropTool(this);
            }}(this);
            img.src = this.getSourceImageUrl();

    },

    /**
     * Does the leg work of initializing the CropTool
     *
     * @param img {Image}
     */
    _showCropTool: function(img){

        // Check for a fixed ratio
        var enforceMinCrop = false;
        if( (this.params.targetWidth || 0) > 0 || (this.params.targetHeight || 0) > 0 ){
        //    enforceMinCrop = true;
        }



        this.$cropToolDiv = new ImagePlus.window.CropTool({
            img: img,
            minCrop: [this.params.targetWidth,this.params.targetHeight],
            enforceMinCrop: enforceMinCrop,
            crop: {
                crop_x: this.image.crop_x,
                crop_y: this.image.crop_y,
                crop_w: this.image.crop_w,
                crop_h: this.image.crop_h
            },
            listeners: {
                save: {fn:this.onCropChange,scope:this},
                close: {fn:function(){
                    this.onReady();
                },scope:this}
            }
        });
        this.onBusy();
        this.$cropToolDiv.show();
    },


    /**
     * Fired when the image crop has been changed
     *
     * @param crop
     */
    onCropChange: function(crop){
        this.image.crop_x =  crop.x;
        this.image.crop_y =  crop.y;
        this.image.crop_w =  crop.w;
        this.image.crop_h =  crop.h;
        this.persistData();
    },

    /**
     * Writes tv data back into tv field as json
     *
     * @returns void
     */
    updateTVInput: function(){
        if(this.tvElId !== false){
            if(!this.tv.version){this.tv.version = '3.0.0'}
            var json = Ext.util.JSON.encode(this.tv);
            var tvEl = document.getElementById(this.tvElId);
            var currentJson = tvEl.value;

            if(json != currentJson){
                document.getElementById(this.tvElId).value = json;
                var parent = Ext.getCmp('modx-panel-resource');
                if(parent){
                    parent.fireEvent('fieldChange');
                }
            }
        }
    },

    /**
     * Update the preview image display
     *
     * @returns void
     */
    updatePreviewImage: function(){
        var scaledSrc = ImagePlus.image.scaleToWidth(this.tv.url,300,function(that){return function(src){
            that.previewImage.setSrc(src);
        }}(this));
    },

    /**
     * Update the data stored in the database with the current settings
     *
     * @returns void
     */
    persistData: function(){
        this.onBusy();
        var data = {
            tv: this.tv,
            crop: this.image
        };

        MODx.Ajax.request({
            url: ImagePlus.config.connector_url,
            params: {
                action: 'update',
                uid: this.tv.uid,
                data: Ext.util.JSON.encode(data)
            },
            listeners: {
                success: {fn:this.onPersistDataSuccess,scope:this},
                failure: {fn:this.onPersistDataError,scope:this}
            }
        })
    },

    /**
     * Fires when a persistData call is successful
     *
     * @returns void
     */
    onPersistDataSuccess: function(response){
        this.tv = response.object.tv;
        this.updateTVInput();
        this.updatePreviewImage();
        this.onReady();
    },

    /**
     * Fires when a persistData call throws an error
     *
     * @returns void
     */
    onPersistDataError: function(){
        this.onReady();
    },

    /**
     * Get the URL to this TV's source image
     *
     * @returns {String}
     */
    getSourceImageUrl: function(){
        return ImagePlus.getMediaSourceRelativeUrl(this.image.mediasource,this.image.path);
    }


});
Ext.reg('imageplus-panel-tvinput',ImagePlus.panel.TVInput);