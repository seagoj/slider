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
    
        var type = options.type;
        var duration = options.duration;
        var $container = this;
        var count = 0;
        var validTypes = ['Fade','FadeInto','Horizontal','Vertical'];

        console.log(options);

        this.initActive();

        if(validTypes.indexOf(options.type) !== -1) {
            this["init"+options.type]();

            var intervalID = setInterval(function() {
                count = $container["slide"+options.type](intervalID, count);
            }, options.duration);
        } else {
            alert(options.type+" is not a supported slideshow type.");
            return false;
        }
    };

    $.fn.initActive = function() {
        this.children(":first").addClass('active'); 
    };

    /**
     * Sets the initial state for the FadeInto slideshow
     *
     * start    z-index for top-most element in slideshow; Defaults to 100
     */
    $.fn.initFadeInto = function() {
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

    $.fn.slideFadeInto = function (intervalID, count, options) {
        var defaults = {
            'fadeSpeed':'slow',
            'stop':null
        };
        options = overwrite(defaults, options);

        if((options.stop !== null)&&(count == options.stop))
            clearInterval(intervalID);

        var $swap = this.swap();
        var $container = this;

        $swap["active"].fadeOut(options.fadeSpeed, function() {
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
        this.children(".active").show();       
    };

    $.fn.slideFade = function (intervalID, count, options) {
        var defaults = {
            'fadeSpeed':'slow',
            'stop':null
        };
        options = overwrite(defaults, options);

        if((options.stop !== null)&&(count == options.stop))
            clearInterval(intervalID);

        var $swap = this.swap();

        $swap["active"].fadeOut(fadeSpeed, function () {
            $swap["active"].hide(function () {
                $swap["next"].addClass('active')
                    .fadeIn(fadeSpeed);
            });
        });
    };

    $.fn.initHorizontal = function() {
        this.children().hide();
        this.children(".active").show();
        console.log('.initHorizontal()');
        return true;    
    };

    $.fn.slideHorizontal = function(options) {
        console.log('.slideHorizontal()');
        var defaults = {
            'fadeSpeed':'slow'  
        };
        options = overwrite(defaults, options);
       
        var $swap = this.swap();
        console.log($swap);
        $swap['next'].show().addClass('active');
        $swap['active'].hide('slide', {direction: 'left'}, 1000);
    };

    $.fn.swap = function () {
        var $active = this.children(".active").removeClass('active');
        var $next = $active.next().length ? $active.next()
            : this.children(":first");
                
        return {"active":$active,"next":$next};
    };

}) (jQuery);
