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
            border: "4px dashed #ddd",
            borderRadius: '10px',
            boxSizing: 'border-box'
        });

        this.el.addClass(this.cls);

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
    }
});
Ext.reg('imageplus-imagepreview', ImagePlus.ImagePreview);