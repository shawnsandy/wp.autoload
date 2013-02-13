<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 * @link http://shawnsandy.com
 */
class custom_ui_options {

    private $pages = array('cwp_custom_options'),
            $context = 'normal',
            $piority = 'high',
            $prefix = '_cwpt_',
            $instructions;

    /**
     * Set your post-types or pages
     * @param type $post_types
     */
    public function set_post_types($post_types) {
        $this->pages = $post_types;
        return $this;
    }

    //static var instance
    public static $instance;

    /**
     *
     * @return type
     */
    public static function instance() {
        if (!is_object(self::$instance)):
            $class = __CLASS__;
            self::$instance = new custom_ui_options();
        endif;
        return self::$instance;
    }

    private function __construct() {

    }

    public function theme_options() {
        if (!class_exists('RW_Meta_Box'))
            return;

        $prefix = $this->prefix;
        $meta_boxes = array();

        //$post_types = get_post_types();
        // 1st meta box
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'custom_options',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Custom Theme Options',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => $this->pages,
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => $this->context,
            // Order of meta box: high (default), low; optional
            'piority' => $this->piority,
            'fields' => array(
                array(
                    'name' => 'Theme Headline Copy / Slug',
                    'desc' => 'Enter you theme home-page headline copy',
                    'id' => "{$prefix}headline_copy",
                    'type' => 'textarea',
                    'cols' => "40",
                    'rows' => "4"
                ),
                array(
                    'name' => 'Home page content / copy',
                    'desc' => 'Content / copy for your home page feature',
                    'id' => "{$prefix}main_copy",
                    'type' => 'wysiwyg',
                    'std' => 'This is your custom home page content, please edit from your UI.Options admin menu',
                ),
                array(
                    'name' => 'Footer copy',
                    'desc' => 'Footer options copy',
                    'id' => "{$prefix}footer_copy",
                    'type' => 'textarea',
                    'std' => 'This is your custom Footer copy, please edit from your UI.Options admin menu',
                    'cols' => "40",
                    'rows' => "8"
                ),
                array(
                    'name' => 'Subscribe copy',
                    'desc' => 'Subscribe options copy',
                    'id' => "{$prefix}subscribe_copy",
                    'type' => 'textarea',
                    'std' => 'This is your custom subscribe, please edit from your UI.Options admin menu',
                    'cols' => "40",
                    'rows' => "8"
                ),
                array(
                    'name' => 'Copy right info',
                    'desc' => 'This is appended to your copyright info in the footer',
                    'id' => "{$prefix}contact_copy",
                    'type' => 'textarea',
                    'std' => 'This is your custom copytight info, please edit from your UI.Options admin menu',
                    'cols' => "40",
                    'rows' => "8"
                ),
                array(
                    'name' => 'Contact us copy',
                    'desc' => 'This is used for the contact us copy',
                    'id' => "{$prefix}contact_copy",
                    'type' => 'textarea',
                    'std' => 'This is your custom contact us copy, please edit from your UI.Options admin menu',
                    'cols' => "40",
                    'rows' => "8"
                )
            // Other fields go here
            )
        );
        // Other meta boxes go here

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
        return $this;
    }

    /**
     *
     * @return \custom_ui_options
     */
    public function offline_options() {

        $prefix = $this->prefix;
        if (!class_exists('RW_Meta_Box'))
            return;

        $meta_boxes = array();

        // 1st meta box
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'custom_offline_options',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Offline Page Options',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => $this->pages,
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => $this->context,
            // Order of meta box: high (default), low; optional
            'fields' => array(
                array(
                    'name' => 'Theme Offline Copy / Slug',
                    'desc' => 'Enter you theme home-page headline copy',
                    'id' => "{$this->prefix}offline_slug",
                    'type' => 'textarea',
                    'std' => 'hello',
                    'cols' => "40",
                    'rows' => "4"
                ),
                array(
                    'name' => 'Home page content / copy',
                    'desc' => 'Content / copy for your offline page feature',
                    'id' => "{$this->prefix}offline_copy",
                    'type' => 'wysiwyg',
                    'std' => 'This is your custom home page content, please edit from your UI.Options admin menu',
                ),
            // Other fields go here
            )
        );
        // Other meta boxes go here

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
        return $this;
    }

    public function custom_404_options() {
        $prefix = $this->prefix;

        if (!class_exists('RW_Meta_Box'))
            return;

        $meta_boxes = array();

        // 1st meta box
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'custom_404_options',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => '404 Page Options',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => $this->pages,
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => $this->context,
            // Order of meta box: high (default), low; optional
            'fields' => array(
                array(
                    'name' => 'Theme 404 page Copy / Slug',
                    'desc' => 'Enter you theme 404 page headline copy',
                    'id' => "{$this->prefix}404_slug",
                    'type' => 'textarea',
                    'std' => 'hello',
                    'cols' => "40",
                    'rows' => "4"
                ),
                array(
                    'name' => 'Home page content / copy',
                    'desc' => 'Content / copy for your 404 page feature',
                    'id' => "{$this->prefix}404_copy",
                    'type' => 'wysiwyg',
                    'std' => 'This is your custom home page content, please edit from your UI.Options admin menu',
                )
            // Other fields go here
            )
        );
        // Other meta boxes go here

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
        return $this;
    }

    public function search_options() {

        $prefix = $this->prefix;
        if (!class_exists('RW_Meta_Box'))
            return;

        $meta_boxes = array();

        // 1st meta box
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'custom_search_options',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Search Page Options',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => $this->pages,
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => $this->context,
            // Order of meta box: high (default), low; optional
            'fields' => array(
                array(
                    'name' => 'Theme search page Copy / Slug',
                    'desc' => 'Enter you theme Search page headline copy',
                    'id' => "{$this->prefix}search_slug",
                    'type' => 'textarea',
                    'std' => 'hello',
                    'cols' => "40",
                    'rows' => "4"
                ),
                array(
                    'name' => 'Search page content / copy',
                    'desc' => 'Content / copy for your Search page feature',
                    'id' => "{$this->prefix}search_copy",
                    'type' => 'wysiwyg',
                    'std' => 'This is your custom search page content please edit from your UI.Options admin menu',
                ),
                // CHECKBOX LIST
                array(
                    'name' => 'Default search page Widgets',
                    'id' => "{$this->prefix}404_elements",
                    'type' => 'checkbox_list',
                    // Options of checkboxes, in format 'key' => 'value'
                    'options' => array(
                        'search' => 'Search',
                        'recent_post' => 'Recent Post',
                        'archives' => 'Archives',
                        'pages' => 'Pages',
                    ),
                    'desc' => 'What do you do in free time?'
                )
            )
        );
        // Other meta boxes go here

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
        return $this;
    }

    /*     * **************** Instructions metabox *********************************** */

    public function instructions($instructions = 'Instructions...') {

        $this->instructions = $instructions;
        add_action('add_meta_boxes', array($this, 'add_info'));

        return $this;
    }

    public function add_info() {
        //add callback args
        $args = array('description' => $this->instructions);
        add_meta_box('instructions-id', 'Instructions', array($this, 'info_meta_box'), 'cwp_custom_options', 'normal', 'high', $args);
        remove_meta_box('postimagediv', 'cwp_custom_options', 'side');
    }

    public function info_meta_box($post, $metabox) {
        echo "<p>";
        echo $metabox['args']['description'];
        echo "</p>";
    }

    /*     * ********************** Features images **************************** */

    public function theme_images() {

        $theme_logo = new MultiPostThumbnails(array(
                    'label' => 'Set Site Logo',
                    'id' => 'theme-logo',
                    'post_type' => 'cwp_custom_options',
                    'context' => 'side',
                    'priority' => 'low',
                        )
        );

        $theme_404 = new MultiPostThumbnails(array(
                    'label' => 'Set 404 Image',
                    'id' => '404-image',
                    'post_type' => 'cwp_custom_options',
                    'context' => 'side',
                    'priority' => 'low',
                        )
        );

        $theme_offline = new MultiPostThumbnails(array(
                    'label' => 'Set Offline image',
                    'id' => 'offline-image',
                    'post_type' => 'cwp_custom_options',
                    'context' => 'side',
                    'priority' => 'low',
                        )
        );

    }

}

