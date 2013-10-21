Dropzone.autoDiscover = false;
MODx.panel.Dropzone = function(config) {
    config = config || {};

    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        /**
         * Url to upload file to
         * @var {String}
         */
        ,url: MODx.config.connector_url
        /**
         * Additional parameters to send with upload
         * @var {Object}
         */
        ,params: config.params || {}
        /**
         * Method to use for upload
         * @var {String} POST|PUT
         */
        ,method: config.method || 'POST'
        /**
         * Name of parameter to upload files as
         * @var {String}
         */
        ,fileParam: config.fileParam || 'file'
        /**
         * Maximum file size in MB
         * @var {Number}
         */
        ,maxFileSize: config.maxFileSize || 3 //MB
        /**
         * Allow multiple files
         * @var {Boolean}
         */
        ,uploadMultiple: config.uploadMultiple || false
        /**
         * Additional headers to send with upload
         * @var {Object}
         */
        ,headers: config.headers || {}
        /**
         * Add a link to every file preview to remove or cancel
         * @var {Boolean}
         */
        ,addRemoveLinks: config.addRemoveLinks ||  true
        /**
         * Make the dropzone clickable (to select a file)
         * @var {Boolean}
         */
        ,clickable:config.clickable ||  true
        /**
         * Maximum number of files to allow. If exceeded, maxfilesexceeded
         * event will be fired
         * @var {Number|null}
         */
        ,maxFiles: null
        /**
         * Acceptable file types for upload
         * @example ['image/*','application/pdf','.psd']
         * @var {Array}
         */
        ,acceptedFiles: []
        /**
         * Automatically start upload when a file is selected
         * @var {Boolean}
         */
        ,autoUpload: true

        ,msg: {
            default: 'Drop files here to upload'
        }

        ,items: [{
            html: this.getRenderHTML()
            ,border: false
        }]
    });
    MODx.panel.Dropzone.superclass.constructor.call(this,config);

    this.addEvents('dropzone-init','fileadded','uploadstarted','uploadprogress','uploadcomplete','uploadcancelled');

    this.on('render',this.onAfterRender,this);
    this.on('dropzone-init',this.onDropzoneInit,this);
};
Ext.extend(MODx.panel.Dropzone,MODx.Panel,{


    getRenderHTML: function(){
        this.divId = Ext.id();
        return '<table><tbody><tr>' +
            '<td>' +
            '<div id="'+this.divId+'" class="modx-dropzone">' +
            '<span class="message" style="pointer-events:none;">' +
            '   Drop file here or click to upload' +
            '</span>' +
            '</div>' +
            '</td><td valign="top" style="padding-top: 10px">' +
            '<button class="btn">U</button>' +
            '<button class="btn">E</button>' +
            '<button class="btn">C</button>' +
            '</td>' +
            '</tr></tbody></table>'
    },

    /**
     * Set up the jQuery elements and bind events
     *
     * @returns void
     */
    onAfterRender: function(){
        if(!Ext.isReady){
            Ext.onReady(this.init,this)
        } else {
            this.init();
        }
    },

    /**
     * Initialize the DOM elements
     *
     * @returns void
     */
    init: function(){
        // Create the wrapper div
        this.div = document.getElementById(this.divId);
        this.div.className = 'modx-panel-dropzone';
        this.createDropzone();
    },

    /**
     * Create & configure a Dropzone
     *
     * @returns void
     */
    createDropzone: function(){
        this.dropzone = new Dropzone(this.div,{
             url: ImagePlus.config.connector_url
            ,paramName: this.fileParam
            ,dictDefaultMessage: this.msg.default
            ,acceptedFiles: this.acceptedFiles.join(',')
            ,maxFiles: this.maxFiles
            ,headers: this.headers
            ,uploadMultiple: this.uploadMultiple
            ,paramName: this.fileParam
            ,maxFilesize: this.maxFilesize
            ,method: this.method.toLowerCase()
//            ,init: Ext.createDelegate(this.fireEvent,this,['dropzone-init'])
            ,init: function(ths){return function(){
                ths.onDropzoneInit(this);
            }}(this)
        });
    },

    /**
     * Called when the Dropzone initializes. Binds
     * other event handlers
     *
     * @returns void
     */
    onDropzoneInit: function(dropzone){
        dropzone.on('addedfile',Ext.createDelegate(function(file){
                this.onFileAdded(file);
                this.fireEvent('fileadded',file);
            },this));

        dropzone.on('uploadprogress',Ext.createDelegate(function(file,progress,bytesSent){
                this.onUploadProgress(file,progress,bytesSent);
                this.fireEvent('uploadprogress',file,progress,bytesSent);
            },this));

        dropzone.on('sending',Ext.createDelegate(function(file,xhrObject,formData){
            this.onUploadStarting(file,xhrObject,formData);
            this.fireEvent('uploadstarting',file,xhrObject,formData);
        },this));

        dropzone.on('complete',Ext.createDelegate(function(file){
            this.onUploadComplete(file);
            this.fireEvent('uploadcomplete',file);
        },this));
    },


    /**
     * Called when a file is added
     *
     * @param file
     * @returns void
     */
    onFileAdded: function(file){
    },

    /**
     * Called when upload progress is updated
     *
     * @param file {File} The file being uploaded
     * @param progress {Number} Percentage completion of upload
     * @param bytesSent {Number} Total bytes uploaded
     * @returns void
     */
    onUploadProgress: function(file,progress,bytesSent){
        console.log("%s%",progress);
    },

    /**
     * Fires when a file upload starts
     *
     * @param file {File}
     * @param xhrObject {XMLHttpRequest}
     * @param formData {FormData}
     * @returns void
     */
    onUploadStarting: function(file,xhrObject,formData){
        console.log(this);
        formData.append('HTTP_MODAUTH',MODx.siteId);
       for(key in this.params){
           formData.append(key,this.params[key]);
       }
    },

    /**
     * Fires when a file upload is complete
     *
     * @param file {File}
     * @returns void
     */
    onUploadComplete: function(file,response){
        console.log('Upload finished',response);
        this.dropzone.removeAllFiles();
    }

});
Ext.reg('modx-panel-dropzone',MODx.panel.Dropzone);