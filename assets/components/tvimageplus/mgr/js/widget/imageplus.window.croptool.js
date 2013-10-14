ImagePlus.window.CropTool = function(config) {
    config = config || {};




    Ext.applyIf(config,{
        modal: true,
        closeAction: 'destroy',
        resizable: false,
        collapsible: false,
        maximizable: false,
        allowDrop: false,
        title: "Image+",
        width: config.img.width || 450
        ,buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { this.close(); }
        },{
            text: config.saveBtnText || _('save')
            ,scope: this
            ,handler: this.save
        }],
        crop: {
            x: 0,
            y: 0,
            w: 20,
            h: 20
        },
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

    this.addEvents('save');
};
Ext.extend(ImagePlus.window.CropTool,MODx.Window,{

    onAfterRender: function(){
        this.cropToolInner = $('.imageplus-croptool-inner',this.el.dom);
    },

    onAfterShow: function(){

        // Calculate maximum safest size for window
        var imgRatio = this.img.width / this.img.height;

        var acceptableWidth = this.img.width;
        var acceptableHeight = this.img.height;

        var maxWidth = $(window).outerWidth() - 30;
        var maxHeight = $(window).outerHeight() - 200;

        console.log('MAX: ',maxWidth,maxHeight);



        if(acceptableWidth > maxWidth){
            // Calculate height for this width
            var scaleRatio = this.img.width / maxWidth;
            acceptableWidth = maxWidth;
            acceptableHeight = this.img.height / scaleRatio;
        }

        if(acceptableHeight > maxHeight){
            var heightScaleRatio = this.img.height / maxHeight;
            acceptableHeight = maxHeight;
            acceptableWidth = this.img.width / heightScaleRatio;
        }

        console.log(acceptableWidth,acceptableHeight);

        this.setSize(acceptableWidth,acceptableHeight);


        this.cropToolInner.Jcrop({
            bgOpacity: 0.1,
            bgColor: '#000',
            minSize: [20,20],
            boxWidth: acceptableWidth,
            boxHeight: acceptableHeight,
            trueSize: [this.img.width,this.img.height],
            onSelect: function(that){return function(crop){
                that.onCropChange(crop);
            }}(this)
        });

        this.syncSize();
        this.center();
    },


    onCropChange: function(crop){
        this.crop = {
            x: Math.round(crop.x),
            y: Math.round(crop.y),
            w: Math.round(crop.w),
            h: Math.round(crop.h)
        }
    },

    save: function(){
        this.fireEvent('save',this.crop);
        this.close();
    }
});
Ext.reg('imageplus-window-croptool',ImagePlus.window.CropTool);