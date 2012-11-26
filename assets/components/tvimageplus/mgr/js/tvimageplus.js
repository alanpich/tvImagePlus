var tvImagePlus = function(config) {
    config = config || {};
    tvImagePlus.superclass.constructor.call(this,config);
};
Ext.extend(tvImagePlus,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},jquery:{}
});
Ext.reg('doodles',tvImagePlus);
tvImagePlus = new tvImagePlus();
