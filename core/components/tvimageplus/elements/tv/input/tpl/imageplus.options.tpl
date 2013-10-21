<div id="tv-input-properties-form{$tv}"></div>
<script type="text/javascript">
    // <![CDATA[
    var tvip_lex = {$tvimagepluslexicon};
    {literal}
    for(i in tvip_lex){ MODx.lang[i] = tvip_lex[i];};

    var params = {
        {/literal}{foreach from=$params key=k item=v name='p'}
        '{$k}': '{$v|escape:"javascript"}'{if NOT $smarty.foreach.p.last},{/if}
        {/foreach}{literal}
    };
    var oc = {'change':{fn:function(){Ext.getCmp('modx-panel-tv').markDirty();},scope:this}};
    MODx.load({
        xtype: 'panel'
        ,layout: 'form'
        ,autoHeight: true
        ,cls: 'form-with-labels'
        ,border: false
        ,labelAlign: 'top'
        ,hideLabels: false
        ,items: [{
            xtype: 'textfield',
            fieldLabel: _('tvimageplus.targetwidth'),
            name: 'inopt_targetWidth',
            id: 'inopt_targetWidth{/literal}{$tv}{literal}',
            value: params['targetWidth'] || '',
            anchors: '98%',
            listeners: oc,
            width: 300
        },{
            xtype: MODx.expandHelp ? 'label' : 'hidden'
            ,forId: 'inopt_targetWidth{/literal}{$tv}{literal}'
            ,html: _('tvimageplus.targetwidth_desc')
            ,cls: 'desc-under'
        },{
            xtype: 'textfield',
            fieldLabel: _('tvimageplus.targetheight'),
            name: 'inopt_targetHeight',
            id: 'inopt_targetHeight{/literal}{$tv}{literal}',
            value: params['targetHeight'] || '',
            anchors: '98%',
            listeners: oc,
            width: 300
        },{
            xtype: MODx.expandHelp ? 'label' : 'hidden'
            ,forId: 'inopt_targetHeight{/literal}{$tv}{literal}'
            ,html: _('tvimageplus.targetheight_desc')
            ,cls: 'desc-under'
        },{
            xtype: 'combo-boolean',
            fieldLabel: _('tvimageplus.allowAltTag'),
            name: 'inopt_allowAltTag',
            id: 'inopt_allowAltTag{/literal}{$tv}{literal}',
            value: (params['allowAltTag'] || false),
            labelAlign: 'left',
            anchors: '98%',
            listeners: oc,
            width: 300
        },{
            xtype: MODx.expandHelp ? 'label' : 'hidden'
            ,forId: 'inopt_allowAltTag{/literal}{$tv}{literal}'
            ,html: _('tvimageplus.allowAltTag_desc')
            ,cls: 'desc-under'

        },{
            // Required Field Flag
            //  sets $allowBlank
            xtype: 'combo-boolean',
            fieldLabel: _('required'),
            name: 'inopt_allowBlank',
            id: 'inopt_allowBlank{/literal}{$tv}{literal}',
            value: (params['allowBlank'] || false),
            labelAlign: 'left',
            anchors: '98%',
            listeners: oc,
            width: 300
        },{
            xtype: MODx.expandHelp ? 'label' : 'hidden'
            ,forId: 'inopt_allowBlank{/literal}{$tv}{literal}'
            ,html: 'Force the user to select an image before saving a resource'
            ,cls: 'desc-under'
        },{
            xtype: 'modx-combo',
            fieldLabel: _('tvimageplus.image_selector'),
            name: 'inopt_imageSelector',
            hiddenName: 'inopt_imageSelector',
            id: 'inopt_imageSelector{/literal}{$tv}{literal}',
            value: (params['imageSelector'] || 'imageplus-combo-browser'),
            labelAlign: 'left',
            anchors: '98%',
            listeners: oc,
            editable: false,
            mode: 'local',
            allowBlank: false,
//            forceSelection: true,
//            autoSelect: true,
            store: new Ext.data.ArrayStore({
                id:{/literal}'tv-{$tv}'{literal},
                fields: ['value','name'],
                idIndex: 0,
                data: [
                    ['imageplus-combo-browser', _('tvimageplus.image-selector.browser')],
                    ['imageplus-combo-easyupload', _('tvimageplus.image-selector.easyupload')]
                ]
            }),
            valueField: 'value',
            displayField: 'name',
            width: 300
        },{
            xtype: MODx.expandHelp ? 'label' : 'hidden'
            ,forId: 'inopt_allowAltTag{/literal}{$tv}{literal}'
            ,html: _('tvimageplus.image_selector_desc')
            ,cls: 'desc-under'
        }]
        ,renderTo: 'tv-input-properties-form{/literal}{$tv}{literal}'
    });
    // ]]>
</script>
{/literal}