<textarea class="imageplus-hidden-textarea" name="tv{$tv->id}" id="tv{$tv->id}">{$tv->value}</textarea>
<div id="imageplus-panel-input-div-{$tv->id}" class="imageplus-panel-input"></div>
<script type="text/javascript">{literal}
    Ext.onReady(function () {
        MODx.load({{/literal}
            xtype: 'imageplus-panel-input',
            renderTo: 'imageplus-panel-input-div-{$tv->id}',
            options: {$tvConfig},
            hiddenField: 'tv{$tv->id}'{literal}
        });
    });{/literal}
</script>
