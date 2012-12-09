<div id="tv-output-properties-form{$tv}"></div>
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
    ,items: [{
            xtype: 'textfield',
            fieldLabel: _('tvimageplus.phpThumbParams'),
            name: 'prop_phpThumbParams',
            id: 'prop_phpThumbParams{/literal}{$tv}{literal}',
            value: params['phpThumbParams'] || '',
            width: '99%',
            listeners: oc
 	},{
            xtype: MODx.expandHelp ? 'label' : 'hidden'
            ,forId: 'prop_phpThumbParams{/literal}{$tv}{literal}'
            ,html: _('tvimageplus.phpThumbParams_desc')
            ,cls: 'desc-under'
    }]
    ,renderTo: 'tv-output-properties-form{/literal}{$tv}{literal}'
});
// ]]>
</script>
{/literal}
