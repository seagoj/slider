    /**
     * Sets the initial state for the FadeInto slideshow
     *
     * start    z-index for top-most element in slideshow; Defaults to 100
     */
    $.fn.initFadeInto = function(start) {
        start = typeof start !== 'undefined' ? start : 100

        // Adds .active to first element in 'this'
        this.children(":first").addClass('active');

        // Iterates through all children of 'this'
        //     sets initiale z-index (start - order in 'this')
        //     sets position: absolute
        //     shows child
        for(var i=1; i<=this.children().length; i=i+1) {
            this.find(":nth-child("+i+")")
            .css({
                'z-index':start-i,
                'position':'absolute'
            })
            .show();
        }
    }

    $.fn.slideFadeInto = function (intervalID, count, fadeSpeed) {
        // if(count == 6) clearInterval(intervalID);
        // if(count !== 0 && count%7 == 0 ) this.reset();

        fadeSpeed = typeof fadeSpeed !== 'undefined' ? fadeSpeed : 'slow';
        var $swap = this.swap();
        var $container = this;

        $swap["active"].fadeOut(fadeSpeed, function() {
                $swap["active"].hide(function() {
                   $swap["next"].addClass('active');
                   var nextZ = $container.nextZ();
                   $swap["active"].css({'z-index':nextZ}).show();
                });
            })


        return count+1;
                
    };
