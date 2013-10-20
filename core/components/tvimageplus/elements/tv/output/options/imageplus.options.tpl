<div id="tv-output-properties-form{$tv}"></div>
<pre></pre>
{$inlineJavascript}
<script type="text/javascript">
    // <![CDATA[
    var tvip_lex = {$tvimagepluslexicon};
{literal}
//    var oc = {'change':{fn:function(){Ext.getCmp('modx-panel-tv').markDirty();},scope:this}};
    for(i in tvip_lex){ MODx.lang[i] = tvip_lex[i];};

    MODx.load({
        xtype: 'imageplus-panel-tvoutputoptions'
        ,renderTo: '{/literal}tv-output-properties-form{$tv}{literal}'
        ,params: {{/literal}{foreach from=$params key=k item=v name='p'}
            '{$k}': '{$v}'{if NOT $smarty.foreach.p.last},{/if}
    {/foreach}{literal}}
    });

{/literal}
</script>
