/**
 * Image+ MIGX Renderer
 *
 * @package imageplus
 * @subpackage script
 * @return {string}
 */

ImagePlus.MIGX_Renderer = function (json) {
    if (typeof (json) === 'undefined' || json === null || !json.length) {
        return '';
    }
    var data, url, cls;
    try {
        data = JSON.parse(json);
        url = ImagePlus.generateThumbUrl({
            src: data.sourceImg.src,
            source: data.sourceImg.source,
            sw: data.crop.width,
            sh: data.crop.height,
            sx: data.crop.x,
            sy: data.crop.y
        });
        cls = 'imageplus';
    } catch (e) {
        url = MODx.config.base_url + json;
        cls = 'plain';
    }
    return '<img class="' + cls + '" src="' + url + '" style="max-width:100%; height:auto;" />';
};
