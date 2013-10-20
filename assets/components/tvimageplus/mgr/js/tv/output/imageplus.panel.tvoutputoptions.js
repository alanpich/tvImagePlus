ImagePlus.panel.TVOutputOptions = function(config) {
    config = config || {};
    config.params = config.params || {}

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

    /**
     * Marks the MODX TV form as 'dirty' to enable
     * the 'Save' button
     *
     * @returns void
     */
    onFieldChange: function(){
        Ext.getCmp('modx-panel-tv').markDirty();
    },

    /**
     * Render all the elements for the panel
     *
     * @returns void
     */
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

        var line = {
            html: '<hr />'
            ,border: false
        };

        this.add([
                this.typeSelectCombo,line,
                this.getUrlRenderPanel(),
                this.getSnippetRenderPanel(),
                this.getChunkRenderPanel(),
                this.getDataUriRenderPanel()
            ]);

        this.onChangeRenderType(true);
    },


    /**
     * Generate the panel for controlling
     * and describing Snippet output render
     *
     * @returns void
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
     *
     * @returns void
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
                        '<tr><td><pre><code>[[+alt]]</code></pre></td><td><pre><code>'+_('tvimageplus.placeholder.alt')+'</code></pre></td></tr>' +
                        '</tbody>' +
                        '</table>',
                    border: false
                }]
            })
        }
        return this.chunkRenderPanel;
    },

    /**
     * Generate the panel for controlling and
     * describing the URL output type
     *
     * @returns void
     */
    getUrlRenderPanel: function(){
        if(!this.urlRenderPanel){
            this.urlRenderPanel = MODx.load({
                xtype: 'panel',
                layout: 'form',
                anchor: '97%',
                border: false,
                items: [{
                    html: '<p>'+ _('tvimageplus.output_render.url.info') + '</p>'
                    ,border: false
                }]
            })
        }
        return this.urlRenderPanel;
    },

    /**
     * Generate the panel for displaying info about
     * the DataURI render type
     *
     * @returns void
     */
    getDataUriRenderPanel: function(){
        if(!this.dataUriRenderPanel){
            this.dataUriRenderPanel = MODx.load({
                xtype: 'panel',
                layout: 'form',
                anchor: '97%',
                border: false,
                items: [{
                    html: '<p>'+ _('tvimageplus.output_render.datauri.info') + '</p>'
                    ,border: false
                }]
            })
        }
        return this.dataUriRenderPanel;an
    },


    /**
     * Fired when the Image+ Output Type is changed.
     * Shows/hides the relevant additional fields
     *
     * @param suppressChangeEvent
     * @returns void
     */
    onChangeRenderType: function(suppressChangeEvent){
        var type = this.typeSelectCombo.getValue().toLowerCase();
        if(suppressChangeEvent!==true)
            suppressChangeEvent = false;

        switch(type){

            case 'snippet':
                this.getSnippetRenderPanel().show();
                this.getChunkRenderPanel().hide();
                this.getUrlRenderPanel().hide();
                this.getDataUriRenderPanel().hide();
                break;

            case 'chunk':
                this.getSnippetRenderPanel().hide();
                this.getChunkRenderPanel().show();
                this.getUrlRenderPanel().hide();
                this.getDataUriRenderPanel().hide();
                break;

            case 'url':
                this.getSnippetRenderPanel().hide();
                this.getChunkRenderPanel().hide();
                this.getUrlRenderPanel().show();
                this.getDataUriRenderPanel().hide();
                break;

            case 'datauri':
                this.getSnippetRenderPanel().hide();
                this.getChunkRenderPanel().hide();
                this.getUrlRenderPanel().hide();
                this.getDataUriRenderPanel().show();
                break;

            default:
                this.getSnippetRenderPanel().hide();
                this.getChunkRenderPanel().hide();
                this.getUrlRenderPanel().hide();
                this.getDataUriRenderPanel().hide();
                break;

        }

        if(suppressChangeEvent===false){
            this.onFieldChange();
        }
    }



});
Ext.reg('imageplus-panel-tvoutputoptions',ImagePlus.panel.TVOutputOptions);
