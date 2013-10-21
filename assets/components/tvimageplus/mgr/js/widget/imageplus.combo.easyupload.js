ImagePlus.combo.EasyUpload = function(config) {
    config = config || {};

    //noinspection JSValidateTypes
    Ext.apply(config,{
        border: false
        ,isUpload: true
        ,url: '{$assets}connector.php'
        ,listeners: {
            change:         {fn: this.onFileSelected,scope:this }
            ,success:       {fn: this.onUploadSuccess,scope:this}
            ,failure:       {fn: this.onUploadFailure,scope:this}
        }
    })
    ImagePlus.combo.EasyUpload.superclass.constructor.call(this,config);


    // Create separate formPanel for uploading files
    this.createUploadForm();

    // Hide the actual textarea tv field
    this.el.dom.type = 'hidden';

    // Create the trigger button
    this.Button = MODx.load({
        xtype: 'button'
        ,text: this.value==''? this.text : this.altText
        ,handler: this.onButtonClick
        ,scope: this
        ,float: 'left'
        ,renderTo: this.el.wrap()
    })


    // Create the extra info
    this.createControls();


};
Ext.extend(ImagePlus.combo.EasyUpload,Ext.form.TextField,{


    createUploadForm: function(){

        this.UploadForm = MODx.load({
            xtype: 'modx-formpanel'
            ,id: this.uploadFormInputId
            ,renderTo: 'modx-content'
            ,isUpload: true
            ,hidden: true
            ,url: MODx.config.assets_url+'components/tveasyupload/connector.php'
            ,baseParams: {
                action: 'browser/file/upload'
                ,res_id: this.res_id
                ,tv_id: this.tv_id
                ,ms_id: this.ms_id
            }
            ,TV: this
            ,listeners: {
                success: {fn: this.onUploadSuccess, scope:this}
            }
            ,items: [{
                xtype:'filefield'
                ,TV: this
                ,listeners: {
                    'change': {fn: this.onFileSelected, scope:this }
                }
            }]
        })

        // Grab the filefield component from the form
        this.UploadField = this.UploadForm.items.items[0];

        // Force the form to be multipart/form-data
        this.UploadForm.form.el.dom.setAttribute('enctype','multipart/form-data')

        // I have absolutely no idea why i need to do this, but i do
        this.UploadForm.errorReader.read = function(response){ return Ext.util.JSON.decode(response.responseText) }

        // Grab change events from the file input
        this.relayEvents(this.UploadField,['change']);

        // Grab submit success/fail events from the form
        this.relayEvents(this.UploadForm.form,['failure','submit']);


    }


    /**
     * Create TV controls
     */
    ,createControls: function(){

        // Show the field value as text (if required)
        if(this.showValue){
            this.DisplayValue = this.el.wrap().createChild({
                tag: 'label'
                ,size: 13
                ,html: this.value
                ,cls: 'modx-version'
                ,float: 'left'
                ,style: {
                    margin: '.2em auto .5em'
                    //        ,float: 'left'
                }
            });
        }

        // Allow user to clear the field with a button
        this.ClearButton = this.Button.el.wrap().createChild({
            tag: 'img'
            ,size: 13
            ,src: MODx.config.manager_url+'templates/default/images/style/delete.png'
            ,height: 12
            ,alt: this.clearText
            ,title: this.clearText
            ,hidden: true
            ,style: {
                display: 'inline'
                ,position: 'relative'
                ,'top': '0px'
                ,'margin-left':'7.5em'
                ,'margin-top':'1.1em'
                ,cursor: 'pointer'
                ,float: 'left'
                ,position: 'absolute'
            }
        });
        this.ClearButton.on('click',this.onClearButtonClick,this);
        this.showHideClearButton(this.value);


        // File/Image preview
        if(this.showPreview){
            this.Preview = this.el.wrap().createChild({
                tag: 'img'
                ,width: 94
                ,src: this.getValue() || MODx.config.assets_url+'components/tveasyupload/mgr/dud.gif'
                ,style: {
                    display: 'block',
                    'margin-bottom': '.3em'
                }
            })
        };
        this.showHidePreview(this.value);
    }



    ,updateDisplay: function(url){
        this.setDisplayValue(url);
        this.showHideClearButton(url);
        this.showHidePreview(url);
        this.setButtonText(url);
    }


    /**
     * Set the displayed value
     * @param text  {String}    Value to display
     */
    ,setDisplayValue: function(text){
        if(!this.showValue){return}
        this.DisplayValue.dom.innerHTML = text
    }

    ,setButtonText: function(url){
        if(url==null || url.trim().length < 1){
            this.Button.setText(this.text)
        } else {
            this.Button.setText(this.altText);
        }
    }

    /**
     * Show or Hide the 'clear' button depending if the TV is empty
     * @param url {String} DisplayValue
     */
    ,showHideClearButton: function(url){
        if(url == null || url.trim().length < 1){
            this.ClearButton.hide();
        } else {
            this.ClearButton.show();
        }
    }

    /**
     * Show or Hide the preview image
     */
    ,showHidePreview: function(url){
        if(!this.showPreview){return}
        if(url.trim().length < 1){
            this.Preview.setDisplayed('none');
        } else {
            console.log('show',url);
            console.log(this.Preview)
            var phpThumbUrl = '../connectors/system/phpthumb.php?w=94&zc=0&src='+url+'&wctx=web&source='+this.ms_id
            this.Preview.dom.src = phpThumbUrl;
            this.Preview.setDisplayed('block');
        }
    }



    /**
     * Handler for 'Select file...' button click
     */
    ,onButtonClick: function(){
        this.UploadField.click()
    }


    /**
     * Handler for File selected -> trigger upload
     */
    ,onFileSelected: function(){
        this.UploadForm.form.baseParams.file = this.UploadField.getValue()
        this.UploadForm.submit()
    }


    ,onUploadSuccess: function(o){
        this.value = o.result.message;
        this.setValue(o.result.message)
        this.updateDisplay(o.result.message);
        MODx.fireResourceFormChange()
    }


    ,onUploadFailure: function(){
        /***/
    }


    ,onClearButtonClick: function(){
        this.onUploadSuccess({result:{message:''}});
    }



});
Ext.reg('imageplus-combo-easyupload',ImagePlus.combo.EasyUpload);