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


var imagePlus = function (config) {
    config = config || {};
    imagePlus.superclass.constructor.call(this, config);
};

Ext.extend(imagePlus, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, jquery: {}, form: {},

    generateThumbUrl: function (params) {
        return this.generatePhpThumbOfUrl(params);
    },

    generatePhpThumbOfUrl: function (params) {
        var url = MODx.config.connectors_url + 'system/phpthumb.php?imageplus=1';
        var defaults = {
            wctx: 'mgr',
            f: 'png',
            q: 90,
            w: 150,
            source: 1
        };
        for (var i in params) {
            defaults[i] = params[i]
        }
        for (i in defaults) {
            url += '&' + i + '=' + defaults[i];
        }
        return url;

    },

    warnAboutUnmetDependencies: function () {
        var warningWindow = MODx.load({
            xtype: 'modx-window',
            title: "&nbsp;&nbsp;&nbsp;Image+ Warning - Unmet Dependencies&nbsp;&nbsp;&nbsp;",
            modal: true,
            padding: 25,
            allowDrop: false,
            resizable: true,
            collapsible: true,
            maximizable: true,
            buttons: [{
                text: _('ok'),
                handler: function (L) {
                    L.ownerCt.ownerCt.close();
                }
            }],
            html: "<h3>You don't have any crop engines!</h3>" +
            "<p>Before you can use Image+, you need at least one Crop Engine installed to handle image manipulation.</p>" +
            "<p>A quick fix is to install either pThumb, phpThumbOf or phpThumbsUp from the MODX Package Repository</p>"
        });
        warningWindow.show();
    }
});
Ext.reg('imageplus', imagePlus);

ImagePlus = new imagePlus();

