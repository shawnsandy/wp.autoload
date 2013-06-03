<?php

/**
 * Description of Setup
 *
 * @author studio
 */
class Theme_Setup {

   function __construct() {

    }

    /**
     *
     */
    public static function factory() {
        $factory = new Theme_Setup();
        return $factory;
    }

    private $post_titles = array('Home', 'About', 'Contact Us'),
            $post_type = 'page',
            $post_status = 'publish',
            $home_page = null,
            $post_content = "<p><strong>Please go to your admin and edit / modify this page.</strong></p> [fixie element='article']";

    public function get_post_content() {
        return $this->post_content;
    }

    public function set_post_content($post_content) {
        $this->post_content = $post_content;
        return $this;
    }

    public function set_post_title($post_titles) {
        $this->post_titles = $post_titles;
        return $this;
    }

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    public function set_post_status($post_status) {
        $this->post_status = $post_status;
        return $this;
    }

    public function set_home_page($home_page) {
        $this->home_page = $home_page;
        return $this;
    }

    public function get_post_titles() {
        return $this->post_titles;
    }

    public function get_post_type() {
        return $this->post_type;
    }

    public function get_post_status() {
        return $this->post_status;
    }

    public function get_home_page() {
        return $this->home_page;
    }

}

