<?php
/**
 * @package WordPress
 * @subpackage basejump
 * @author shawnsandy
 */


function hoverizr_scripts(){
    wp_register_script('hoverizer', get_template_directory_uri() . '/library/hoverizer/jquery.hoverizr.min.js', array('jquery'));
    wp_enqueue_script('hoverizer');
}

function hoverizr_footer(){
    ?>
    <script type="text/javascript">
        //jQuery.noConflict(true);
        jQuery('.hoverizr-thumb').hoverizr();
    </script>
    <?php

}
add_action('wp_footer', 'hoverizr_footer');
add_action('wp_enqueue_scripts', 'hoverizr_scripts');

?>