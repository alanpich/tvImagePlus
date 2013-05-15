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


tvImagePlus.panel.input = function(config) {
    config = config || {};
    this.tvimageplus = config.tvimageplus;
    
    this.create_editButton();
    this.create_imageBrowser();
    this.create_imagePreview();
    this.create_altTextField();
    
    
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,updateTo: config.updateTo
        ,width: '100%'
        ,items: [{
            xtype: 'compositefield'
            ,anchor: '98%'
            ,hideLabel: true
            ,style: {
                marginBottom: '5px'
            }
            ,listeners: {
                 'render': {fn: this.on_Render,scope:this}
                ,'afterRender': {fn: this.onAfterRender,scope:this}
            }
            ,items: [this.imageBrowser,this.editButton]
        },this.altTextField,this.imagePreview]
    });
    tvImagePlus.panel.input.superclass.constructor.call(this,config);


    this.listenForResetEvent();
};
Ext.extend(tvImagePlus.panel.input, MODx.Panel, {


    /**
     * Bind change event on tv input DOM element so
     * that we can be notified when the user hits the
     * native 'Reset' button
     */
    listenForResetEvent: function(){
        var resourcePanel = Ext.getCmp('modx-panel-resource');
        resourcePanel.on('tv-reset',function(changed){
            if(changed.id = this.tvimageplus.tv.id){
                this.on_Reset();
            }
        },this)
    },

    /**
     * Create the 'edit image' button
     */
    create_editButton: function(){

        this.editButton = new Ext.Button({
            text: _('tvimageplus.edit_image')
            ,handler: this.editImage
            ,scope:this
            ,icon: tvImagePlus.config.crop_icon
        })
    }//
    
    /**
     * Create the image browser combo
     */
    ,create_imageBrowser: function(){
        // Generate opento path
        var openToPath = this.tvimageplus.sourceImg.src.split('/');
            openToPath.pop();
            openToPath = openToPath.join('/');
           
        // Create browser component
        this.imageBrowser = new MODx.combo.Browser({
            value: this.tvimageplus.sourceImg.src
            ,source: this.tvimageplus.mediaSource
            ,hideSourceCombo: true  
            ,openTo: openToPath
            ,listeners: {
                'select': {fn: this.on_imageSelected,scope:this}
            }
        })
    }
    
    /**
     * Create image preview img
     */
    ,create_imagePreview: function(){
        this.imagePreview = new Ext.BoxComponent({autoEl: {tag: 'img', src: ''}});
    }
    
    /**
     * Create field for alt-text input
     */
    ,create_altTextField: function(){
        this.altTextField = MODx.load({
            xtype: this.tvimageplus.altTagOn? 'textfield' : 'hidden'
            ,value: this.tvimageplus.altTag || ''
            ,listeners: {
                'change': {fn: this.on_altTagChange,scope:this}
            }
            ,width: 300
            ,style: {marginBottom:'5px'}
        })
    }
    
    
    
    ,generateThumbUrl: function(params){
        var url = MODx.config.connectors_url+'system/phpthumb.php?imageplus=1'
        var defaults = {
            wctx: 'mgr'
            ,f: 'png'
            ,q: 90
            ,w: 150
            ,source: this.tvimageplus.sourceImg.source
        }
        for(i in params){ defaults[i] = params[i]};
        for(i in defaults){
            url+= '&'+i+'='+defaults[i];
        };
        return url;
    }

    /**
     * Fires when the TV field is reset
     */
    ,on_Reset: function(){
        console.log('RESET!!!');
        this.imageBrowser.setValue('');
        this.tvimageplus.sourceImg = false;
        this.editButton.disable();
        this.updatePreviewImage.defer(10,this);
    }

    /**
     * Render form elements to page
     */
    ,on_Render: function(){

    }//
    
    /**
     * Runs after initial render of panel
     */
    ,onAfterRender: function(){
        this.updateDisplay();
    }//
    
    /**
     * Fired when user has selected an image from the browser
     */
    ,on_imageSelected: function(img){

        this.oldSourceImg = {};
        for(i in this.tvimageplus){
            this.oldSourceImg[i] = this.tvimageplus.sourceImg[i];
        }

        this.tvimageplus.sourceImg = {
            src: img.relativeUrl
            ,width: img.image_width
            ,height: img.image_height
            ,source: this.tvimageplus.mediaSource
        }
        
        // If server returns 800x600, image may be larger
        //  so need to get size manually
        if(img.image_width == 800 && img.image_height == 600){
            this.manual_getImageSize();
        } else {        
            // Update display
            this.updateDisplay();
        };
    }//
    
    /**
     * Fired when alt-tag field is changed
     */
    ,on_altTagChange: function(field, value){
        this.tvimageplus.altTag = value;
        this.updateExternalField();
    }
    
    /**
     * Manually get image size
     * @return void
     */
    ,manual_getImageSize: function(){
        var baseUrl = tvImagePlus.config['sources'][this.tvimageplus.sourceImg.source].url;
        var img = new Image();
            img.onload = (function(ths){ return function(){
                ths.tvimageplus.sourceImg.width = this.width;
                ths.tvimageplus.sourceImg.height = this.height;
                ths.updateDisplay();
            }})(this);
        img.src = baseUrl+this.tvimageplus.sourceImg.src;
    }//


    /**
     * Update the component display on state change
     */
    ,updateDisplay: function(){

        // Make sure image is large enough to use
        if(!this.checkImageIsLargeEnough()){
            this.tvimageplus.sourceImg = this.oldSourceImg;
            console.log(this.imageBrowser.reset());
            MODx.msg.alert("Image too small","The selected image is too small to be used here. Please select a different image");
            return;
        }

        // Hide 'edit' button if field is empty
        if(this.imageBrowser.getValue()==''){
            this.editButton.disable();
        } else {
            this.editButton.enable();
        }
        this.updatePreviewImage.defer(10,this);
        
        this.updateExternalField();
    }//


    /**
     * Update updateTo field input field value
     */
    ,updateExternalField: function(){
      //  console.log(this.updateTo);
        var TV = {
            sourceImg: this.tvimageplus.sourceImg
            ,crop: this.tvimageplus.crop
            ,targetWidth: this.tvimageplus.targetWidth
            ,targetHeight: this.tvimageplus.targetHeight
            ,altTag: this.tvimageplus.altTag
        }
        var json = JSON.stringify(TV,null,'  ');
        
        
        var external = document.getElementById(this.updateTo);
        var current = external.value || '';
            if(current==''){ current=external.innerHTML}
        
        // Has value changed?
        if(current==json){ return }
        
        if(document.getElementById(this.updateTo)){
            document.getElementById(this.updateTo).value = json;
//            document.getElementById(this.updateTo).innerHTML = json;
        }
        
        // Mark resource as dirty
        MODx.fireResourceFormChange()
    }


    /**
     * Checks whether the image is larger than specified crop dimensions
     * @returns bool
     */
    ,checkImageIsLargeEnough: function(){
        if(this.tvimageplus.targetWidth > 0){
            if(this.tvimageplus.targetWidth > this.tvimageplus.sourceImg.width){
                return false;
            }
        }
        if(this.tvimageplus.targetHeight > 0){
            if(this.tvimageplus.targetHeight > this.tvimageplus.sourceImg.height){
                return false;
            }
        }
        return true;
    }
    
    
    /**
     * Launch the editor window
     */
    ,editImage: function(){
        // Create the editor window (if it doesnt exist)
        if(!this.editorWindow){
            
            // Calculate safe image ratio
            var imgW = this.tvimageplus.sourceImg.width;
            var imgH = this.tvimageplus.sourceImg.height;
            var maxH = window.innerHeight * 0.7;
            var maxW = window.innerWidth * 0.7;
                // Is image taller than screen?
                if(imgH > maxH){
                    var ratio = maxH/imgH
                } else
                if(imgW > maxW){
                    var ratio = maxW/imgW
                } else {
                    var ratio = 1;
                }
                
            
            
            this.editorWindow = MODx.load({
                xtype: 'tvimageplus-window-editor'
                ,title: _('tvimageplus.editor_title')
                ,tvimageplus: this.tvimageplus
                ,inputPanel: this
                ,displayRatio: ratio
            //    ,autoWidth: true
                ,width: imgW*ratio
                ,crop: this.tvimageplus.crop
            });
            
        };
        // Show the window
        this.editorWindow.show();
    }//
    
    
    /**
     * Receive new cropping dimensions from editor
     */
    ,updateFromEditor: function(crop){
        this.tvimageplus.crop = crop;
        this.editorWindow = null;
        this.updateDisplay();
    }
    
    ,updatePreviewImage: function(){
        if(!this.tvimageplus.sourceImg || this.tvimageplus.crop.width==0){
            this.imagePreview.hide();
            return;
        }
        url = this.generateThumbUrl({
                src: this.tvimageplus.sourceImg.src
                ,sw: this.tvimageplus.crop.width
                ,sh: this.tvimageplus.crop.height
                ,sx: this.tvimageplus.crop.x
                ,sy: this.tvimageplus.crop.y
            })
        if(this.imagePreview.el){
            this.imagePreview.el.dom.src = url;
            this.imagePreview.show()
        };
    }
    
});
Ext.reg('tvimageplus-panel-input',tvImagePlus.panel.input);
