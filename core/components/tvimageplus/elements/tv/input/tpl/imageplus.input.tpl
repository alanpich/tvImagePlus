<input id="tv{$tv->id}" name="tv{$tv->id}" value="{$tvData->value}" />
<div id="imageplus-wrapper-{$tv->id}"></div>
{literal}
<script>
MODx.load({
    xtype: 'imageplus-panel-tvinput',
    tvElId:  {/literal}'tv{$tv->id}'{literal},
    tv: {/literal}{$tv->value}{literal},
    renderTo: {/literal}'imageplus-wrapper-{$tv->id}'{literal},
    image: {/literal}{$imageJSON}{literal}
})
</script>
{/literal}