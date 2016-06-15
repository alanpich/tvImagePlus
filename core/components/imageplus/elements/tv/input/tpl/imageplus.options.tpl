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
            fieldLabel: _('imageplus.targetwidth'),
            name: 'inopt_targetWidth',
            id: 'inopt_targetWidth{/literal}{$tv}{literal}',
            value: params['targetWidth'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_targetWidth{/literal}{$tv}{literal}',
            html: _('imageplus.targetwidth_desc'),
            cls: 'desc-under'
        }, {
            xtype: 'textfield',
            fieldLabel: _('imageplus.targetheight'),
            name: 'inopt_targetHeight',
            id: 'inopt_targetHeight{/literal}{$tv}{literal}',
            value: params['targetHeight'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_targetHeight{/literal}{$tv}{literal}',
            html: _('imageplus.targetheight_desc'),
            cls: 'desc-under'
        }, {
            xtype: 'textfield',
            fieldLabel: _('imageplus.targetRatio'),
            name: 'inopt_targetRatio',
            id: 'inopt_targetRatio{/literal}{$tv}{literal}',
            value: params['targetRatio'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_targetRatio{/literal}{$tv}{literal}',
            html: _('imageplus.targetRatio_desc'),
            cls: 'desc-under'
        }, {
            xtype: 'textfield',
            fieldLabel: _('imageplus.thumbnailWidth'),
            name: 'inopt_thumbnailWidth',
            id: 'inopt_thumbnailWidth{/literal}{$tv}{literal}',
            value: params['thumbnailWidth'] || '',
            anchors: '98%',
            width: '99%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_thumbnailWidth{/literal}{$tv}{literal}',
            html: _('imageplus.thumbnailWidth_desc'),
            cls: 'desc-under'
        }, {
            xtype: 'combo-boolean',
            fieldLabel: _('imageplus.allowAltTag'),
            name: 'inopt_allowAltTag',
            hiddenName: 'inopt_allowAltTag',
            id: 'inopt_allowAltTag{/literal}{$tv}{literal}',
            value: !(params['allowAltTag'] == 0 || params['allowAltTag'] == 'false'),
            labelAlign: 'left',
            anchors: '98%',
            listeners: oc
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: 'inopt_allowAltTag{/literal}{$tv}{literal}',
            html: _('imageplus.allowAltTag_desc'),
            cls: 'desc-under'
        }],
        renderTo: 'tv-input-properties-form{/literal}{$tv}{literal}'
    });
    // ]]>
</script>
{/literal}
