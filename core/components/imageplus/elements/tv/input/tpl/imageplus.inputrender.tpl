<textarea class="imageplus-hidden-textarea" name="tv{$tv->id}" id="tv{$tv->id}" value=""/>{$tv->value}</textarea>
<div id="imageplus-panel-input-div-{$tv->id}" class="imageplus-panel-input"></div>
<script type="text/javascript">{literal}
    Ext.onReady(function () {
        MODx.load({{/literal}
            xtype: 'imageplus-panel-input',
            renderTo: 'imageplus-panel-input-div-{$tv->id}',
            imageplus: {$imageplusconfig},
            hiddenField: 'tv{$tv->id}',{literal}
        });
    });{/literal}
    $.merge(ImagePlus.config, {$config});
</script>
