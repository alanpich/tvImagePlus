/*
 * Copyright 2013 by Alan Pich <alan.pich@gmail.com>
 *
 * This file is part of tvImagePlus
 *
 * tvImagePlus is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * tvImagePlus is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Vapor; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package tvImagePlus
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */


tvImagePlus.jquery.ImageCrop= function(config) {
    config = config || {};
    this.tvimageplus = config.tvimageplus;
    this.window = config.window;
    this.imageDOMid = Ext.id();
    
    Ext.apply(config,{
        cropData: this.tvimageplus.crop
        ,collapsable: false
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
Ext.extend(tvImagePlus.jquery.ImageCrop, Ext.Panel, {

    
    
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
                ,outerImage: this.window.getOuterImageUrl()
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
                    this.setOptions({
                        outerImage: ths.window.getOuterImageUrl()
                        ,bgOpacity: 0.5
                    })
            }}(this))
        }//
        
    ,get_image: function(){
            return this.$image;
        }//
    
    
    
  });
Ext.reg('tvimageplus-jquery-imagecrop',tvImagePlus.jquery.ImageCrop);
