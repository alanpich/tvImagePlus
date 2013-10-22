ImagePlus.combo.OutputType = function (config) {
    config = config || {};

    /**
     * Config defaults
     */
    Ext.apply(config, {
        fieldLabel: _('tvimageplus.output_type'),
        editable: false,
        mode: 'local',
        allowBlank: false,
        forceSelection: true,
        autoSelect: true,
        store: new Ext.data.ArrayStore({
            fields: [
                'key',
                'name'
            ],
            data: [
                ['url', _('tvimageplus.output_render.url')],
                ['chunk', _('tvimageplus.output_render.chunk')],
                ['snippet', _('tvimageplus.output_render.snippet')],
                ['datauri', _('tvimageplus.output_render.datauri')]
            ]
        }),
        valueField: 'key',
        displayField: 'name'
    });
    ImagePlus.combo.OutputType.superclass.constructor.call(this, config);
};
Ext.extend(ImagePlus.combo.OutputType, MODx.combo.ComboBox);
Ext.reg('imageplus-combo-outputtype', ImagePlus.combo.OutputType);