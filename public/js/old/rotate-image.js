(function( $ ) {
    $.fn.rotateImage = function(rotate = 0, invert = 1) {
        if(!this.is('img')) return this;

        this.css({
            '-webkit-transform' : `scaleX(${invert}) rotate(${rotate}deg)`,
            'transform'         : `scaleX(${invert}) rotate(${rotate}deg)`
        });

        return this;
    };
}( jQuery ));