ImagePlus.ImagePreview = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        width: 300,
        height: 120,
        text: false,
        cls: 'ip-imagepreview',
        textCls: 'ip-imagepreview-text'
    })
    ImagePlus.ImagePreview.superclass.constructor.call(this, config);
    this.on('render',this.on_render,this);
};
Ext.extend(ImagePlus.ImagePreview, Ext.Component, {


    on_render: function(){
        this.el.setStyle({
            width: this.width+"px",
            height: this.height+"px",
            boxSizing: 'border-box'
        });

        this.el.addClass(this.cls);

        // Add image preview
        this.img = new Ext.Element(document.createElement('img'));
        this.img.set({
            width: '100%'
        });
        this.el.appendChild(this.img);

        // Add text
        if(this.text){
            this.textEl = new Ext.Element(document.createElement('p'))
            this.textEl.dom.innerHTML = this.text
            this.textEl.addClass(this.textCls);
            this.textEl.setStyle({
                pointerEvents: 'none'
            })
            this.el.appendChild(this.textEl);
        }
    },

    getWidth: function(){
        return this.el.getWidth();
    },
    getHeight: function(){
        return this.el.getHeight();
    },


    /**
     * Pass the Image object to show in preview
     *
     * @param img {Image}
     */
    setImage: function(img){
        this.img.set({
            src: img.src
        });
        var ratio = img.width / img.height;
        this.el.setHeight( this.getWidth() / ratio );
        this.el.addClass('has-image');
    },

    clearImage: function(){
        this.img.set({
            src: ImagePlus.config.mgr_url+'css/spacer.gif'
        });
        this.el.setHeight(this.height);
        this.el.removeClass('has-image');
    }
});
Ext.reg('imageplus-imagepreview', ImagePlus.ImagePreview);