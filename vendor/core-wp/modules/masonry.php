<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of masonry
 *
 * @author Studio365
 */
class masonry {
    //put your code here

    public function __construct() {

    }

    public static function load() {
        $js = CM_URL . '/masonry/js/jquery.masonry.min.js';
        wp_enqueue_script('masonry', $js, array('jquery'));
        $css = cwp::css('masonry', 'masonry');
        if($css)
        wp_enqueue_style('masonry', $css);
    }

    public static function config($array=array(),$itemselector='.grid_3',$id='masonry') {
        extract($array);
        $path = cwp::config('config', 'masonry');
        if ($path)
            include_once CM_PATH . '/masonry/config.php';
        else
            return 'Masonry file not found';
    }

    /**
     *
     * @param type $query
     * @param type $tpl
     * @param type $class
     */
    public static function tpl($query='showposts=8', $tpl='masonry-grid', $id="masonry") {
        //echo '<div id="masonry">';
        $_query = new WP_Query($query);
        if ($_query->have_posts()):
            while ($_query->have_posts()):
                $_query->the_post();
            core_module::tpl($tpl, 'masonry');
            endwhile;
        else :
            core_mods::modules('sample', 'masonry');
        endif;
        wp_reset_postdata();
        //echo '</div>';
    }


}

?>
