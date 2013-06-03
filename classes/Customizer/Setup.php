<?php


/**
 * Setup the theme customizer backgrouns and some defaults
 *
 * @author studio
 */
class Customizer_Setup {

    function __construct($header_img = '', $background_image = '') {

        $bj_site_logo = $header_img;
//        if (!file_exists($header_img))
//            $bj_site_logo = '';
        $bj_theme_header = array(
            'default-image' => $bj_site_logo,
            'random-default' => false,
            'width' => 300,
            'height' => 48,
            'flex-height' => true,
            'flex-width' => true,
            'default-text-color' => '',
            'header-text' => true,
            'uploads' => true,
            'wp-head-callback' => '',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
        );
        add_theme_support('custom-header', $bj_theme_header);


        ;
//        if (!file_exists($bj_background))
//            $bj_background = '';
        $bj_theme_background = array(
            'default-color' => '',
            'default-image' => $background_image,
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => ''
        );
        add_theme_support('custom-background', $bj_theme_background);

        // add_action('customize_register', 'themename_customize_register');
        add_action('admin_menu', array($this, 'custom_admin'));
    }

    public static function factory($header_image = '', $background_image = '') {
        $factory = new Customizer_Setup($header_image, $background_image);
        return $factory;
    }

    public function custom_admin() {
        // add the Customize link to the admin menu
        add_theme_page('Customize', 'Customizer', 'edit_theme_options', 'customize.php');
    }

}
