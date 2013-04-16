<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomTypes
 *
 * @author studio
 */
class Post_CustomTypes {
    /*
     * post vars
     */

    //Class variables
    private $post_type_name;
    private $publicly_queryable = true;
    private $menu_icon = null;
    private $public = true;
    private $show_ui = true;
    private $show_in_menu = true;
    private $query_var = true;
    private $rewrite = true;
    private $capabilities = null;
    private $capability_type = null;
    private $has_archive = true;
    private $hierarchical = false;
    private $menu_postion = 5;
    private $supports = array('title', 'editor', 'author', 'post-formats', 'thumbnail');
    private $help_tpl;
    private $exclude_from_search = false;
    private $menu_title;
    private $map_meta_cap = null,
            $menu_label = null,
            $post_formats = array(),
            $show_in_nav_menus = true,
            $taxonomies = array('category', 'post_tag'),
            /** create the labels array() */
            $display_labels = null;

    public function set_display_labels($labels) {
        $this->display_labels = $labels;
        return $this;
    }

    public function set_locallization_domain($locallization_domain) {
        $this->locallization_domain = $locallization_domain;
        return $this;
    }

    public function set_capabilities($capabilities) {
        $this->capabilities = $capabilities;
        return $this;
    }

    public function set_show_in_nav_menus($show_in_nav_menus) {
        $this->show_in_nav_menus = $show_in_nav_menus;
        return $this;
    }

    public function set_taxonomies($taxonomies) {
        $this->taxonomies = $taxonomies;
        return $this;
    }

    /**
     *
     * @param type $post_formats
     * @return cwp_post_type 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'
     */
    public function set_post_formats($post_formats = array('gallery', 'image')) {
        $this->post_formats = $post_formats;
        return $this;
    }

    public function get_menu_label() {
        return $this->menu_label;
    }

    public function set_menu_label($label) {
        $this->menu_label = $label;
        return $this;
    }

    public function get_map_meta_cap() {
        return $this->map_meta_cap;
    }

    public function set_map_meta_cap($map_meta_cap) {
        $this->map_meta_cap = $map_meta_cap;
        return $this;
    }

    public function get_menu_title() {
        return $this->menu_title;
    }

    public function set_menu_title($menu_title) {
        $this->menu_title = $menu_title;
        return $this;
    }

    public function get_exclude_from_search() {
        return $this->exclude_from_search;
    }

    public function set_exclude_from_search($exclude_from_search) {
        $this->exclude_from_search = $exclude_from_search;
        return $this;
    }

    public function get_post_type_name() {
        return $this->post_type_name;
    }

    public function set_post_type_name($post_type_name) {
        $this->post_type_name = $post_type_name;
        return $this;
    }

    public function get_menu_icon() {
        return $this->menu_icon;
    }

    public function set_menu_icon($menu_icon) {
        $this->menu_icon = $menu_icon;
        return $this;
    }

    public function get_public() {
        return $this->public;
    }

    public function set_public($public) {
        $this->public = $public;
        return $this;
    }

    public function get_show_ui() {
        return $this->show_ui;
    }

    public function set_show_ui($show_ui) {
        $this->show_ui = $show_ui;
        return $this;
    }

    public function get_show_in_menu() {
        return $this->show_in_menu;
    }

    public function set_show_in_menu($show_in_menu) {
        $this->show_in_menu = $show_in_menu;
        return $this;
    }

    public function get_query_var() {
        return $this->query_var;
    }

    public function set_query_var($query_var) {
        $this->query_var = $query_var;
        return $this;
    }

    public function get_rewrite() {
        return $this->rewrite;
    }

    public function set_rewrite($rewrite) {
        $this->rewrite = $rewrite;
        return $this;
    }

    public function get_capability_type() {
        return $this->capability_type;
    }

    public function set_capability_type($capability_type) {
        $this->capability_type = $capability_type;
        return $this;
    }

    public function get_has_archive() {
        return $this->has_archive;
    }

    public function set_has_archive($has_archive) {
        $this->has_archive = $has_archive;
        return $this;
    }

    public function get_hierarchical() {
        return $this->hierarchical;
    }

    public function get_capabilities() {
        return $this->capabilities;
    }

