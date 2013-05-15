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


tvImagePlus.window.Editor = function(config) {
    config = config || {};
    this.tvimageplus = config.tvimageplus;
    this.inputPanel = config.inputPanel;
    this.displayRatio = config.displayRatio;
    
    Ext.apply(config,{
        border: false
        ,crop: this.tvimageplus.crop
        ,resizable: false
        ,closeAction: 'close'
        ,listeners: {
            'close': {fn: this.on_close,scope:this}
            ,'success': {fn:function(){console.log('success')}}
            ,'show': {fn:this.on_show,scope:this}
        }
        ,items: [{
            xtype: 'tvimageplus-jquery-imagecrop'
            ,tvimageplus: this.tvimageplus
            ,initialWidth: this.getDisplayWidth()
            ,initialHeight: this.getDisplayHeight()
            ,imageUrl: this.getImageUrl()
            ,window: this
            ,listeners: {
                'change': {fn: this.on_cropChange,scope:this}
            }
            ,cropData: this.tvimageplus.crop
        }]
        ,buttonAlign: 'right'
        ,buttons: [{
            text: _('cancel')
            ,handler: this.updateFromEditor
            ,scope: this    
        },{      
            text: _('update')
            ,handler: this.updateFromEditor
            ,scope: this
        }]
    });
    tvImagePlus.window.Editor.superclass.constructor.call(this,config);
};
Ext.extend(tvImagePlus.window.Editor, Ext.Window, {
    
    // Get the required width of the cropper
    getDisplayWidth: function(){
        return Math.round(this.tvimageplus.sourceImg.width * this.displayRatio);
    }//
    ,getDisplayHeight: function(){
        return Math.round(this.tvimageplus.sourceImg.height * this.displayRatio);
    }
    
    /**
     * Get a url to image resized for window
     */
    ,getImageUrl: function(){ 
        var url = this.inputPanel.generateThumbUrl({
                src: this.tvimageplus.sourceImg.src
                ,w: this.getDisplayWidth()
                ,h: this.getDisplayHeight()
            })
        return url;
    }//
    
    ,getOuterImageUrl: function(){
        var url = this.inputPanel.generateThumbUrl({
                src: this.tvimageplus.sourceImg.src
                ,w: this.getDisplayWidth()
                ,h: this.getDisplayHeight()
                ,'fltr[]': 'blur|25'
            })
        return url;
    }//
    
    ,getMinCropSize: function(){
        return [ 
            this.tvimageplus.targetWidth * this.displayRatio
            ,this.tvimageplus.targetHeight * this.displayRatio
        ]
    }
    
    ,getMinCropWidth: function(){
        return this.tvimageplus.targetWidth * this.displayRatio;
    }
    ,getMinCropHeight: function(){
        return this.tvimageplus.targetHeight * this.displayRatio;
    }
    ,getInitialCropX: function(){
        return this.tvimageplus.crop.x * this.displayRatio;
    }
    ,getInitialCropY: function(){
        return this.tvimageplus.crop.y * this.displayRatio;
    }
    ,getInitialCropWidth: function(){
        if(this.tvimageplus.crop.width==0){
            return this.tvimageplus.targetWidth * this.displayRatio;
        } else {
            return this.tvimageplus.crop.width * this.displayRatio;
        };
    }
    ,getInitialCropHeight: function(){
        if(this.tvimageplus.crop.height==0){
            return this.tvimageplus.targetHeight * this.displayRatio
        } else {
            return this.tvimageplus.crop.height * this.displayRatio;
        };
    }
    ,getAspectRatio: function(){
        if( this.tvimageplus.targetWidth>0 && this.tvimageplus.targetHeight>0){
            return this.tvimageplus.targetWidth / this.tvimageplus.targetHeight;
        } else { return false}
    }
    
    ,getCropCoords: function(){
            var W = this.getInitialCropWidth();
            var H = this.getInitialCropHeight();
            if(W==0||H==0){ return false; }
            var X = this.getInitialCropX();
            var Y = this.getInitialCropY();
            return [X,Y,(X+W),(Y+H)];
    }
    
    /**
     * Handle window closing
     */
    ,on_close: function(){
        this.inputPanel.editorWindow = false; 
    }
    
    ,on_show: function(){
        this.center.defer(150,this);
    }//
    
    /**
     * Handle crop area change
     */
    ,on_cropChange: function(data){
        this.crop.height = Math.round(data.height/this.displayRatio);
        this.crop.width = Math.round(data.width/this.displayRatio);
        this.crop.x = Math.round(data.x/this.displayRatio);
        this.crop.y = Math.round(data.y/this.displayRatio);
    }
    
    ,updateFromEditor: function(){
        this.inputPanel.updateFromEditor(this.crop);
        this.close();
    }
    
});
Ext.reg('tvimageplus-window-editor',tvImagePlus.window.Editor);
