/**
 * Copyright 2013 by Alan Pich <alan.pich@gmail.com>
 *
 * This file is part of ImagePlus
 *
 * ImagePlus is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ImagePlus is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ImagePlus; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package imageplus
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */

ImagePlus.jquery.ImageCrop = function (config) {
    config = config || {};
    this.imageplus = config.imageplus;
    this.window = config.window;
    this.imageDOMid = Ext.id();

    Ext.apply(config, {
        cropData: this.imageplus.crop,
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
        this.$image = $('#' + this.imageDOMid).data('ext', this.window);

        var conf = {
            minSize: this.window.getMinCropSize(),
            aspectRatio: this.window.getAspectRatio(),
            setSelect: this.window.getCropCoords(),
            outerImage: this.window.getOuterImageUrl(),
            onSelect: function (ext) {
                return function (crop) {
                    ext.on_cropChange({
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
