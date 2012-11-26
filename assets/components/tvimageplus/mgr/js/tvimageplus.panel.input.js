tvImagePlus.panel.input = function(config) {
    config = config || {};
    this.tvimageplus = config.tvimageplus;
    
    this.create_editButton();
    this.create_imageBrowser();
    this.create_imagePreview();
    
    
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
        },this.imagePreview]
    });
    tvImagePlus.panel.input.superclass.constructor.call(this,config);
};
Ext.extend(tvImagePlus.panel.input, MODx.Panel, {
    
    /**
     * Create the 'edit image' button
     */
    create_editButton: function(){
        this.editButton = new Ext.Button({
            text: _('tvimageplus.edit_image')
            ,handler: this.editImage
            ,scope:this
        })
    }//
    
    /**
     * Create the image browser combo
     */
    ,create_imageBrowser: function(){
        this.imageBrowser = new MODx.combo.Browser({
            value: this.tvimageplus.sourceImg.src
            
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
    
    ,generateThumbUrl: function(params){
        var url = MODx.config.connectors_url+'system/phpthumb.php?imageplus=1'
        var defaults = {
            wctx: 'mgr'
            ,f: 'png'
            ,q: 90
            ,w: 150
            ,source: this.tvimageplus.mediaSource
        }
        for(i in params){ defaults[i] = params[i]};
        for(i in defaults){
            url+= '&'+i+'='+defaults[i];
        };
        return url;
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
     //   console.log('onAfterRender',this.tvimageplus);
        this.updateDisplay();
    }//
    
    /**
     * Fired when user has selected an image from the browser
     */
    ,on_imageSelected: function(img){
        
        this.tvimageplus.sourceImg = {
            src: img.fullRelativeUrl
            ,width: img.image_width
            ,height: img.image_height
            ,source: this.tvimageplus.mediaSource
        }
        
        // Update display
        this.updateDisplay();
    }
    
    /**
     * Update the component display on state change
     */
    ,updateDisplay: function(){
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
        }
        var json = JSON.stringify(TV,null,'  ');
        
        
        var external = document.getElementById(this.updateTo);
        var current = external.value || '';
            if(current==''){ current=external.innerHTML}
        
        // Has value changed?
        if(current==json){ return }
        
        if(document.getElementById(this.updateTo)){
            document.getElementById(this.updateTo).value = json;
            document.getElementById(this.updateTo).innerHTML = json;
        }
        
        // Mark resource as dirty
        MODx.fireResourceFormChange()
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
        if(!this.tvimageplus.sourceImg || this.tvimageplus.crop.width==0){return;}
        url = this.generateThumbUrl({
                src: this.tvimageplus.sourceImg.src
                ,sw: this.tvimageplus.crop.width
                ,sh: this.tvimageplus.crop.height
                ,sx: this.tvimageplus.crop.x
                ,sy: this.tvimageplus.crop.y
            })
        if(this.imagePreview.el){
            this.imagePreview.el.dom.src = url;
        };
    }
    
});
Ext.reg('tvimageplus-panel-input',tvImagePlus.panel.input);
