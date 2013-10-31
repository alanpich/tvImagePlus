ImagePlus.panel.ImagePreview = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        width: 290,
        height: 120,
        unstyled: true,
        margin:0,
        padding:0,
        autoEl: 'div',
        cls: '',
        labelText: 'Drop files here or click to upload'
    })
    ImagePlus.panel.ImagePreview.superclass.constructor.call(this, config);
    this.on('render',this.on_render,this);
};
Ext.extend(ImagePlus.panel.ImagePreview, Ext.Component, {

    /**
     * Do the rendering thang
     *
     * @returns void
     */
    on_render: function(){

        // Set the core required styles and attributes
        this.el.addClass(this.cls + ' ip-imagepreview');
        this.el.setStyle({
            width: this.width+'px'
        })

        this.createImageElement();

        this.createTextElement();

    },

    /**
     * Create the <img> element to show preview in
     *
     * @returns void
     */
    createImageElement: function(){
        this.img = new Ext.Element(document.createElement('img'));
        this.el.appendChild(this.img);
    },

    /**
     * Create the text label element
     *
     * @returns void
     */
    createTextElement: function(){
        this.label = new Ext.Element(document.createElement('label'));
        this.el.appendChild(this.label);
        this.setLabel(this.labelText);
    },

    /**
     * Set the source URL for the image preview,
     * hiding the label text
     *
     * @param src {String} URL of image
     * @returns void
     */
    setImage: function(src){
        this.img.set({
            src: src
        })
        this.el.addClass('has-image');
    },

    /**
     * Clears the image preview, returning it to
     * its default empty state and displaying the
     * label text
     *
     * @returns void
     */
    clearImage: function(){
        this.img.set({
            src: ImagePlus.config.mgr_url+'css/spacer.gif'
        });
        this.el.removeClass('has-image')
    },

    /**
     * Set the label text
     * @TODO Re-center the text in the window
     *
     * @param text {String}
     * @returns void
     */
    setLabel: function(text){
        this.label.dom.innerHTML = text;

        var h = this.label.getHeight();
        this.label.setStyle({
            marginTop: (-h/2)+'px'
        })
    },

    /**
     * Get the width of the component
     *
     * @returns {Number}
     */
    getWidth: function(){
        return this.el.getWidth()
    }

});
Ext.reg('imageplus-panel-imagepreview',ImagePlus.panel.ImagePreview);