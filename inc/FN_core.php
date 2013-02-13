<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FN
 *
 * @author studio
 */
class FN_core {

    public function __construct() {

    }

    public static function locate_in_vendor($file){
        if(file_exists(WP_CONTENT_DIR.'/vendor/'.$file)):
            return content_url().'/vendor/'.$file;
        endif;
        if(file_exists(PLUGINDIR.'/al-manager/vendor/'.$file)):
            return plugins_url().'/al-manager/vendor/'.$file;
        return;
        endif;
    }

}
