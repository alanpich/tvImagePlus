/**
 * Image+ Custom Manager Page Script
 *
 * @package imageplus
 * @subpackage script
 */

var $jqIP = jQuery.noConflict();

ImagePlus.jquery.ImageCrop = function (config) {
    config = config || {};
    this.image = config.image;
    this.window = config.window;
    this.imageDOMid = Ext.id();

    Ext.apply(config, {
        cropData: this.image.crop,
        collapsable: false,
        items: [{
            border: false,
            html: '<img id="' + this.imageDOMid + '" src="' + this.window.getImageUrl() + '" />'
        }],
        listeners: {
            afterRender: {
                fn: this.onAfterRender,
                scope: this
            },
            destroy: {
                fn: function () {
                    this.cropper.destroy()
                },
                scope: this
            }
        }
    });
    ImagePlus.jquery.ImageCrop.superclass.constructor.call(this, config);
};
Ext.extend(ImagePlus.jquery.ImageCrop, Ext.Panel, {

    onAfterRender: function () {
        this.initJcrop.defer(10, this)
    },

    initJcrop: function () {
        this.$image = $jqIP('#' + this.imageDOMid).data('ext', this.window);

        var conf = {
            minSize: this.window.getMinCropSize(),
            aspectRatio: this.window.getAspectRatio(),
            setSelect: this.window.getCropCoords(),
            outerImage: this.window.getOuterImageUrl(),
            onSelect: function (ext) {
                return function (crop) {
                    ext.onCropChange({
                        x: crop.x,
                        y: crop.y,
                        width: crop.w,
                        height: crop.h
                    })
                }
            }(this.window)
        };
        this.$image.Jcrop(conf, function (ths) {
            return function () {
                ths.cropper = this;
                this.setOptions({
                    outerImage: ths.window.getOuterImageUrl(),
                    bgOpacity: 0.5
                })
            }
        }(this))
    },

    get_image: function () {
        return this.$image;
    }

});
Ext.reg('imageplus-jquery-imagecrop', ImagePlus.jquery.ImageCrop);
