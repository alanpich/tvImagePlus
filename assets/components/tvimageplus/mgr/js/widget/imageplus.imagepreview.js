ImagePlus.ImagePreview = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        width: 300,
        height: 120,
        unstyled: true,
        margin:0,
        padding:0,
        cls: 'ip-imagepreview',
        text: 'Drop files here or click to upload',
        textCls: 'ip-imagepreview-text'
    })
    ImagePlus.ImagePreview.superclass.constructor.call(this, config);
    this.on('render',this.on_render,this);
    this.addEvents('imageuploaded');
};
Ext.extend(ImagePlus.ImagePreview, Ext.Panel, {


    on_render: function(){
        this.el.setStyle({
            width: this.width+"px",
            height: this.height+"px"
        });

        this.el.addClass(this.cls);

        // Add image preview
        this.img = new Ext.Element(document.createElement('img'));
        this.img.set({
            width: '100%'
        });
        this.el.appendChild(this.img);

        // Add text
        if(this.text){
            this.textEl = new Ext.Element(document.createElement('p'))
            this.textEl.dom.innerHTML = this.text
            this.textEl.addClass(this.textCls);
            this.textEl.setStyle({
                textAlign: 'center',
                width: '150px',
                pointerEvents: 'none'
            })
            this.el.appendChild(this.textEl);
        }


        // Create dropzone
        this.createDropzone();
    },

    /**
     * Width of the component
     *
     * @returns {Number}
     */
    getWidth: function(){
        return this.el.getWidth();
    },

    /**
     * Height of the component
     *
     * @returns {Number}
     */
    getHeight: function(){
        return this.el.getHeight();
    },


    createDropzone: function(){

        this.dropzoneEl = new Ext.Element(document.createElement('div'));
        this.dropzoneEl.setStyle({
            position: 'absolute',
            top: '0px',
            left: '0px',
            width: '100%',
            height: '100%'
        });
        this.el.appendChild(this.dropzoneEl);

        this.devNull = new Ext.Element(document.createElement('div'));
        this.devNull.setStyle({
            display: 'none'
        });
        this.el.appendChild(this.devNull);

        this.dropzone = new Dropzone(this.dropzoneEl.dom,{
            url: ImagePlus.config.connector_url
            ,paramName: 'file'
            ,acceptedFiles: ['.jpg','.png','.gif','.jpeg','.JPG','.PNG','.GIF','.JPEG'].join(',')
            ,maxFiles: 1
            ,headers: this.headers
            ,previewsContainer: this.devNull.dom
            ,uploadMultiple: false
            ,init: function(ths){return function(){
                ths.onDropzoneInit(this);
            }}(this)
        });
    },

    /**
     * Binds events to dropzone uploader
     *
     * @param dropzone {Dropzone}
     */
    onDropzoneInit: function(dropzone){
        this.dropzone = dropzone;
        console.log('dropzone init\'d');

        dropzone.on('addedfile',Ext.createDelegate(function(){
            console.log('added a file');
        },this));
        dropzone.on('sending',Ext.createDelegate(this.onUploadStart,this));
        dropzone.on('success',Ext.createDelegate(this.onUploadDone,this));
        dropzone.on('error',Ext.createDelegate(this.onDropzoneError,this));
        dropzone.on('uploadprogress',Ext.createDelegate(this.onUploadProgress,this));
    },

    onDropzoneError: function(file,err,xhr){
        console.error(err);
    },

    onUploadProgress: function(file,progress,bytesSent){
        console.log(progress);
    },

    /**
     * Fired when uploading starts
     *
     * @returns void
     */
    onUploadStart: function(file,xhr,formData){
        console.log('upload starting');
        formData.append('action','upload');
        formData.append('uid',this.uid);
        formData.append('HTTP_MODAUTH',MODx.siteId);
        this.showLoadMask("Uploading...");
    },

    /**
     * Fired when uploading is complete
     */
    onUploadDone: function(file,json){
        var response = Ext.util.JSON.decode(json);
        this.hideLoadMask();
        console.log(response);

        if(response.success === false){
            MODx.msg.alert("Image+ Error","Failed to upload file :(");
        } else {
            // Upload was successful...
            var img = response.object;
            this.fireEvent('imageuploaded',img);
        }


        console.log(this.dropzone);

        this.dropzone.removeAllFiles(true);
        this.dropzone.disable();
        this.dropzone.enable();

    },


    showLoadMask: function(msg){
        if(this.loadMask)
            this.loadMask.destroy();

        this.loadMask = new Ext.LoadMask(this.el,{
            msg: msg
        });
        this.loadMask.show();
    },

    hideLoadMask: function(){
        this.loadMask.hide();
        this.loadMask.destroy();
    },

    /**
     * Pass the Image object to show in preview
     *
     * @param img {Image}
     * @returns void
     */
    setImage: function(img){
        this.img.set({
            src: img.src
        });
        var ratio = img.width / img.height;
        this.el.setHeight( (this.getWidth() / ratio) + 4 );
        this.el.addClass('has-image');
    },


    /**
     * Clear the preview image
     *
     * @returns void
     */
    clearImage: function(){
        this.img.set({
            src: ImagePlus.config.mgr_url+'css/spacer.gif'
        });
        this.el.setHeight(this.height);
        this.el.removeClass('has-image');
    }
});
Ext.reg('imageplus-imagepreview', ImagePlus.ImagePreview);