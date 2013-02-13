<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cwp_mets_shop
 *
 * @author Studio365
 */
class cwp_meta_shop {

    //put your code here

    private $post_types;

    public function set_post_types($post_types) {
        $this->post_types = $post_types;
    }

    public function get_post_types() {
        return $this->post_types;
    }

    public function __construct($post_types=array('post')) {
        $this->set_post_types($post_types);
    }


    /*
     * *****************************************MetaBoxes***********************
     */

    /**
     * Gives a Description of the product additionals images, details etc
     * @param type $id
     * @param type $template_name
     * @return string
     */
    public function product($id='_ms_product', $title="Product Description", $template_name = 'ms_products') {
        $mp_args = array(
            'id' => $id,
            'title' => $title,
            'types' => cwp_meta_shop::get_post_types(), // added only for pages and to custom post type "events"
            'context' => 'normal', // same as above, defaults to "normal" (‘normal’, ‘advanced’, or ‘side’)
            'priority' => 'high', // same as above, defaults to "high" (‘high’ or ‘low’)
            'mode' => WPALCHEMY_MODE_ARRAY, // defaults to WPALCHEMY_MODE_ARRAY / WPALCHEMY_MODE_EXTRACT
            'template' => get_stylesheet_directory() . "/tpl/metashop/{$template_name}.php",
            'init_action' => null, // runs only when metabox is present - defaults to NULL
            //'lock' => WPALCHEMY_LOCK_TOP, // defaults to NULL ; WPALCHEMY_LOCK_XXX  (“top”, “bottom”, “before_post_title”, “after_post_title”)
            'prefix' => '_metaproduct_', // defaults to NULL
            'head_action' => array('cwp_metabox', 'print_style'), //run your head action
            'save_filter' => null, //
            'foot_action' => null,
            'autosave' => null
        );
        return $mp_args;
    }

    /**
     * Product price, discounts, price, instock
     * @param type $id
     * @param type $template
     * @return string
     */
    public function price($id='_ms_price', $title="Price",  $template="ms_price") {
        $mp_args = array(
            'id' => $id,
            'title' => $title,
            'types' => $this->get_post_types(), // added only for pages and to custom post type "events"
            'context' => 'side', // same as above, defaults to "normal" (‘normal’, ‘advanced’, or ‘side’)
            'priority' => 'high', // same as above, defaults to "high" (‘high’ or ‘low’)
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY / WPALCHEMY_MODE_EXTRACT
            'template' => get_stylesheet_directory() . "/tpl/metashop/{$template}.php",
            'init_action' => null, // runs only when metabox is present - defaults to NULL
            'lock' => WPALCHEMY_LOCK_TOP, // defaults to NULL ; WPALCHEMY_LOCK_XXX  (“top”, “bottom”, “before_post_title”, “after_post_title”)
            'prefix' => '_metaprice_', // defaults to NULL
            'head_action' => array('cwp_metabox','print_style'), //run your head action
            'save_filter' => null, //
            'foot_action' => null,
            'autosave' => null
        );
        return $mp_args;
    }

    public function options($id='_ms_price', $title="Product Options", $template="ms_options") {
        $mp_args = array(
            'id' => $id,
            'title' => $title,
            'types' => $this->get_post_types(), // added only for pages and to custom post type "events"
            'context' => 'side', // same as above, defaults to "normal" (‘normal’, ‘advanced’, or ‘side’)
            'priority' => 'high', // same as above, defaults to "high" (‘high’ or ‘low’)
            'mode' => WPALCHEMY_MODE_ARRAY, // defaults to WPALCHEMY_MODE_ARRAY / WPALCHEMY_MODE_EXTRACT
            'template' => get_stylesheet_directory() . "/tpl/metashop/{$template}.php",
            'init_action' => null, // runs only when metabox is present - defaults to NULL
            'lock' => WPALCHEMY_LOCK_TOP, // defaults to NULL ; WPALCHEMY_LOCK_XXX  (“top”, “bottom”, “before_post_title”, “after_post_title”)
            'prefix' => '_metaopt_', // defaults to NULL
            'head_action' => array('cwp_metabox', 'print_style'), //run your head action
            'save_filter' => null, //
            'foot_action' => null,
            'autosave' => null
        );
        return $mp_args;
    }

    /**
     * ********************************TAXONOMY*********************************
     */

    public function categories(){
        $cat = new cwp_taxonomy('product_category','Product Department');
        $cat->set_post_types($this->get_post_types());
        $cat->register();
    }

    public function tags(){
        $tags = new cwp_taxonomy('product_tag','Product Tag');
        $tags->set_post_types($this->get_post_types());
        $tags->tags();
    }

}
