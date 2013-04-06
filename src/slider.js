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
    $.fn.slider = function(type, duration) {
        type = typeof type !== 'undefined' ? type : 'Fade';
        duration = typeof duration !== 'undefined' ? duration : 5000;

        var $container = this;
        var count = 0;
        var validTypes = ['Fade','FadeInto','FadeIntoForever'];

        if(validTypes.indexOf(type) !== -1) {
            this["init"+type]();

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
    $.fn.initFadeIntoForever = function(start) {
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
    };

    $.fn.slideFadeIntoForever = function (intervalID, count, fadeSpeed) {
        // if(count == 6) clearInterval(intervalID);
        // if(count !== 0 && count%7 == 0 ) this.reset();

        fadeSpeed = typeof fadeSpeed !== 'undefined' ? fadeSpeed : 'slow';
        var $swap = this.swapForever();
        var $container = this;

        $swap["active"].fadeOut(fadeSpeed, function() {
            $swap["active"].hide(function() {
                $swap["next"].addClass('active');
                var $element = $swap["next"];
               
                for(var count = $container.children().length; count>0; count = count -1) {
                    $element.css({'z-index':count}).show();

                    $element = $element.next().length ? element.next()
                        : $container.children(":first");
                }
            });
        });

        return count+1;
    };

    $.fn.swapForever = function () {
        var $active = this.children(".active").toggleClass('active');
        var $next = $active.next().length ? $active.next()
            : this.children(":first");
                
        return {"active":$active,"next":$next};
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
                   var nextZ = $container.nextZ();
                   $swap["active"].css({'z-index':nextZ}).show();
                });
            })

        return count+1;
    };

    $.fn.swap = function () {
        var $active = this.children(".active").toggleClass('active');
        if($active.length == 0)
            $active = this.children(":last");
        var $next = $active.next().length ? $active.next()
            : this.children(":first");
                
        return {"active":$active,"next":$next};
    };

    $.fn.nextZ = function(){
        var nextZ = 999;
        var length = this.children().length;
        for(var count=1; count<=length; count = count +1) {
            if(nextZ>this.find(":nth-child("+count+")").css("z-index"))
                nextZ = this.find(":nth-child("+count+")").css("z-index");
        }
        return nextZ-1;
    };

}) (jQuery);
