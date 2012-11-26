tvImagePlus.jquery.ImageCrop= function(config) {
    config = config || {};
    this.tvimageplus = config.tvimageplus;
    this.window = config.window;
    this.imageDOMid = Ext.id();
    
    Ext.apply(config,{
        cropData: this.tvimageplus.crop
        ,items: [{
            html: '<img id="'+this.imageDOMid+'" src="'+this.window.getImageUrl()+'" />'
        }]
        ,listeners: {
            'afterRender':{fn:this.on_afterRender,scope:this}
            ,'destroy': {fn:function(){this.cropper.destroy()},scope:this}
        }
    });
    tvImagePlus.jquery.ImageCrop.superclass.constructor.call(this,config);
};
Ext.extend(tvImagePlus.jquery.ImageCrop, MODx.Panel, {

    
    
    on_afterRender: function(){
            this.initJcrop.defer(10, this)
        }// 
        
    ,initJcrop: function(){
            this.$image = $('#'+this.imageDOMid)
                          .data('ext',this.window);
            
            var conf = {
                minSize: this.window.getMinCropSize()
                ,aspectRatio: this.window.getAspectRatio()
                ,setSelect: this.window.getCropCoords()
                ,onSelect: function(ext){
                        return function(crop){
                            ext.on_cropChange({
                                x: crop.x,
                                y: crop.y,
                                width: crop.w,
                                height: crop.h
                            })
                        }
                    }(this.window)
            };
            this.$image.Jcrop(conf,function(ths){ return function(){
                    ths.cropper = this;
            }}(this))
        }//
        
    ,get_image: function(){
            return this.$image;
        }//
    
    
    
  });
Ext.reg('tvimageplus-jquery-imagecrop',tvImagePlus.jquery.ImageCrop);
