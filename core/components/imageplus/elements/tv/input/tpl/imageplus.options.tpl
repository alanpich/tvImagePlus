<div id="tv-input-properties-form{$tv}"></div>
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
            fieldLabel: '{/literal}{$imageplus.targetwidth}{literal}',
            name: 'inopt_targetWidth',
            id: 'inopt_targetWidth{/literal}{$tv}{literal}',
            value: params['targetWidth'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_targetWidth{/literal}{$tv}{literal}',
            html: '{/literal}{$imageplus.targetwidth_desc}{literal}',
            cls: 'desc-under'
        }, {
            xtype: 'textfield',
            fieldLabel: '{/literal}{$imageplus.targetheight}{literal}',
            name: 'inopt_targetHeight',
            id: 'inopt_targetHeight{/literal}{$tv}{literal}',
            value: params['targetHeight'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_targetHeight{/literal}{$tv}{literal}',
            html: '{/literal}{$imageplus.targetheight_desc}{literal}',
            cls: 'desc-under'
        }, {
            xtype: 'textfield',
            fieldLabel: '{/literal}{$imageplus.targetRatio}{literal}',
            name: 'inopt_targetRatio',
            id: 'inopt_targetRatio{/literal}{$tv}{literal}',
            value: params['targetRatio'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_targetRatio{/literal}{$tv}{literal}',
            html: '{/literal}{$imageplus.targetRatio_desc}{literal}',
            cls: 'desc-under'
        }, {
            xtype: 'textfield',
            fieldLabel: '{/literal}{$imageplus.thumbnailWidth}{literal}',
            name: 'inopt_thumbnailWidth',
            id: 'inopt_thumbnailWidth{/literal}{$tv}{literal}',
            value: params['thumbnailWidth'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_thumbnailWidth{/literal}{$tv}{literal}',
            html: '{/literal}{$imageplus.thumbnailWidth_desc}{literal}',
            cls: 'desc-under'
        }, {
            xtype: 'combo-boolean',
            fieldLabel: '{/literal}{$imageplus.allowAltTag}{literal}',
            name: 'inopt_allowAltTag',
            hiddenName: 'inopt_allowAltTag',
            id: 'inopt_allowAltTag{/literal}{$tv}{literal}',
            value: (params['allowAltTag'] || false),
            labelAlign: 'left',
            anchors: '98%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_allowAltTag{/literal}{$tv}{literal}',
            html: '{/literal}{$imageplus.allowAltTag_desc}{literal}',
            cls: 'desc-under'
        }],
        renderTo: 'tv-input-properties-form{/literal}{$tv}{literal}'
    });
    // ]]>
</script>
{/literal}
