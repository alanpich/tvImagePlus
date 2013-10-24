ImagePlus.ImagePreview = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        width: 300,
        height: 120,
        unstyled: true,
        margin:0,
        padding:0,
        fileParam: 'file',
        cls: '',
        text: 'Drop files here or click to upload',
        textCls: 'ip-imagepreview-text'
    })
    ImagePlus.ImagePreview.superclass.constructor.call(this, config);
    this.on('render',this.on_render,this);
    this.addEvents('imageuploaded');
};
Ext.extend(ImagePlus.ImagePreview, Ext.Panel, {


    on_render: function(){

        // Set up the main panel element
        this.el.setStyle({
            width: this.width+"px",
            height: this.height+"px",
            position: 'relative'
        });
        this.el.addClass('ip-imagepreview '+this.cls);

        this.$el = $(this.el.dom);


//        // Add image preview
//        this.img = new Ext.Element(document.createElement('img'));
//        this.img.set({
//            width: '100%'
//        });
//        this.el.appendChild(this.img);

        // Add text
//        if(this.text){
//            this.textEl = new Ext.Element(document.createElement('p'))
//            this.textEl.dom.innerHTML = this.text
//            this.textEl.addClass(this.textCls);
//            this.textEl.setStyle({
//                textAlign: 'center',
//                width: '150px',
//                pointerEvents: 'none'
//            })
//            this.el.appendChild(this.textEl);
//        }
//
//
//        // Set up droppable files (if supported)
//        this.$el.find('.x-plain-body').fileapi({
//            url: ImagePlus.config.connector_url,
//            autoUpload: true,
//            accept: 'image/*',
//            multiple: false,
//            data: {
//                action: 'upload',
//                siteId: MODx.siteId
//            },
//            paramName: this.fileParam,
//            maxFiles: 1,
//            dnd: {
//                // DropZone: selector or element
//                el: this.$el,
//                // Hover class
//                hover: 'dnd_hover'
//            }
//        })

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


    /**
     * Initialize the dropzone if the browser
     * supports it
     *
     * @returns void
     */
    initFileDrop: function(){
        if (FileAPI.support.dnd) {
            this.$el.dnd(function (over) {
                console.log(this);
            }, function (files) {
                console.log('dropFiles:', files);
                onFiles(files);
            });
        }

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