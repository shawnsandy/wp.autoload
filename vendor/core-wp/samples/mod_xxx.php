<?php

/**
 * @package WordPress
 * @subpackage Basejump
 */
class mod_xxx {

    //put your code here

    public function __construct() {
        add_action('wp_enqueue_scripts', array('mod_xxx','load'));
    }

    /**
     * *************************************************************************
     * Basic module functions
     * *************************************************************************
     */

    /**
     * Module admin functions
     */
    public function admin() {

    }

    /**
     * Load module files
     */
    public static function load() {
//        wp_register_script('xxx', get_template_directory_uri() . '/library/xxx/xxx.js', array('jquery'));
//        wp_enqueue_script('xxx');
        add_action('wp_header', array('mod_xxx', 'header'));
        add_action('wp_footer', array('mod_xxx', 'footer'));
    }

    public static function module() {

    }

    public function header() {
        ?>

        <?php

    }

    public function footer() {
        ?>

        <?php

    }

    /*
     * *************************************************************************
     * custom function below here
     * *************************************************************************
     */



}

