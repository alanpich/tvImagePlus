ImagePlus.panel.TVInput = function(config) {
    config = config || {};

    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,layout: 'column'
        ,width: 380
        ,unstyled: true
        ,items: [{
            xtype: 'modx-panel-dropzone'
            ,url: ImagePlus.config.connector_url
            ,params: {
                action: 'image/upload'
            }
            ,width: 310
            ,padding:0
            ,margin: 0
            ,unstyled: true
        }]

    });
    ImagePlus.panel.TVInput.superclass.constructor.call(this,config);
};
Ext.extend(ImagePlus.panel.TVInput,MODx.Panel,{

});
Ext.reg('imageplus-panel-tvinput',ImagePlus.panel.TVInput);