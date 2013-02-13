<?php if (!defined('ABSPATH')) die('ERROR-911');

/**
 * @package WordPress
 * @subpackage Basejump
 */


//*************slides***************

add_action('wp_enqueue_scripts', 'home_scripts');

function home_scripts() {
    wp_register_script('slides', get_template_directory_uri() . '/library/slides/slides.min.jquery.js', array('jquery'), false);
    wp_register_style('slides-style', get_template_directory_uri() . '/library/slides/slide-style.css');
    wp_enqueue_script('slides');
    wp_enqueue_style('slides-style');
}

add_action('wp_footer', 'home_slider');
add_action('wp_head', 'home_header');

function home_header() {
    ?>

    <?php
}

function home_slider() {
    ?>
    <script type="text/javascript">
        //jQuery.noConflict(true);

        jQuery('#slides').slides({
            play: 5000,
            generatePagination: false,
            animationStart: function(current){
                jQuery('.caption').animate({
                    bottom:-60
                },100);
                if (window.console && console.log) {
                    // example return of current slide number
                    console.log('animationStart on slide: ', current);
                };
            },
            animationComplete: function(current){
                jQuery('.caption').animate({
                    bottom:0
                },200);
                if (window.console && console.log) {
                    // example return of current slide number
                    console.log('animationComplete on slide: ', current);
                };
            },
            slidesLoaded: function() {
                jQuery('.caption').animate({
                    bottom:0
                },200);
            }
        });

    </script>

    <?php
}

//******************END CYCLE***********************/
