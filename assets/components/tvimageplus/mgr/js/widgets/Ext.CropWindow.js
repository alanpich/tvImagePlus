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
    this.imgLoad = new Image();
    this.imgLoad.onload = (function(){
		this.setSize(this.imgLoad.width + 20, this.imgLoad.height + 100);
		var crop = new Ext.ux.ImageCrop({
				imageUrl: this.imageUrl,
				initialWidth: this.imgLoad.width,
				imageplus: this.imageplus,
				minWidth: this.imageplus.data.constraint.width,
				minHeight: this.imageplus.data.constraint.height,
				initialHeight: this.imgLoad.height,
				quadratic: false,
				cropData: this.imageplus.data.crop
			});
		this.cropData = crop.getCropData();
		crop.on('change', function(foo,x) {this.cropData = x;}, this);
		this.add(crop);
	}).createDelegate(this);
    this.imgLoad.src = this.imageUrl;
    
    // handler for the buttons
    this.buttonCancel.on('click', this.close, this);
    this.buttonSave.on('click', this.saveCrop, this);
  },
  
	saveCrop: function() {
		if(this.fireEvent('save', this) === false){
	  		return this;
		}
	}
});
