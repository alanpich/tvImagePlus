/**
 * Licence:
 * You can use the Code as you like, only the URL http//www.thomas-lauria/ has to be in the used Files / Code 
 * @author Thomas Lauria
 * http://www.thomas-lauria.de
 */
 
Extamples.CropWindow = Ext.extend(Extamples.CropWindowUi, {
  cropData: null,
  imageUrl: '',
  initComponent: function() {
    
    // I am using an image preloader here, for getting the initial height and width
    //
    Extamples.CropWindow.superclass.initComponent.call(this);
    var imgLoad = new Image();
    imgLoad.onload = (function(){
      this.setSize(imgLoad.width + 20, imgLoad.height + 100);
      var crop = new Ext.ux.ImageCrop({
        imageUrl: this.imageUrl,
        initialWidth: imgLoad.width,
        imageplus: this.imageplus,
        minWidth: this.imageplus.data.constraint.width,
        minHeight: this.imageplus.data.constraint.height,
        initialHeight: imgLoad.height,
        quadratic: false
      });
      this.cropData = crop.getCropData();
      crop.on('change', function(foo,x) {this.cropData = x;}, this);
      this.add(crop);
    }).createDelegate(this);
    imgLoad.src = this.imageUrl;
    
    // handler for the buttons
    this.buttonCancel.on('click', this.close, this);
    this.buttonSave.on('click', this.saveCrop, this);
  },
  saveCrop: function() {
    if(this.fireEvent('save', this) === false){
      return this;
    }
    
    /*
     *  or you can use a ajax call!
    Ext.Ajax.request({
      url: this.imageUrl,
      method: 'post',
      params: this.cropData,
      success: function(){
        if(this.fireEvent('save', this) === false){
          return this;
        }
        this.close();
      },
      scope: this
    });
    */
  }
});
