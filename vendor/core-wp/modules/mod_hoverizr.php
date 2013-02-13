<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */

class mod_hoverizr {



    private $slector = '.wp-post-image';

    public function __construct() {
        //add_action('wp_enqueue_scripts', array('mod_hoverizer','load'));
    }

    public function init(){
        add_action('wp_enqueue_scripts', array('mod_hoverizr','load'));
    }


    public function admin(){

    }

    public static function load(){
        wp_register_script('hoverizer', get_template_directory_uri() . '/library/hoverizer/jquery.hoverizr.min.js', array('jquery'));
        wp_enqueue_script('hoverizer');
        add_action('wp_header', array('mod_hoverizr','header'));
        add_action('wp_footer', array('mod_hoverizr','footer'));
    }

    public static function module() {

    }


    public function header(){

    }


    public function footer(){
        ?>
    <script type="text/javascript">
        jQuery.noConflict(true);
        jQuery('.hoverizr-thumb').hoverizr();
    </script>
    <?php

    }



}

?>
