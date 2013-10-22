ImagePlus.panel.ImageControls = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        border: false
        ,defaults: {
            xtype: 'imageplus-iconbutton'
            ,style: {
                marginBottom: '5px'
                ,display:'block'
            }
        }
        ,items: [{
            icon: 'icon-upload-alt'
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('upload')
                },scope:this}
            }
        },{
            icon: 'icon-folder-open-alt'
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('browse')
                },scope:this}
            }
        },{
            icon: 'icon-crop'
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('crop')
                },scope:this}
            }
        },{
            icon: 'icon-remove'
            ,hoverColor: '#c00'
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('clear')
                },scope:this}
            }
        }]

    })
    ImagePlus.panel.ImageControls.superclass.constructor.call(this, config);
    this.addEvents('upload','browse','crop','clear');
};
Ext.extend(ImagePlus.panel.ImageControls, Ext.Panel);
Ext.reg('imageplus-panel-imagecontrols', ImagePlus.panel.ImageControls);