ImagePlus.panel.PreviewImage = function(config) {
    config = config || {};
    /**
     * Config defaults
     */
    Ext.apply(config,{
        border: false
        ,id: 'imageplus-panel-previewimage'
        ,listeners: {
            afterrender: {fn:this.onAfterRender,scope:this}
        }
    });
    ImagePlus.panel.PreviewImage.superclass.constructor.call(this,config);
    
};
Ext.extend(ImagePlus.panel.PreviewImage,Ext.Panel,{

    onAfterRender: function(){
        this.img = document.createElement('img');
        this.img.className = 'imageplus-previewimage';
        this.body.appendChild(this.img);


    },

    setSrc: function(src){

        this.img.src = src
    }

});
Ext.reg('imageplus-panel-previewimage',ImagePlus.panel.PreviewImage);