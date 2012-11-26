<textarea type="text" name="tv{$tv->id}" style="width:500px; height:200px;" id="tv{$tv->id}" value="{$tv->value}">{$tv->value}</textarea>
<div class="tvimageplus-inputform" id="tvimageplus{$tv->id}" style="width:400px;"></div>
<div id="tvimageplus-panel-input-div"></div>
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
