<?php


/**
 * Description of BJ_ACTIONS
 *
 * @author studio
 */
class BJ_ACTIONS {


    public function __construct() {

    }

    public static function bj_above_header(){
        do_action('bj_above_header');
    }

    public static function bj_below_header() {
        do_action('bj_below_header');

    }


    public static  function bj_above_footer() {
        do_action('bj_above_footer');
    }



    public static  function bj_bleow_footer() {
        do_action('bj_below_footer');
    }


    public static function bj_above_sidebar($param) {
        do_action('bj_above_sidebar');
    }


    public static function bj_bleow_sidebar($param) {
        do_action('bj_below_sidebar');
    }


    public static function bj_logo_slug(){
        do_action('bj_logo_slug');
    }

}

?>
