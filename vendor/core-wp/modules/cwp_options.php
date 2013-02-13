<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cwp_options
 *
 * @author Studio365
 */
class cwp_options {
    //put your code here

    public function __construct() {
        if(current_user_can('manage_ui_options') OR current_user_can('manage_options')):
        $this->post_types();
        //$this->meta_boxes();
        endif;
        //$this->add_meta_box();
        $this->add_roles();

    }

    public function post_types(){
        // cwp_theme_option
        $type = new cwp_post_type('theme_option');
        $type->set_publicly_queryable(false)
                ->set_public(true)
                ->set_exclude_from_search(true)
                ->set_menu_title("SiteOptions")
                ->set_hierarchical(true)
                ->set_menu_postion(65)
                ->set_supports(array('title','excerpt','thumbnail'))
                ->register();
    }

    public function add_roles(){
        global $wp_roles;
        $wp_roles->add_role('uioptions', 'UI Admin', array('manage_ui_options','delete_ui_options'));
        //$wp_roles->add_cap('administrator','manage_ui_options');
        $wp_roles->add_cap('manage_options','manage_ui_options');
    }

    /***********************************************************************************/


    public function add_meta_box() {
        add_action("admin_init", array(&$this,"meta"));
        add_action('save_post', array(&$this,'save_meta'));
        return $this;
    }

    public function meta() {
        //add_meta_box($id, $title, $callback, $page, $context, $priority)
        add_meta_box("option-ui-type", "Options Type", array(&$this,"meta_options"), "cwp_ui", "side", "low");
    }

    public function meta_options() {
        global $post;
        $meta = get_post_meta($post->ID, 'opt_ui_type');
        if(isset($this->meta_form_url) AND file_exists($this->meta_form_url)):
            include_once $this->meta_form_url;
            else :
           ?>
        <label>Types</label>
        <select name="ui_option" style="width: 100%; margin-top: 10px">
            <option><?php $meta; ?></option>
            <option value="site">Site</option>
            <option value="styles">Style</option>
            <option value=""></option>
        </select>
        <?php
        endif;
    }

    public function save_meta($value=array()) {
        global $post;
        $data = $_POST['up_option'];
        update_post_meta( $post->ID, 'cwp_ui_option', $data );
    }



}


