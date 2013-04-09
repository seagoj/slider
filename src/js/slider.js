(function($) {

    /** 
     * .slider
     * 
     * Begins the slideshow by choosing the type of slide and duration
     * 
     * type        Type of slideshow to run; Defaults to 'fade'
     * duration    Time in miliseconds that each element is visible; Defaults to
     *                 5000
     */
    $.fn.slider = function(options) {
        var defaults = {
            'type':'Fade',  
            'duration':5000
        };

        options = overwrite(defaults, options);
        console.log(options);
//        var type = typeof options["type"] !== 'undefined' ?
//           options["type"] : 'Fade';
//      var duration = typeof options["duration"] !== 'undefined' ?
//            options["duration"] : 5000;

        var type = options.type;
        var duration = options.duration;
        var $container = this;
        var count = 0;
        var validTypes = ['Fade','FadeInto','Horizontal','Vertical'];

        if(validTypes.indexOf(options['type']) !== -1) {
            this["init"+type ]();

            var intervalID = setInterval(function() {
                count = $container["slide"+type](intervalID, count);
            }, duration);
        } else {
            alert(type+" is not a supported slideshow type.");
            return false;
        }
    };

    /**
     * Sets the initial state for the FadeInto slideshow
     *
     * start    z-index for top-most element in slideshow; Defaults to 100
     */
    $.fn.initFadeInto = function() {
        // Adds .active to first element in 'this'
        this.children(":first").addClass('active');

        // Iterates through all children of 'this'
        //     sets initiale z-index (start - order in 'this')
        //     sets position: absolute
        //     shows child
        var count = this.children().length;
        for(var i=1; i<=count; i=i+1) {
            this.find(":nth-child("+i+")")
            .css({
                'z-index':count - i,
                'position':'absolute'
            })
            .show();
        }
    };

    $.fn.slideFadeInto = function (intervalID, count, fadeSpeed) {
        // if(count == 6) clearInterval(intervalID);
        // if(count !== 0 && count%7 == 0 ) this.reset();

        fadeSpeed = typeof fadeSpeed !== 'undefined' ? fadeSpeed : 'slow';
        var $swap = this.swap();
        var $container = this;

        $swap["active"].fadeOut(fadeSpeed, function() {
            $swap["active"].hide(function() {
                $swap["next"].addClass('active');
                var $element = $swap["next"];

                for(var count=$container.children().length;count>0;count=count-1) {
                    $element.css({'z-index':count}).show();

                    $element = $element.next().length ? $element.next()
                        : $container.children(":first");
                }
            });
        });
    };

    $.fn.initFade = function() {
        this.children().hide().fadeOut();
        this.children(":first").addClass('active').show();       
    };

    $.fn.slideFade = function (fadeSpeed) {
        fadeSpeed = typeof fadeSpeed !== 'undefined' ? fadeSpeed : 'slow';
        var $swap = this.swap();

        $swap["active"].fadeOut(fadeSpeed, function () {
            $swap["active"].hide(function () {
                $swap["next"].addClass('active')
                    .fadeIn(fadeSpeed);
            });
        });
    };

    $.fn.swap = function () {
        var $active = this.children(".active").toggleClass('active');
        var $next = $active.next().length ? $active.next()
            : this.children(":first");
                
        return {"active":$active,"next":$next};
    };

}) (jQuery);
