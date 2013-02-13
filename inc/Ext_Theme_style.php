<?php

// Prevent loading this file directly
defined('ABSPATH') || exit;

/**
 * Description of Ext_Theme_style
 *
 * @author studio
 */

//if ( $wp_customize->is_preview() && ! is_admin() )
//	add_action( 'wp_footer', 'themename_customize_preview', 21);

//generate_options_css($defaults);

class Ext_style_options {

    private $css_dir = '/libray/css/';

    public function __construct() {
        add_action('wp_print_styles', 'themename_enqueue_css');
    }

    public function factory() {
        return $factory = new Ext_style_options();
    }

    public function generate_options_css($newdata) {

        $data = $newdata;
        $css_dir = get_stylesheet_directory() . $this->css_dir; // Shorten code, save 1 call
        ob_start(); // Capture all output (output buffering)

        require($css_dir . 'styles.php'); // Generate CSS

        $css = ob_get_clean(); // Get generated CSS (output buffering)
        file_put_contents($css_dir . 'options.css', $css, LOCK_EX); // Save it
    }

    function themename_enqueue_css() {
        wp_register_style('options', get_template_directory_uri() . $this->css_dir . '/options.css', 'style');
        wp_enqueue_style('options');
    }

}
