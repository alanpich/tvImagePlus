<div id="tv-input-properties-form{$tv}"></div>

{literal}

<script type="text/javascript">
// <![CDATA[
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
 		fieldLabel: 'Target width',							// _('tvimageplus.targetwidth'),
 		name: 'inopt_targetWidth',
 		id: 'inopt_targetWidth{/literal}{$tv}{literal}',
 		value: params['targetWidth'] || '',
 		anchors: '98%',
 		listeners: oc
 	},{
        xtype: MODx.expandHelp ? 'label' : 'hidden'
        ,forId: 'inopt_targetWidth{/literal}{$tv}{literal}'
        ,html: 'The target width for the output image'		// _('tvimageplu.targetwidth_desc')
        ,cls: 'desc-under'
    },{
 		xtype: 'textfield',
 		fieldLabel: 'Target height',							// _('tvimageplus.targetheight'),
 		name: 'inopt_targetHeight',
 		id: 'inopt_targetHeight{/literal}{$tv}{literal}',
 		value: params['targetHeight'] || '',
 		anchors: '98%',
 		listeners: oc
 	},{
        xtype: MODx.expandHelp ? 'label' : 'hidden'
        ,forId: 'inopt_targetHeight{/literal}{$tv}{literal}'
        ,html: 'The target height for the output image'		// _('tvimageplu.targetheight_desc')
        ,cls: 'desc-under'
    }]
 	,renderTo: 'tv-input-properties-form{/literal}{$tv}{literal}'
});
// ]]>
</script>
{/literal}
