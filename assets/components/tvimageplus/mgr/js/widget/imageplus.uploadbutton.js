ImagePlus.UploadButton = function(config){
    config = config || {};
    Ext.applyIf(config,{
        autoEl: 'a'
        ,icon: false
        ,size: 16
        ,color: '#aaa'
        ,hoverColor: '#111'
        ,style: {}
    });
    ImagePlus.UploadButton.superclass.constructor.call(this,config);

    this.fileAPIread = false;

    this.on('mouseover',this.setupFileAPI,this);
};
Ext.extend(ImagePlus.UploadButton,ImagePlus.IconButton,{

    /**
     * Do the main rendering thingy
     */
    setupFileAPI: function(){

        if(this.fileAPIready) { return; };

        var $el = $(this.el.dom);

        $el.append('<div class="btn btn-success js-fileapi-wrapper">'+
        '<div class="js-browse">'+
        '<span class="btn-txt">Browse</span>'+
        '<input type="file" class="ip-upload" name="filedata">'+
        '</div>'+
        '<div class="js-upload" style="display: none">'+
        '<div class="progress progress-success">'+
        '<div class="js-progress bar"></div>'+
        '</div>'+
        '<span class="btn-txt">Uploading (<span class="js-size"></span>)</span>'+
        '</div>'+
        '</div>');

        console.log($el.outerHeight());


        console.log($el.fileapi({
            url: ImagePlus.config.connector_url,
            autoUpload: true,
            accept: 'image/*',
            multiple: false,
            maxSize: FileAPI.MB * 10
//            data: {
//                action: 'upload',
//                siteId: MODx.siteId
//            },
//            paramName: this.fileParam,
//            maxFiles: 1
        }))

        this.fileAPIready = true;

    },

    on_click: function(){
     //   this.fireEvent('click');
    }


});
Ext.reg('imageplus-uploadbutton',ImagePlus.UploadButton);
