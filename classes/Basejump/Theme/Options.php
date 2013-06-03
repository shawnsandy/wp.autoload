<?php

/**
 * Description of Options
 *
 * @author studio
 */
class Basejump_Theme_Options {


    public function __construct() {



    }

    public function setup($header_img = '', $background_image = ''){

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


    public function custom_admin() {
        // add the Customize link to the admin menu
        add_theme_page('Customize', 'Customizer', 'edit_theme_options', 'customize.php');
    }

    public static function factory() {

        $factory = new Basejump_Theme_Options();
        return $factory;
    }

    /**
     * Site slugs
     */
    public static function slugs() {


        /** 404 slug used for 404 error page * */
        Customizer_Settings::add_option('title_tagline', 'site_slug', 'Site Slug', '404 Error! Well, this is Embrassing...')->customizer();

        /** 404 slug used for 404 error page * */
        Customizer_Settings::add_option('title_tagline', '404_slug', '404 Slug', '404 Error! Well, this is Embrassing...')->customizer();


        /** Search page slug * */
        Customizer_Settings::add_option('title_tagline', 'search_slug', 'Search Slug', 'Search help...')->customizer();


        /** Footer Slug * */
        Customizer_Settings::add_option('title_tagline', 'footer_slug', 'Footer Slug / Credits', 'Footer slug...')->customizer();



        /** Copyright slug/text * */
        Customizer_Settings::add_option('title_tagline', 'copyright_slug', 'Copyright Slug', 'Copyright slug...')->customizer();


//bjc_branding::factory();
        /** Hide or show copyright slug * */
        Customizer_Settings::add_option('title_tagline', 'hide-copyright_slug', 'Hide Copyright Slug', '')->set_control_type('checkbox')->customizer();


    }

    /**
     * Site contact info
     */
    public static function contacts(){


        $section = Customizer_Settings::add_section('bj_contacts', 'Contact info', 'Setup the site contact info');

        Customizer_Settings::add_option($section, 'contact _org', 'Organization name', '')->customizer();

        Customizer_Settings::add_option($section, 'contact_name', 'Contact name', '')->customizer();

        Customizer_Settings::add_option($section, 'contact_email', 'Email', '')->customizer();

        Customizer_Settings::add_option($section, 'contact_address', 'Address', '')->customizer();

        Customizer_Settings::add_option($section, 'contact_city', 'City', '')->customizer();

        Customizer_Settings::add_option($section, 'contact_state', 'State', '')->customizer();

        Customizer_Settings::add_option($section, 'contact_zip', 'Zip Code', '')->customizer();

    }

    /**
     * Theme settings
     */
    public static function settings(){
        $settings = Customizer_Settings::add_section('bj_settings', 'Settings', 'Theme settings',5);

        Customizer_Settings::add_option($settings, 'site_offline', 'Put Site Offline')->set_control_type('checkbox')->customizer();

        Customizer_Settings::add_option($settings, 'site_logo', 'Site Logo')->customizer('add_image_control');

    }

}