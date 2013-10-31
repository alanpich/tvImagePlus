ImagePlus.panel.ImageControls = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        border: false
        ,items: this.createButtons()

    })
    ImagePlus.panel.ImageControls.superclass.constructor.call(this, config);
    this.addEvents('upload','browse','crop','clear');
};
Ext.extend(ImagePlus.panel.ImageControls, Ext.Panel,{

    /**
     * Create the buttons manually so we
     * can save references to them for later use.
     *
     * @return Array
     */
    createButtons: function(){


        this.uploadButton = MODx.load({
            xtype: 'imageplus-iconbutton',
            icon: 'icon-upload-alt',
            style: {
                marginBottom: '5px',
                display:'block'
            }
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('upload')
                },scope:this}
            }
        });

        this.browseButton = MODx.load({
            xtype: 'imageplus-iconbutton',
            icon: 'icon-folder-open-alt',
            style: {
                marginBottom: '5px',
                display:'block'
            }
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('browse')
                },scope:this}
            }
        });


        this.cropButton = MODx.load({
            xtype: 'imageplus-iconbutton',
            icon: 'icon-crop',
            style: {
                marginBottom: '5px',
                display:'block'
            }
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('crop')
                },scope:this}
            }
        });

        this.clearButton = MODx.load({
            xtype: 'imageplus-iconbutton',
            icon: 'icon-remove',
            style: {
                marginBottom: '5px',
                display:'block'
            }
            ,listeners: {
                click: {fn: function(){
                    this.fireEvent('clear')
                },scope:this}
            }
        });

        return [
            this.uploadButton,
            this.browseButton,
            this.cropButton,
            this.clearButton
        ];
    }

});
Ext.reg('imageplus-panel-imagecontrols', ImagePlus.panel.ImageControls);