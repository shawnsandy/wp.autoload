<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Taxonomy
 *
 * @author studio
 */
class Post_Taxonomy {

     //put your code here


    private $hierarchical = true;
    private $show_ui = true;
    private $query_var = true;
    private $show_tagcloud = true;
    private $show_in_nav_menus = true;
    private $rewrite = array('slug' => 'name');
    private $taxonomy_name, $label_name;
    private $post_types = array('post', 'pages'),
            $singular_name = null,
            $show_admin_col = false;

    public function set_label_name($label_name) {
        $this->label_name = $label_name;
        return $this;
    }

    public function set_show_admin_col($show_admin_col) {
        $this->show_admin_col = $show_admin_col;
        return $this;
    }


    public function set_singular_name($singular_name) {
        $this->singular_name = $singular_name;
        return $this;
    }

    public function get_hierarchical() {
        return $this->hierarchical;
    }

    public function set_hierarchical($hierarchical) {
        $this->hierarchical = $hierarchical;
        return $this;
    }

    public function get_show_ui() {
        return $this->show_ui;
        return $this;
    }

    public function set_show_ui($show_ui) {
        $this->show_ui = $show_ui;
    }

    public function get_query_var() {
        return $this->query_var;
    }

    public function set_query_var($query_var) {
        $this->query_var = $query_var;
        return $this;
    }

    public function get_show_tagcloud() {
        return $this->show_tagcloud;
    }

    public function set_show_tagcloud($show_tagcloud) {
        $this->show_tagcloud = $show_tagcloud;
        return $this;
    }

    public function get_show_in_nav_menus() {
        return $this->show_in_nav_menus;
    }

    public function set_show_in_nav_menus($show_in_nav_menus) {
        $this->show_in_nav_menus = $show_in_nav_menus;
        return $this;
    }

    public function get_rewrite() {
        return $this->rewrite;
    }

    public function set_rewrite($rewrite) {
        $this->rewrite = $rewrite;
        return $this;
    }

    public function get_taxonomy_name() {
        return $this->taxonomy_name;
    }

    public function set_taxonomy_name($taxonomy_name) {
        $this->taxonomy_name = $taxonomy_name;
        return $this;
    }

    public function get_post_types() {
        return $this->post_types;
    }

    public function set_post_types($post_types) {
        $this->post_types = $post_types;
        return $this;
    }

    public function get_label_name() {
        return $this->label_name;
    }

    /**
     *
     * @param type $taxonomy_name
     * @param type $label_name
     */
    function __construct() {
//        $this->taxonomy_name = $taxonomy_name;
//        $this->label_name = $label_name;
    }


    public static function factory($taxonomy_name, $label_name = null){

        $factory = new Post_Taxonomy();
        $factory->taxonomy_name = $taxonomy_name;
        $factory->label_name = $label_name;

        return $factory;

    }

    /**
     * register category style taxonomies
     */
    public function register() {
        // Add new taxonomy, make it hierarchical (like categories)
        $name = ucfirst($this->get_taxonomy_name());
        $label = (isset($this->label_name) ? $this->label_name : $this->taxonomy_name);
        $singular = (isset($this->singular_name) ? $this->singular_name : $this->taxonomy_name);
        $labels = array(
            'name' => _x($label, 'taxonomy general name'),
            'singular_name' => _x($singular, 'taxonomy singular name'),
            'search_items' => __('Search ' . $name),
            'all_items' => __('All ' . $label),
            'parent_item' => __('Parent ' . $singular),
            'parent_item_colon' => __('Parent ' . $label . ':'),
            'edit_item' => __('Edit ' . $singular),
            'update_item' => __('Update ' . $singular),
            'add_new_item' => __('Add New ' . $singular),
            'new_item_name' => __('New ' . $singular),
            'menu_name' => __($label),
        );



        register_taxonomy($this->get_taxonomy_name(), $this->get_post_types(), array(
            'hierarchical' => $this->hierarchical,
            'labels' => $labels,
            'show_ui' => $this->get_show_ui(),
            'query_var' => $this->get_query_var(),
            'rewrite' => array('slug' => $this->get_taxonomy_name()),
            'show_tagcloud' => $this->get_show_tagcloud(),
            'show_in_nav_menus' => $this->get_show_in_nav_menus(),
            'show_admin_column' => true,
        ));
    }

    /**
     * create tagged style taxonomy;
     */
    public function tags() {
        $this->set_hierarchical(false);
        $this->register();
    }

    public function init() {
        add_action('init', array(&$this, 'register'), 0);
    }
}
