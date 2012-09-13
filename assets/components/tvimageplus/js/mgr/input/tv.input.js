ImagePlusArray = new Array();

ImagePlus = function( TVid, opts){ //===============================================================|

	this.defaultData = {
		rawImage: {
			displayPath :'',
			width: 0,
			height: 0
		},
		width: 0,
		height: 0
	};
	
	this.constraints = {};


	this.tvID = 'tv'+TVid;
	
	// Expand options
	for(i in opts){	this[i] = opts[i];	};
	
	// wrapper elem
	this.wrapperElem = document.getElementById(this.wrapperID);
	
	// Grab actual TV input element (normally hidden)
	this.TV = document.getElementById(this.tvID);
	this.originalValue = this.TV.value;
	
	
	
	
	
////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////	



////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////	
	
	

this.init = function(){

		this.prepareData();
	
		// Prepare params
		this.prepareConstraints();
	
		this.createImageSelector();
		this.createCropButton();
		
		// Set up the image preview
		this.previewImage = document.createElement('img');
		this.wrapperElem.appendChild(this.previewImage);
		
		this.updateTV();	
		
		this.updatePreview();
	}//
	
	
	
// Check & Prepare input data
//----------------------------------------------------------------	
this.prepareData = function(){
		
		// First account for new tv (no data)
		if(this.data == null){
			console.log('using default data');
			this.data = this.defaultData;
		};		
		
		
		// Establish output size ratio
		if(this.data.constraint.width>0 && this.data.constraint.height>0){
			// If both constraints set
			this.data.constraint.ratio = this.data.constraint.width/this.data.constraint.height;
		} else
		if( !isNaN(this.data.source.width/this.data.source.height) ){
			// Compute from raw image dimensions
			this.constraint.ratio = this.data.source.width/this.data.source.height;
		} else {
			// Fallback safely
			this.constraint.ratio = 1;
		};
		
		
	}//	
	
	
////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////	


// Prepare constraint params
//----------------------------------------------------------------	
this.prepareConstraints = function(){
	
		this.constraints.targetWidth = parseInt(this.params.targetWidth) || 0;
		this.constraints.targetHeight = parseInt(this.params.targetHeight) || 0;	
		
		// If both width & height are set, use them to calculate ratio
		if(this.constraints.targetWidth > 0 && this.constraints.targetHeight>0){
			this.constraints.ratio = this.constraints.targetWidth / this.constraints.targetHeigt;
		} else {
		// Otherwise use the source image's size ratio
		console.log(this.data.source.width,this.data.source.height);
			this.data.constraint.ratio = this.data.source.width / this.data.source.height;
		};
		
		// 
		
	}//


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	


// Create source image browser
//----------------------------------------------------------------	
this.createImageSelector = function(){

		var value = this.data.source.path+this.data.source.filename;

		// Create the source image selector
		this.imageSelector = MODx.load({
				xtype: 'modx-combo-browser',
				renderTo: this.wrapperID,
				source: this.mediaSource,
				value: value,
				openTo: this.data.source.path,
				listeners: {
					'select': {fn: function(data){
						this.updateSourceImage(data)
					}, scope: this}
				}
				
			});
	}//
	
	
	
// Create 'edit' button 
//----------------------------------------------------------------	
this.createCropButton = function(){
		this.cropButton = MODx.load({
			xtype: 'button',
			text: 'Edit image', // _('tvimageplus.edit_image_buttontext'),			
			renderTo: this.wrapperID,
			imageplus: this,
			handler: function(btn,e){
				btn.imageplus.showCropWindow();
			}
		});
	}//	
	
	
	
this.showCropWindow = function(){

		this.cropWindow = new Extamples.CropWindow({
						imageUrl: this.data.mediasource.url+this.data.source.path+this.data.source.filename
						,imageplus: this
						,title: 'Edit Image' // _('tvimageplus.edit_image')
						,listeners:{
						    save: function(cmp){
						      this.updateCropData(cmp.cropData);
						      cmp.close();
						    },
						    scope: this
						  }
					});
		this.cropWindow.show();
		return;
		
		this.cropWindow = MODx.load({
			xtype: 'window',
			title: 'Edit image',
			imageplus: this,
			width: this.data.source.width,
			height: this.data.source.height,
			padding:0,
			listeners: {
				'render': {fn: function(win){
					win.add( new Extamples.CropWindow({
						imageUrl: this.data.mediasource.url+this.data.source.path+this.data.source.filename
					}));
				},scope:this}		
			}
		});
		this.cropWindow.show();
		
	}//	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
// A new source image has been selected
//----------------------------------------------------------------
this.updateSourceImage = function(data){
		console.log(data);
		this.data.source = {
			path: data.relativeUrl.replace(data.name,''),
			filename: data.name,
			width: data.image_width,
			height: data.image_height,
			size: data.size
		};
		
		this.prepareConstraints();
		this.updateTV();
		this.updatePreview();
	}//	
	
	
	
	
// Parse saved data to useful
//----------------------------------------------------------------
this.updateCropData = function(crop){
		this.data.crop = crop;
		
		this.updateTV();
		this.updatePreview();
	}//	
	
	
	
// Parse saved data to useful
//----------------------------------------------------------------
this.updateTV = function(){
		// Generate new JSON value
		var value = JSON.stringify(this.data);
		
		// Set tv field to new value
		this.TV.value = value;
		
		// Check for a change and mark dirty if needed
		if(value != this.originalValue){
			Ext.getCmp('modx-panel-resource').markDirty();
		};
	}//


// Update / Generate a preview of the image
//----------------------------------------------------------------
this.updatePreview = function(){
		
		var imgSrc = this.data.mediasource.path+this.data.source.path+this.data.source.filename;

		var paramObj = {
			'w': this.data.constraint.width,
			'h': this.data.constraint.height,
			'sx': this.data.crop.x,
			'sy': this.data.crop.y,
			'sw': this.data.crop.width,
			'sh': this.data.crop.height,
			'src': imgSrc,
			'far':true
		}
		var params = '';
		for(i in paramObj){
			params+= i+'='+paramObj[i]+'&';
		};
		console.log(params);
		var previewURL = MODx.config.connectors_url+'system/phpthumb.php?'+params;
		
		this.previewImage.src = previewURL;
	}//
	
}// end ImagePlus object ============================================================================|
