<input type="hidden" name="tv{$tv->id}" id="tv{$tv->id}" value="{$tv->value}" />
<div id="imageplus-panel-input-div-{$tv->id}"></div>
<script type="text/javascript">
{literal}
Ext.onReady(function(){ 
    MODx.load({   {/literal}
            xtype: 'imageplus-panel-input'
            ,renderTo: 'imageplus-panel-input-div-{$tv->id}'
            ,imageplus: {$imageplusconfig}
            ,updateTo: 'tv{$tv->id}'  {literal}
        });
 });
{/literal}
$.merge(true,tvImagePlus.config,{$config});
</script>
