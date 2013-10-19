/**
 * Image processing functions for ImagePlus
 *
 * @package ImagePlus
 */
ImagePlus.image = new function () {

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
    this.scaleToWidth = function (url, width, cb) {
        cb(url);
    };


    this.getBlurred = function(url,cb){

        if(Modernizr.canvas){

            this.loadImage(url,function(that,cb){return function(img){

                var blurred = that.filter.blur(img,10);
                cb(blurred);

            }}(this,cb));


        } else {
            console.warn("Browser does not support canvas!");
            cb(url);
        }
    };




    this.filter = {


        blur: function(img,radius){


            var w = img.naturalWidth;
            var h = img.naturalHeight;
            var canvasID = 'cvs-'+Math.round(Math.random()*10000);
            var canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                canvas.id = canvasID;
            canvas.style.width  = w + "px";
            canvas.style.height = h + "px";
            canvas.width = w;
            canvas.height = h;
            var context = canvas.getContext("2d");
            context.clearRect( 0, 0, w, h );
            context.drawImage( img, 0, 0 );

            if ( isNaN(radius) || radius < 1 ) return;

            var blurAlphaChannel = true;
            if ( blurAlphaChannel )
                stackBlurCanvasRGBA( canvas, 0, 0, w, h, radius );
            else
                stackBlurCanvasRGB( canvas, 0, 0, w, h, radius );

            return canvas.toDataURL();
        }



    };

    /**
     * Load an image from a url and pass it to a callback
     * @param src {String} Image URL
     * @param cb {Function} Callback function
     */
    this.loadImage = function(src,cb){
        var img = new Image();
            img.onload = function(cb){return function(){
                cb(this);
            }}(cb);
            img.src = src;
    };


    /**
     * Returns image data for an img
     *
     * @param img
     * @returns {ImageData}
     */
    this.getImageData = function(img){
        var cvs = document.createElement('canvas');
            cvs.width = img.width;
            cvs.height = img.height;
        var ctx = cvs.getContext('2d');
            ctx.drawImage(img);
        return ctx.getImageData(0,0,cvs.width,cvs.height);
    }

};