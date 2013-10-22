ImagePlus.combo.Snippet = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url:MODx.config.connectors_url+'element/snippet'
        ,baseParams: {
            action: 'getlist'
        }
        ,displayField: 'name'
        ,valueField: 'id'
        ,hideLabel: false
        ,fieldLabel: _('snippet')
        ,fields: ['name','id']
        ,pageSize: 20
        ,typeAhead: true
        ,editable: true
    });
    ImagePlus.combo.Snippet.superclass.constructor.call(this,config);

};
Ext.extend(ImagePlus.combo.Snippet,MODx.combo.UserGroup);
Ext.reg('imageplus-combo-snippet',ImagePlus.combo.Snippet);