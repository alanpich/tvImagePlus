<input type="hidden" name="tv{$tv->id}" id="tv{$tv->id}" value="{$tv->value}" />
<div id="tvimageplus-panel-input-div" style="width:420px"></div>
<script type="text/javascript">
{literal}
Ext.onReady(function(){ 
    MODx.load({   {/literal}
            xtype: 'tvimageplus-panel-input'
            ,renderTo: 'tvimageplus-panel-input-div'
            ,tvimageplus: {$tvimageplusconfig}
            ,updateTo: 'tv{$tv->id}'  {literal}
        });
 });
{/literal}
</script>
