(function($) {
        
    $(document).ready(function() {
        $('#colors-slideshow').slideshow('fade-into');
    });

    $.fn.slideshow = function(type, duration) {
        type = typeof type !== 'undefined' ? type : 'fade';
        duration = typeof duration !== 'undefined' ? duration : 5000;
        var $container = this;
            
        var count =0;

        switch(type) {
            case 'fade':
                this.children().hide().fadeOut();
                this.children(":first").addClass('active').show();

                var intervalID = setInterval(function() {
                    $container.slideshowFade(intervalID);
                }, duration);
                break;
            case 'fade-into':
                this.orderDeck();

                var intervalID = setInterval(function() {
                    count = $container.slideshowFadeInto(intervalID, count);
                }, duration);
                break;
        };
    };
        
    $.fn.slideshowFadeInto = function (intervalID, count, fadeSpeed) {
        /* if(count == 6) clearInterval(intervalID); */
        /* if(count !== 0 && count%7 == 0 ) this.reset(); */

        fadeSpeed = typeof fadeSpeed !== 'undefined' ? fadeSpeed : 'slow';
        var $swap = this.swap();
        var $container = this;

        $swap["active"].removeClass('active last-active')
            .fadeOut(fadeSpeed, function() {
                $swap["active"].hide(function() {
                   $swap["next"].addClass('active');
                   var nextZ = $container.nextZ();
                   $swap["active"].css({'z-index':nextZ}).show();
                });
            })


        return count+1;
                
    };

    $.fn.slideshowFade = function (fadeSpeed) {
        fadeSpeed = typeof fadeSpeed !== 'undefined' ? fadeSpeed : 'slow';
        var $swap = this.swap();

        $swap["active"].removeClass('active last-active')
            .fadeOut(fadeSpeed, function () {
                $swap["active"].hide(function () {
                    $swap["next"].addClass('active')
                        .fadeIn(fadeSpeed);
                });
            });
                
    };

    $.fn.swap = function () {
        var $active = this.children(".active").toggleClass('active');
        if($active.length == 0)
            $active = this.children(":last");
        var $next = $active.next().length ? $active.next()
            : this.children(":first");
                
        return {"active":$active,"next":$next};
    }

    $.fn.orderDeck = function(start) {
        start = typeof start !== 'undefined' ? start : 999
        this.children(":first").addClass('active').show();
        for(var i=1; i<=this.children().length; i=i+1) {
            this.find(":nth-child("+i+")")
            .addClass('child-'+i)
            .css({'z-index':start-i})
            .show();
        }
    }

    $.fn.nextZ = function(){
        var nextZ = 999;
        var length = this.children().length;
        for(var count=1; count<=length; count = count +1) {
            if(nextZ>this.find(":nth-child("+count+")").css("z-index"))
                nextZ = this.find(":nth-child("+count+")").css("z-index");
        }
        return nextZ-1;
    }

}) (jQuery);
