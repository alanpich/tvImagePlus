<div id="tv-output-properties-form{$tv}"></div>
<script type="text/javascript">
// <![CDATA[
var tvip_lex = {$imagepluslexicon};
{literal}
for(i in tvip_lex){ MODx.lang[i] = tvip_lex[i];}

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
    ,items: [{
        xtype: 'textfield',
        fieldLabel: _('imageplus.phpThumbParams'),
        name: 'prop_phpThumbParams',
        id: 'prop_phpThumbParams{/literal}{$tv}{literal}',
        value: params['phpThumbParams'] || '',
        width: '99%',
        listeners: oc
 	},{
        xtype: MODx.expandHelp ? 'label' : 'hidden'
        ,forId: 'prop_phpThumbParams{/literal}{$tv}{literal}'
        ,html: _('imageplus.phpThumbParams_desc')
        ,cls: 'desc-under'
    },{
        xtype: 'modx-combo',
        url: MODx.config.connectors_url+'index.php',
        baseParams: {
            action: 'element/chunk/getlist'
        },
        pageSize: 20,
        fields: ['name','id'],
        displayField: 'name',
        valueField: 'name',
        typeAhead: true,
        editable: true,
        fieldLabel: _('imageplus.outputChunk'),
        name: 'prop_outputChunk',
        id: 'prop_outputChunk{/literal}{$tv}{literal}',
        value: params['outputChunk'] || '',
        width: '99%',
        listeners: oc
    },{
        xtype: MODx.expandHelp ? 'label' : 'hidden'
        ,forId: 'prop_outputChunk{/literal}{$tv}{literal}'
        ,html: _('imageplus.outputChunk_desc')
        ,cls: 'desc-under'
    },{
        xtype: 'combo-boolean',
        fieldLabel: _('imageplus.generateUrl'),
        name: 'prop_generateUrl',
        id: 'prop_generateUrl{/literal}{$tv}{literal}',
        value: params['generateUrl'] || 1,
        width: '99%',
        listeners: oc
    },{
        xtype: MODx.expandHelp ? 'label' : 'hidden'
        ,forId: 'prop_generateUrl{/literal}{$tv}{literal}'
        ,html: _('imageplus.generateUrl_desc')
        ,cls: 'desc-under'
    }]
    ,renderTo: 'tv-output-properties-form{/literal}{$tv}{literal}'
});
// ]]>
</script>
{/literal}
