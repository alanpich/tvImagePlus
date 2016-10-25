<div id="tv-output-properties-form{$tv}"></div>
<script type="text/javascript">
    // <![CDATA[
    {literal}
    var params = {
        {/literal}{foreach from=$params key=k item=v name='p'}
        '{$k}': '{$v|escape:"javascript"}'{if NOT $smarty.foreach.p.last}, {/if}
        {/foreach}{literal}
    };
    var oc = {
        'change': {
            fn: function () {
                Ext.getCmp('modx-panel-tv').markDirty();
            }, scope: this
        }
    };
    MODx.load({
        xtype: 'panel',
        layout: 'form',
        autoHeight: true,
        cls: 'form-with-labels',
        border: false,
        labelAlign: 'top',
        items: [{
            xtype: 'textfield',
            fieldLabel: _('imageplus.phpThumbParams'),
            description: MODx.expandHelp ? '' : _('imageplus.phpThumbParams_desc'),
            name: 'prop_phpThumbParams',
            id: 'prop_phpThumbParams{/literal}{$tv}{literal}',
            value: params['phpThumbParams'] || '',
            anchor: '100%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'prop_phpThumbParams{/literal}{$tv}{literal}',
            html: _('imageplus.phpThumbParams_desc'),
            cls: 'desc-under'
        }, {
            xtype: 'modx-combo',
            url: MODx.config.connectors_url + 'index.php',
            baseParams: {
                action: 'element/chunk/getlist'
            },
            pageSize: 20,
            fields: ['name', 'id'],
            displayField: 'name',
            valueField: 'name',
            typeAhead: true,
            editable: true,
            fieldLabel: _('imageplus.outputChunk'),
            description: MODx.expandHelp ? '' : _('imageplus.outputChunk_desc'),
            name: 'prop_outputChunk',
            id: 'prop_outputChunk{/literal}{$tv}{literal}',
            value: params['outputChunk'] || '',
            anchor: '100%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'prop_outputChunk{/literal}{$tv}{literal}',
            html: _('imageplus.outputChunk_desc'),
            cls: 'desc-under'
        }, {
            xtype: 'combo-boolean',
            fieldLabel: _('imageplus.generateUrl'),
            description: MODx.expandHelp ? '' : _('imageplus.generateUrl_desc'),
            name: 'prop_generateUrl',
            hiddenName: 'prop_generateUrl',
            id: 'prop_generateUrl{/literal}{$tv}{literal}',
            value: (params['generateUrl'] == 1 || params['generateUrl'] == 'true'),
            anchor: '100%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'prop_generateUrl{/literal}{$tv}{literal}',
            html: _('imageplus.generateUrl_desc'),
            cls: 'desc-under'
        }],
        renderTo: 'tv-output-properties-form{/literal}{$tv}{literal}'
    });
    // ]]>
</script>
{/literal}
