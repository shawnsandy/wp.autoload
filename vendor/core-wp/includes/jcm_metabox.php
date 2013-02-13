<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jcm_metabox
 *
 * @author Studio365
 */
class jcm_metabox {
    //put your code here

    function __construct() {
        add_action('init', array('jcm_metabox','be_initialize_cmb_meta_boxes'), 9999);


    }

      public function be_initialize_cmb_meta_boxes() {
            if (!class_exists('cmb_Meta_Box')) {
                require_once( CWP_PATH . '/includes/jaredatch-Custom-Metaboxes/init.php' );
            }
        }

    public static function extract_meta($meta_name,$meta_prefix = 'cwp',$id=null){
        global $post;
        $pid = $post->ID;
       $meta_key = get_post_meta($pid, $meta_name,true);
       if($meta_key AND is(array($meta_key))){
           //work some magic
           foreach($meta_key as $key => $value):

               update_post_meta($pid, "_{$meta_prefix}_{$key}", $value);

           endforeach;
       }

    }


}

?>
