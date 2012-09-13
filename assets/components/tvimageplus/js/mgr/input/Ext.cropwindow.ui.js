/**
 * Licence:
 * You can use the Code as you like, only the URL http//www.thomas-lauria/ has to be in the used Files / Code 
 * @author Thomas Lauria
 * http://www.thomas-lauria.de
 */

Ext.ns('Extamples');
Extamples.CropWindowUi = Ext.extend(Ext.Window, {
  title: 'Image Crop Utility',
  width: 660,
  height: 510,
  modal: true,
  initComponent: function() {
    this.fbar = {
      xtype: 'toolbar',
      items: [
        {
          xtype: 'button',
          text: 'cancel',
          ref: '../buttonCancel'
        },
        {
          xtype: 'button',
          text: 'save',
          ref: '../buttonSave'
        }
      ]
    };
    Extamples.CropWindowUi.superclass.initComponent.call(this);
  }
});
