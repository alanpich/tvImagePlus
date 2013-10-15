ImagePlus.window.CropTool = function(config) {
    config = config || {};




    Ext.applyIf(config,{
        modal: true,
        closeAction: 'destroy',
        resizable: false,
        collapsible: false,
        maximizable: false,
        allowDrop: false,
        title: _('tvimageplus.editor_title'),
        width: config.img.width || 450
        ,buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,id: 'imageplus-croptool-button-cancel'
            ,scope: this
            ,handler: function() {
                this.fireEvent('close');
                this.close();
            }
        },{
            text: config.saveBtnText || _('save')
            ,scope: this
            ,id: 'imageplus-croptool-button-save'
            ,handler: this.save
        }],
        crop: config.crop||{
            x: 0,
            y: 0,
            w: 60,
            h: 40
        },
        minCrop: config.minCrop || [500,200],
        enforceMinCrop: false,
        cropTooSmall: false,
        cropMoveEventThreshold: 333,
        cropBg: '#000',
        cropSmBg: '#400',
        items: [{
            html: '<img src="'+config.img.src+'" class="imageplus-croptool-inner" width="100%" />',
            border:false,
            margin: 0,
            padding:0,
            unstyled: true
        }]
    });
    ImagePlus.window.CropTool.superclass.constructor.call(this,config);

    this.on('afterrender',this.onAfterRender,this);
    this.on('show',this.onAfterShow,this);

    this.addEvents('save','close');
};
Ext.extend(ImagePlus.window.CropTool,MODx.Window,{

    onAfterRender: function(){
        this.cropToolDiv = $('.imageplus-croptool-inner',this.el.dom).first();
    },

    onAfterShow: function(){

//        console.log('aaaaarge');
//        setTimeout(function(that){return function(){
//           that.getCropTool().setSelect([
//                that.crop.crop_x,
//                that.crop.crop_y,
//                that.crop.crop_x + that.crop.crop_w,
//                that.crop.crop_y + that.crop.crop_h
//            ])
//        }}(this),500)


        this.getCropTool().setSelect([
            this.crop.crop_x,
            this.crop.crop_y,
            this.crop.crop_x + this.crop.crop_w,
            this.crop.crop_y + this.crop.crop_h
        ])
    },


    getCropTool: function(opts){
        if(this.cropTool){
            this.cropTool.destroy();
        }
        // Calculate maximum safest size for window
        var imgRatio = this.img.width / this.img.height;

        var acceptableWidth = this.img.width;
        var acceptableHeight = this.img.height;

        var maxWidth = $(window).outerWidth() - 30;
        var maxHeight = $(window).outerHeight() - 200;

        if(acceptableWidth > maxWidth){
            // Calculate height for this width
            var scaleRatio = this.img.width / maxWidth;
            acceptableWidth = maxWidth;
            acceptableHeight = Math.round(this.img.height / scaleRatio);
        }

        if(acceptableHeight > maxHeight){
            var heightScaleRatio = this.img.height / maxHeight;
            acceptableHeight = maxHeight;
            acceptableWidth = Math.round(this.img.width / heightScaleRatio);
        }


        /**
         * Options to pass to Jcrop constructor
         * @type {{}}
         */
        var cropToolOptions = {
            bgOpacity: 0.1,
            bgColor: '#000',
            minSize: this.enforceMinCrop? this.minCrop : [10,10],
            trueSize: [this.img.width,this.img.height],
            boxWidth: acceptableWidth,
            boxHeight: acceptableHeight,
            onSelect: function(that){return function(crop){
                that.onCropSet(crop);
            }}(this),
            onChange: ImagePlus.throttle(this.onCropMove,this.cropMoveEventThreshold,this)
        }
        // If both dimension constraints are set, fix the aspect ratio
        if(this.minCrop[0] > 0 && this.minCrop[1] > 0){
            cropToolOptions.aspectRatio = this.minCrop[0] / this.minCrop[1];
        }

        this.cropTool = jQuery.Jcrop(this.cropToolDiv,cropToolOptions)

//        var zoom = Math.round( (1 / this.cropTool.getScaleFactor()[0]) * 100);
//        this.setTitle('Image+' + '  <small>('+zoom+'%)</small>');

        this.setWidth(acceptableWidth+2);
        this.syncSize();
        this.center();

        return this.cropTool;
    },


    /**
     * Fired when the crop is released,
     * currently stores the location inside
     * the component but doesn't trigger a
     * save event
     *
     * @param crop
     */
    onCropSet: function(crop){
        this.crop = {
            x: Math.round(crop.x),
            y: Math.round(crop.y),
            w: Math.round(crop.w),
            h: Math.round(crop.h)
        }
    },

    /**
     * Fired as the crop selection is being changed
     * by the user.
     *
     * Currently used to notify the user that they are
     * trying to crop an area smaller than the required
     * output size, resulting in upscaling and shit images.
     * @issue #14
     *
     * @param crop {Object}
     */
    onCropMove: function(crop){
        var w=0,h=1,
            bgColor = this.cropBg;

        if( crop.w < this.minCrop[w] || crop.h < this.minCrop[h]){

            // Crop size is too small, show a warning
            bgColor = this.cropSmBg;
            this.cropTooSmall = true;

        } else {
            bgColor = this.cropBg;
            this.cropTooSmall = false;
        }

        this.cropTool.setOptions({
            bgColor: bgColor
        });
    },

    save: function(){

        var saveButtonId =  'yes';


        var save_actual = function(btnId){
            if(btnId!=='yes'&&btnId!=true)
                return;
                this.fireEvent('save',this.crop);
            this.close();
        }



        if(this.cropTooSmall){

            var titleText = [ _('warning'),' ',_('tvimageplus.err_crop_too_small')].join('');
            var bodyText =  [ _('tvimageplus.err_crop_too_small_desc') ,'<br /><br />', _('tvimageplus.are_you_sure')].join('');
            var msg = Ext.MessageBox.confirm( titleText, bodyText, save_actual, this)
        } else {
            save_actual.apply(this,[saveButtonId]);
        }


    }
});
Ext.reg('imageplus-window-croptool',ImagePlus.window.CropTool);