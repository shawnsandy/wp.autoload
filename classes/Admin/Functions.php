<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Functions
 *
 * @author studio
 */
class Admin_Functions {

    public function __construct() {

    }

    public static function post_list_thumbs() {
        // for posts
        add_filter('manage_posts_columns', '_fb_AddThumbColumn');
        add_action('manage_posts_custom_column', '_fb_AddThumbValue', 10, 2);

        // for pages
        add_filter('manage_pages_columns', '_fb_AddThumbColumn');
        add_action('manage_pages_custom_column', '_fb_AddThumbValue', 10, 2);
    }

    public static function post_column_id() {
        add_filter('manage_posts_columns', 'posts_columns_id', 5);
        add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
        add_filter('manage_pages_columns', 'posts_columns_id', 5);
        add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);
    }

}



