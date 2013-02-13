<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */


class cwp_orders {

    function __construct() {
        $this->order_post_type();

    }


    public function order_post_type() {
        $order = new cwp_post_type('order');
        $order->set_publicly_queryable(false)
                ->set_exclude_from_search(true)
                ->set_supports(array('title', 'editor', 'comments'))
                ->register();
    }

    public function email_order() {
        global $post;
    }

    public function save_order() {
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action'])) {

            // Do some minor form validation to make sure there is content
            if (isset($_POST['title'])) {
                $title = $_POST['title'].' Order';
            } else {
                echo 'Please enter a title';
            }
            if (isset($_POST['description'])) {
                $description = $_POST['description'];
            } else {
                echo 'Please enter the content';
            }
            $tags = $_POST['post_tags'];

            // Add the content of the form to $post as an array
            $post = array(
                'post_title' => $title,
                'post_content' => $description,
                'post_status' => 'private', // Choose: publish, preview, future, etc.

                'post_type' => 'cwp_order'  // Use a custom post type if you want to
            );
            $post_id = wp_insert_post($post);

        } // end IF
// Do the wp_insert_post action to insert it
        do_action('wp_insert_post', 'wp_insert_post');
    }

    public function order_form() {


    }

}

?>
