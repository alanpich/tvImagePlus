ImagePlus.combo.Chunk = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url:MODx.config.connectors_url+'element/chunk'
        ,baseParams: {
            action: 'getlist'
        }
        ,name: 'prop_chunk'
        ,hiddenName: 'prop_chunk'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fieldLabel: _('chunk')
        ,fields: ['name','id']
        ,pageSize: 20
        ,typeAhead: true
        ,editable: true
    });
    ImagePlus.combo.Chunk.superclass.constructor.call(this,config);

};
Ext.extend(ImagePlus.combo.Chunk,MODx.combo.UserGroup);
Ext.reg('imageplus-combo-chunk',ImagePlus.combo.Chunk);