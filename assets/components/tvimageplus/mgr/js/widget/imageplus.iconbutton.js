ImagePlus.IconButton = function(config){
    config = config || {};
    Ext.applyIf(config,{
        autoEl: 'a'
        ,icon: false
        ,size: 16
        ,color: '#aaa'
        ,hoverColor: '#111'
        ,style: {}
    });
    ImagePlus.IconButton.superclass.constructor.call(this,config);

    this.addEvents('click');
    this.on('render',this.on_render,this);
};
Ext.extend(ImagePlus.IconButton,Ext.Component,{

    /**
     * Do the main rendering thingy
     */
    on_render: function(){

        this.el.addClass('imageplus-ui-button');
        this.el.setStyle({
            cursor: 'pointer'
        });

        this.el.setStyle(this.style);

        this.el.on('mouseenter',function(){
            this.el.addClass('hover');
            this.iconEl.setStyle('color',this.hoverColor);
        },this);
        this.el.on('mouseleave',function(){
            this.el.removeClass('hover');
            this.iconEl.setStyle('color',this.color);
        },this);


        this.el.on('click',this.on_click,this)


        // Create icon element
        this.iconEl = new Ext.Element(document.createElement('i'));
        this.iconEl.addClass('icon-fixed-width');
        if(this.icon)
            this.iconEl.addClass(this.icon);
        this.iconEl.setStyle({
            fontSize: this.size+'px'
            ,color: this.color
        });
        this.el.appendChild(this.iconEl);


    },


    on_click: function(){
        this.fireEvent('click');
    },

    getWidth: function(){
        return this.el.getWidth()
    },




});
Ext.reg('imageplus-iconbutton',ImagePlus.IconButton);
