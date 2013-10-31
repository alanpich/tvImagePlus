<div id="imageplus-wrapper-{$tv->id}"></div>
<div id="imageplus-tmp-value-{$tv-id}">{$tv->value}</div>
{literal}
<script>
MODx.load({
    xtype: 'imageplus-panel-tvinput',
    tvElId:  {/literal}'tv{$tv->id}'{literal},
    tvId: {/literal}{$tv->id}{literal},
    renderTo: {/literal}'imageplus-wrapper-{$tv->id}'{literal},
    image: {/literal}{$imageJSON}{literal},

    tv: {/literal}{$tvJSON}{literal},
    params: {/literal}{$paramsJSON}{literal},
    onDirtyForm: function(){
        console.warn('Wtf is onDirtyForm?');
    }

})
</script>
{/literal}
