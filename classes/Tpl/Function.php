<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Tpl_Function {

    public function __construct() {

    }

    /**
     * Layout content, displays post created for use in theme(s) layout
     * @param string $option_name
     * @return posr object / boolean
     */
    public static function get_layout_content($option_name) {

        $option = get_theme_mod($option_name);

        if(empty($option)) return FALSE;
        $page = get_post($option);
        if (isset($page) or !empty($page)):
            return $page;
        else :
            return false;
        endif;
        
    }

}

