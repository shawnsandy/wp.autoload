<?php

/**
 * @package WordPress
 * @subpackage Basejump
 */
class mod_scrollto {

    //put your code here

    public function __construct() {

    }

    /**
     * *************************************************************************
     * Basic module functions
     * *************************************************************************
     */

    public function init(){
        add_action('wp_enqueue_scripts', array('mod_scrollto','load'));
    }

    /**
     * Module admin functions
     */
    public function admin() {

    }

    /**
     * Load module files
     */
    public static function load() {
        wp_register_script('jquery-scrollTo', get_template_directory_uri() . '/library/scrollto/jquery.scrollTo-min.js', array('jquery'),true);
        wp_register_script('jquery-localScroll', get_template_directory_uri() . '/library/scrollto/jquery.localscroll-min.js', array('jquery'),true);
        wp_enqueue_script('jquery-scrollTo');
        wp_enqueue_script('jquery-localScroll');
        add_action('wp_header', array('mod_scrollto', 'header'));
        add_action('wp_footer', array('mod_scrollto', 'footer'));

    }

    public static function module() {

    }

    public function header() {
        ?>

        <?php

    }

    public function footer() {
        ?>
        <script type="text/javascript">
           jQuery.noConflict(true);
            jQuery(document).ready(function(){
                jQuery.localScroll();
            });
        </script>
        <?php

    }

    /*
     * *************************************************************************
     * custom function below here
     * *************************************************************************
     */
}

