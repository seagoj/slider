<style>
    #colors-container {
        background-color: white;
        overflow: auto;
    }
    #colors-content {
        border-bottom: solid;
        border-color: #EEEEEE;
        overflow: auto;
        width: 800px;
        margin-top: 5%;
        margin-bottom: 5%;
    }
    #colors-slideshow {
        float: left;
        margin-bottom: 15px;
        }
    #colors-slideshow img {
        position: absolute;
        margin-top:1%;
    }
    #colors-text 
    {
        margin-left: 310px;
        margin-bottom: 20px;
    }
    #colors-text h1
    {
        color: black;    
        font-size: 20pt;
        margin-top: 30px;
    }
    #colors-text p
    {
        font-size: 8pt;
        margin-top: 10px;
        margin-bottom: 10px;
    }

</style>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script lang='javascript'>
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
</script>

<div id='colors-container'>
    <div id='colors-content'>
        <div id='colors-slideshow'>
            <img class='active' src='../images/colors/SWAN_1-Tundra.jpg'></img>
            <img src='../images/colors/SWAN_2-Ice.jpg'></img>
            <img src='../images/colors/SWAN_3-GoldenSteppe.jpg'></img>
            <img src='../images/colors/SWAN_4-MountainHaze.jpg'></img>
            <img src='../images/colors/SWAN_5-CloudWhite.jpg'></img>
            <img src='../images/colors/SWAN_6-CloudBone.jpg'></img>
            <img src='../images/colors/SWAN_7-ShowerSeat.jpg'></img>
            <img src='../images/colors/SWAN_8-Bathroom.jpg'></img>
        </div>
        <div id='colors-text'>
            <h1>Colors for the bath have reached a new height with the Altitude
            Series.</h1>
            <p>Six exciting colors that have the depth and richness normally
            found only in natural stone are here in shower walls, floors, vanity
            tops & bowls and accessories. And, since they are made with
            Swanstone, these colors will stand the test of time and regular use
            for years to come.</p>
            <p>Experience these colors in person and you'll see how our unique
            process makes each piece as individual as their owner.</p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>

<h1>Colors</h1>
<p>
Not all products are available in all colors. See individual product pages for specific color availability.
</p>



<?php
    $paletteID = "112"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>





<?php
    $paletteID = "84"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>



<?php
    $paletteID = "81"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
    ?>
<li>
  <a href="/images/swatches/400/expresso.jpg" class="thickbox" rel="81" title="espresso"><img src="/images/swatches/65/expresso.jpg"></a>
  <p class="title">
    espresso
  </p>
</li>
        </ul></div>



<?php
    $paletteID = "85"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>


<?php
    $paletteID = "86"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>



<?php
    $paletteID = "88"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>



<?php /* HIDDEN, YET STILL USED ?>

<?php
    $paletteID = "109"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>


<?php
    $paletteID = "110"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>



<?php
    $paletteID = "111"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>


<?php
    $paletteID = "83"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>




<?php
    $paletteID = "82"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>





<?php
    $paletteID = "87"; //$_GET['palette']; - to get Palette name
    $attrQuery = db_query("select id, descr from attributes where id = $paletteID"); 
    $attrDetail = db_fetch_array($attrQuery); 
    $attrName = $attrDetail['descr'];
    // list all swatches for palette defined in $paletteID
    $paletteQuery = db_query("Select * from swatches where attr_id = $paletteID order by name asc");
        echo "<div class='colors'><h2>$attrName</h2><ul>";
        while ($palette = db_fetch_array($paletteQuery)){
?>
<li><a href="/images/swatches/400/<?php print $palette['image']; ?>" class="thickbox" rel="<?php print $palette['attr_id']; ?>" title="<?php print $palette['name']; ?>"><img src="/images/swatches/65/<?php print $palette['image']; ?>"></a><p class="title"><?php print $palette['name']; ?></p></li>
<?php           
        }
        print "</ul></div>";
?>

<?php */ ?>
