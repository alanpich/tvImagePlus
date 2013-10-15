ImagePlus.window.RegenerateCache = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        modal: true,
        closeAction: 'destroy',
        closable: true,
        resizable: false,
        collapsible: false,
        maximizable: false,
        allowDrop: false,
        title: _('tvimageplus.regenerate_cache'),
        buttons: [],
        items: [{
            html: '<p>Clicking the button below will regenerate all Image+ images in one request. This can be a lot of strain for a server, and caution is advised.</p>'
                 +'<p>Future releases will include an ajax regenerator that will help to throttle the load on the server</p>',
            border:false,
            padding:10
        },{
            xtype: 'button',
            scope: this,
            handler: this.simpleRegenerate,
            text: _('tvimageplus.regenerate_cache_simple_button')
        }]
    });
    ImagePlus.window.RegenerateCache.superclass.constructor.call(this,config);

};
Ext.extend(ImagePlus.window.RegenerateCache,MODx.Window,{

    simpleRegenerate: function(){

        this.loadMask = new Ext.LoadMask(this.el,{
            msg: _('tvimageplus.regenerating_cache'),
            removeMask: true
        });
        this.loadMask.show();

        MODx.Ajax.request({
            url: ImagePlus.config.connector_url,
            params: {
                action: 'regenerate'
            },
            listeners: {
                success: {fn: this.onRegenerationComplete,scope:this}
            }
        })

    },


    onRegenerationComplete: function(){
        this.loadMask.hide();
        this.destroy();
        MODx.Msg.alert('Regeneration complete','Image+ Cache regenerated successfully');
    }
   
});
Ext.reg('imageplus-window-regeneratecache',ImagePlus.window.RegenerateCache);