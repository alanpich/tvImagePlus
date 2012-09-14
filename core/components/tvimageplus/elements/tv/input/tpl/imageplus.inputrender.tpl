<input type="hidden" name="tv{$tv->id}" id="tv{$tv->id}" value="{$tv->value}" />
<div class="tvimageplus-inputform" id="tvimageplus{$tv->id}" style="width:400px;"></div>
<script type="text/javascript">
// Start up the ImagePlus TV type
IP{$tv->id} = new ImagePlus({$tv->id},{literal} { {/literal}
	wrapperID: 'tvimageplus{$tv->id}', 

	params: {literal}{
		{/literal}
		{foreach from=$params key=k item=v name='p'}
		 '{$k}': '{$v|escape:"javascript"}'{if NOT $smarty.foreach.p.last},{/if}
		{/foreach}
		{literal}	
	}, {/literal}
	mediaSource: {$mediasource},
	data: {$imgData}
{literal} } {/literal});

Ext.onReady(function() {literal}{{/literal}
IP{$tv->id}.init();

{literal}
});
{/literal}



</script>
