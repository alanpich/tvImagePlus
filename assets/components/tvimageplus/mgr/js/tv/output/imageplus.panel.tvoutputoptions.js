ImagePlus.panel.TVOutputOptions = function(config) {
    config = config || {};

    config.params = config.params || {}

    /**
     * Config defaults
     */
    Ext.apply(config,{
        layout: 'form'
        ,autoHeight: true
        ,cls: 'form-with-labels'
        ,border: false
        ,labelAlign: 'top'
        ,hideLabels: false
        ,listeners: {
            beforerender: {fn: this.renderElements, scope: this }
        }
    });
    ImagePlus.panel.TVOutputOptions.superclass.constructor.call(this,config);
};
Ext.extend(ImagePlus.panel.TVOutputOptions,MODx.Panel,{

    onFieldChange: function(){
        Ext.getCmp('modx-panel-tv').markDirty();
    },

    renderElements: function(){

        this.typeSelectCombo = MODx.load({
            xtype: 'imageplus-combo-outputtype'
            ,id: 'imageplus-tv-options-rendertype'
            ,value: this.params.type || 'url'
            ,name: 'prop_type'
            ,anchor: '98.8%'
            ,listeners: {
                select: {fn: this.onChangeRenderType, scope:this}
            }
        });

        var hr = {
            html: '<hr />'
            ,border: false
        };

        this.add([
                this.typeSelectCombo,
                hr,
                this.getSnippetRenderPanel(),
                this.getChunkRenderPanel()
            ]);

        this.onChangeRenderType(true);
    },


    /**
     * Generate the panel for controlling
     * and describing Snippet output render
     */
    getSnippetRenderPanel: function(){
        if(!this.snippetRenderPanel){
            this.snippetRenderPanel = MODx.load({
                xtype: 'panel',
                layout: 'form',
                anchor: '97%',
                border: false,
                items: [{
                    xtype: 'imageplus-combo-snippet'
                    ,emptyText: _('tvimageplus.select_snippet')
                    ,name: 'prop_snippet'
                    ,hiddenName: 'prop_snippet'
                    ,value: this.params.snippet
                    ,anchor: '86%'
                    ,listeners: {
                        change: {fn:this.onFieldChange,scope:this}
                    }
                },{
                    html: '<p>'+ _('tvimageplus.output_render.snippet.info') + '</p>'
                    ,border: false
                },{
                    html:'<pre><code>' +
                        '&lt;?php\n'+
                        '/**\n'+
                        ' * @param int            $uid       '+_('tvimageplus.placeholder.uid')+'\n'+
                        ' * @param string         $url       '+_('tvimageplus.placeholder.url')+'\n'+
                        ' * @param int            $width     '+_('tvimageplus.placeholder.width')+'\n'+
                        ' * @param int            $height    '+_('tvimageplus.placeholder.height')+'\n'+
                        ' * @param int            $mtime     '+_('tvimageplus.placeholder.mtime')+'\n'+
                        ' * @param string         $original  '+_('tvimageplus.placeholder.original')+'\n'+
                        ' * @param imagePlusImage $image     '+_('tvimageplus.placeholder.image')+'\n'+
                        ' */',
                    border: false
                }]
            })
        }
        return this.snippetRenderPanel;
    },


    /**
     * Generate the panel for controlling
     * and describing Chunk output render
     */
    getChunkRenderPanel: function(){
        if(!this.chunkRenderPanel){
            this.chunkRenderPanel = MODx.load({
                xtype: 'panel',
                layout: 'form',
                anchor: '97%',
                border: false,
                items: [{
                    xtype: 'imageplus-combo-chunk'
                    ,emptyText: _('tvimageplus.select_chunk')
                    ,name: 'prop_chunk'
                    ,hiddenName: 'prop_chunk'
                    ,value: this.params.chunk
                    ,anchor: '99%'
                    ,listeners: {
                        change: {fn:this.onFieldChange,scope:this}
                    }
                },{
                    html: '<p>'+ _('tvimageplus.output_render.chunk.info') + '</p>'
                    ,border: false
                },{
                    html:'<table>' +
                        '<tbody>' +
                        '<tr><td><pre><code>[[+uid]]</code></pre></td><td><pre><code>'+_('tvimageplus.placeholder.uid')+'</code></pre></td></tr>' +
                        '<tr><td><pre><code>[[+url]]</code></pre></td><td><pre><code>'+_('tvimageplus.placeholder.url')+'</code></pre></td></tr>' +
                        '<tr><td><pre><code>[[+width]]</code></pre></td><td><pre><code>'+_('tvimageplus.placeholder.width')+'</code></pre></td></tr>' +
                        '<tr><td><pre><code>[[+height]]</code></pre></td><td><pre><code>'+_('tvimageplus.placeholder.height')+'</code></pre></td></tr>' +
                        '<tr><td><pre><code>[[+mtime]]</code></pre></td><td><pre><code>'+_('tvimageplus.placeholder.mtime')+'</code></pre></td></tr>' +
                        '<tr><td><pre><code>[[+original]]</code></pre></td><td><pre><code>'+_('tvimageplus.placeholder.original')+'</code></pre></td></tr>' +
                        '</tbody>' +
                        '</table>',
                    border: false
                }]
            })
        }
        return this.chunkRenderPanel;
    },



    onChangeRenderType: function(suppressChangeEvent){
        var type = this.typeSelectCombo.getValue().toLowerCase();
        if(suppressChangeEvent!==true)
            suppressChangeEvent = false;

        switch(type){

            case 'snippet':
                this.getSnippetRenderPanel().show();
                this.getChunkRenderPanel().hide();
                break;

            case 'chunk':
                this.getSnippetRenderPanel().hide();
                this.getChunkRenderPanel().show();
                break;

            default:
                this.getSnippetRenderPanel().hide();
                this.getChunkRenderPanel().hide();
                break;

        }

        if(suppressChangeEvent===false){
            this.onFieldChange();
        }
    }



});
Ext.reg('imageplus-panel-tvoutputoptions',ImagePlus.panel.TVOutputOptions);
