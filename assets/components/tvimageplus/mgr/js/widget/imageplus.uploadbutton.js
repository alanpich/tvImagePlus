window.FileAPI = {
    debug: true
}

ImagePlus.UploadButton = function(config){
    config = config || {};
    Ext.applyIf(config,{
        autoEl: 'a'
        ,icon: false
        ,size: 16
        ,color: '#aaa'
        ,hoverColor: '#111'
        ,style: {}
        ,fileParam: 'file'
        ,url: ImagePlus.config.connector_url
    });
    ImagePlus.UploadButton.superclass.constructor.call(this,config);

    this.addEvents('click','mouseover','mouseout');
    this.on('render',this.on_render,this);

};
Ext.extend(ImagePlus.UploadButton,Ext.Component,{


    /**
     * Do the main rendering thingy
     */
    on_render: function(){

        this.el.addClass('imageplus-ui-button');
        this.el.setStyle({
            cursor: 'pointer',
            width: (this.size+2)+"px"
        });


        // Create FontAwesome icon element
        this.iconEl = new Ext.Element(document.createElement('i'));
        this.iconEl.addClass(this.icon);
        this.el.appendChild(this.iconEl);




        // Create input element
        this.inputEl = new Ext.Element(document.createElement('input'));
        this.inputEl.set({
            type: 'file'
            ,name: this.fileParam
        })
        this.inputEl.setStyle({
            position: 'absolute',
            top: '0px',
            right: '0px',
            fontSize: this.size+"px",
            cursor: 'pointer'
        })
        this.el.appendChild(this.inputEl);


        this.bindFileApiEvents();

    },


    /**
     *
     */
    bindFileApiEvents: function(){
        var input = this.inputEl.dom;

        this.inputEl.on('change',function(e){
            var files = FileAPI.getFiles(e);
            this.upload(files);
            FileAPI.reset(e.target);
        },this)

    },

    /**
     *
     */
    onFileSelected: function(evt){
        var files = FileAPI.getFiles(evt.target)


        this.upload(files);
    },


    upload: function(files){

        console.log(this.url);
        // filtering
        console.log('uploading...');
        FileAPI.filterFiles(files, function (file, info){
            if( /image/.test(file.type) && info ){
                return  info.width >= 10 && info.height >= 10;
            }
            else {
                return  file.size > 128;
            }
        }, function (fileList, ignor){
            if( ignor.length ){
                console.log('ignore files ',ignor)
            }

            if( !fileList.length ){
                // empty file list
                console.log('NO FILES, give up');
                return;
            }

            console.log(fileList);


            // do preview
       //     var imageList = FileAPI.filter(fileList, function (file){ return /image/.test(file.type); });


            // upload on server
            var xhr = FileAPI.upload({
                url: this.url,
                data: {
                    action: 'upload',
                    siteId: MODx.siteId
                }, // POST-data (iframe, flash, html5)
                headers: { 'x-header': '...' }, // request headers (html5)
                files: {
                    file: fileList//FileAPI.filter(fileList, function (file){ return !/image/.test(file.type); })
                },
                imageTransform: {
                    maxWidth:  1024,
                    maxHeight: 768
                },
                imageAutoOrientation: true,
                fileprogress: function(){console.log(arguments)},//Ext.createDelegate(this.onUploadProgress,this),
                progress: function(){console.log(arguments)},
                complete: function(){console.log(arguments)}
            });
            console.log('sent');
        })
    },


    onUploadProgress: function(evt){
        console.log("progress ",evt);
    },

    onUploadComplete: function(evt){
        console.log('complete ',evt);
    },


});
Ext.reg('imageplus-uploadbutton',ImagePlus.UploadButton);