    /**
     * Whether the post type is hierarchical. Allows Parent to be specified.
     * @param type $hieracrchical false
     */
    public function set_hierarchical($hieracrchical) {
        $this->hierarchical = $hieracrchical;
        return $this;
    }

    public function get_menu_postion() {
        return $this->menu_postion;
    }

    public function set_menu_postion($menu_postion) {
        $this->menu_postion = $menu_postion;
        return $this;
    }

    public function get_supports() {
        return $this->supports;
    }

    /**
     * 'title'
     * 'editor' (content)
     * 'author'
     * 'thumbnail' (featured image, current theme must also support post-thumbnails)
     * 'excerpt'
     * 'trackbacks'
     * 'custom-fields'
     * 'comments' (also will see comment count balloon on edit screen)
     * 'revisions' (will store revisions)
     * 'page-attributes' (menu order, hierarchical must be true to show Parent option)
     * 'post-formats' add post formats, see Post Formats
     * @param type $supports array
     */
    public function set_supports($supports = array()) {
        $this->supports = $supports;
        return $this;
    }

    public function get_publicly_queryable() {
        return $this->publicly_queryable;
    }

    public function set_publicly_queryable($publicly_queryable) {
        $this->publicly_queryable = $publicly_queryable;
        return $this;
    }

    public function get_help_tpl() {
        return $this->help_tpl;
    }

    public function set_help_tpl($help_tpl) {
        $this->help_tpl = $help_tpl;
        return $this;
    }

    /**
     *
     * 'labels' => $labels,
     * 'public' => true,
     * 'publicly_queryable' => true,
     * 'show_ui' => true,
     * 'show_in_menu' => true,
     * 'query_var' => true,
     * 'rewrite' => true,
     * 'capability_type' => 'post',
     * 'has_archive' => true,
     * 'hierarchical' => false,
     * 'menu_position' => null,
     * 'supports' => array('title','editor','author','thumbnail','excerpt','comments')
     * @param type $post_type_name post type name
     *
     */
    public function __construct($post_type_name = 'article') {
        //$this->post_type_name = "cwp_{$name}";
        $this->set_post_type_name($post_type_name);
        $this->set_menu_title(ucfirst($post_type_name));
        $this->query_var = $post_type_name.'_item';
        $this->rewrite = array('slug' => $post_type_name);
        //$this->menu_label = ucfirst($post_type_name);
        return $this;
    }

    public function category_tags_metabox() {
       // add_action('init', array($this, '_category_tags_metabox'));
    }

    public function _category_tags_metabox() {
        register_taxonomy_for_object_type('category', $this->post_type_name);
        register_taxonomy_for_object_type('post_tag', $this->post_type_name);
    }


    /**
     *
     * @param string $post_type_name post type name
     * @return \Post_CustomTypes
     */
    public static function factory($post_type_name){
        $factory = new Post_CustomTypes($post_type_name);
        return $factory;
    }

    /**
     *
     * @param string $menu_title the Menu / Items title
     * @param string $supports - post type suppoer, title, editor, thumbnail
     * @param string $wp_taxonomies - add support for wordpress default categories and tags meta box (defaults true)
     */
    public function register_post_type($menu_title,$supports= NULL,$wp_taxonomies = TRUE){

        $this->menu_title = $menu_title;

        $this->menu_label = $menu_title;

        //$this->menu_postion = $menu_position;

        if(isset($supports))
            $this->supports = $supports ;

        if($wp_taxonomies)
        $this->category_tags_metabox();

        $this->register();

    }

