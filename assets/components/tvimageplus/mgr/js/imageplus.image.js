/**
 * Image processing functions for ImagePlus
 *
 * @package ImagePlus
 */
ImagePlus.image = new function(){

    /**
     * Scale an image to specified with while
     * maintaining original aspect ratio
     *
     * @param url {String} Url of image to scale
     * @param width {Number} Width in pixels to crop to
     * @param cb {Function} Callback to pass scaled image to
     *                      - Is passed 1 parameter:
     *                          src {String} DataURL src of image
     */
    this.scaleToWidth = function(url, width, cb){

        cb(url);
        return;
        var phpThumbUrl = MODx.config.manager_url + 'connectors/system/phpthumb.php?';

        var img = new Image();


//        if(Ext.isString(img)){
//            var remoteImg = new Image();
//            remoteImg.onload = function(that,width,cb){return function(){
//                    that.scaleToWidth(this,width,cb);
//                }}(this,width,cb);
//                remoteImg.src = img;
//            return;
//        }
//
//        var ratio = img.width / img.height,
//            height = width/ratio,
//            cvs = document.createElement('canvas'),
//            ctx = cvs.getContext('2d');
//        cvs.width = img.width;
//        cvs.height = img.height;
//        ctx.drawImage(img,0,0,img.width,img.height,0,0,img.width,img.height);
//        //         ctx.drawImage(img,0,0,img.width,img.height,0,0,width,height);
//        // Pass image src to callback
//        cb(cvs.toDataURL());
    }



};