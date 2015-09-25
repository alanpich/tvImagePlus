/**
 * Image+ MIGX Renderer
 *
 * Copyright 2013-2015 by Alan Pich <alan.pich@gmail.com>
 * Copyright 2015 by Thomas Jakobi <thomas.jakobi@partout.info>
 *
 * @package imageplus
 * @subpackage script
 *
 * @author Alan Pich <alan.pich@gmail.com>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @copyright Alan Pich 2013-2015
 * @copyright Thomas Jakobi 2015
 */

ImagePlus.MIGX_Renderer = function (json) {
    if (json == null || json == undefined ) return '';
    if (!json.length) return '';
    var data = JSON.parse(json);
    var url = ImagePlus.generateThumbUrl({
        src: data.sourceImg.src,
        source: data.sourceImg.source,
        sw: data.crop.width,
        sh: data.crop.height,
        sx: data.crop.x,
        sy: data.crop.y
    })
    return '<img src="' + url + '" style="max-width:100%; height:auto;" />';
}