    /**
     * register you post type
     */
    public function register() {
        /**
         * custom post type template
         * http://codex.wordpress.org/Function_Reference/register_post_type
         */
        $name = ($this->menu_label ? ucfirst($this->menu_label) : ucfirst($this->menu_title));
        $rewrite = $this->get_rewrite() ? $this->get_rewrite() : $this->get_label();

        /* Localization just should not happen here - change this to a label array variable
         * left up to theme or plugin as it should
         */

        if (!isset($this->display_labels)):
            $labels['name'] = $name .' Items' ;
            $labels['singular_name'] = $name . ' Item';
            $labels['menu_name'] = $name;
            $labels['name_admin_bar'] = $name . ' Item';
            $labels['add_new'] = 'Add New ' . $name .' Item';
            $labels['add_new_item'] = 'Add New ' . $name . ' Item';
            $labels['edit_item'] = 'Edit ' . $name . ' Item';
            $labels['new_item'] = 'Add New ' . $name . ' Item';
            $labels['view_item'] = 'View ' . $name;
            $labels['search_items'] = 'Search ' . $name . ' Items';
            $labels['not_found'] = 'No ' . $name . ' Items Found';
            $labels['not_found_in_trash'] = 'No ' . $name . ' Items Found in trash';
            $labels['all_items'] = $name . ' Items';
            $this->display_labels = $labels;
        endif;

        $args = array();
        $args['labels'] = $this->display_labels;
        $args['public'] = $this->public;
        $args['pulicly_queryable'] = $this->publicly_queryable;
        $args['show_ui'] = $this->show_ui;
        $args['show_in_menu'] = $this->show_in_menu;
        $args['query_var'] = $this->query_var;
        $args['rewrite'] = $this->rewrite;
        $args['has_archive'] = $this->has_archive;
        $args['hierarchical'] = $this->hierarchical;
        $args['menu_position'] = $this->menu_postion;
        $args['show_in_menu'] = $this->show_in_menu;
        $args['show_in_nav_menus'] = $this->show_in_nav_menus;
        $args['supports'] = array('title', 'editor', 'author', 'thumbnail');
        $args['taxonomies'] = $this->taxonomies;
        $args['meta_cap'] = $this->map_meta_cap;
        if(isset($this->menu_icon))
           $args['menu_icon'] = $this->menu_icon;

        if(isset($this->capability_type))
        $capability_type = $this->capability_type;
        //use the default by setting the capabilities using a boolean true;
        if (!isset($this->capabilities) && isset($this->capability_type)):
            //******************************************************************
            $caps['edit_post'] = "edit_{$capability_type}";
            $caps['read_post'] = "read_{$capability_type}";
            $caps['delete_post'] = "delete_{$capability_type}";
            //******************************************************************
            $caps['edit_posts'] = "edit_{$capability_type}s";
            $caps['edit_others_posts'] = "manage_{$capability_type}s";
            $caps['publish_posts'] = "edit_{$capability_type}s";
            $caps['read_private_posts'] = "edit_{$capability_type}s";
            //******************************************************************
            $caps['delete_posts'] = "edit_{$capability_type}s";
            $caps['delete_private_posts'] = "edit_{$capability_type}s";
            $caps['delete_published_posts'] = "edit_{$capability_type}s";
            $caps['delete_others_posts'] = "manage_{$capability_type}s";
            $caps['edit_private_posts'] = "edit_{$capability_type}s";
            $caps['edit_published_posts'] = "edit_{$capability_type}s";

            $args['capabilities'] = $caps;
        endif;

        register_post_type($this->post_type_name, $args);
        //$this->set_administrator($this->get_post_type_name());

        $this->flush_rewrite($this->get_post_type_name());

    }

    public static function flush_rewrite($post_type){

        $types = get_posts(array('post_type' => $post_type));
        if(post_type_exists($post_type) && empty($types)) flush_rewrite_rules ();

    }


    /**
     *
     * @param type $post_type_name
     */

    public static function set_administrator($post_type_name) {
        /* Get the administrator role. */

        $role = & get_role('administrator');

        /* If the administrator role exists, add required capabilities for the plugin. */
        if (!empty($role)) {
            $role->add_cap("manage_{$post_type_name}s");
            $role->add_cap("edit_{$post_type_name}s");
        }
    }

    /**
     * *************************POST FORMATS*****************************
     *
     */

    /**
     * sets custom post type and this post formats
     * @param type $formats - 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'
     */
    public function post_formats() {
        if (!empty($this->post_formats) AND is_array($this->post_formats)):
            $screen = get_current_screen();
            if ($screen->post_type == $this->get_post_type_name()):
                //remove_post_type_support( 'post', 'post-formats' );
                add_theme_support('post-formats', $this->post_formats);
            endif;
        endif;
        return $this;
    }

  /**
     * ************************MESSAGE*****************************************
     */
}

