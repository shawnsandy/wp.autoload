<?php
/**
 * The file description. *
 * @package BJ
 * @since BJ 1.0
 */
// Prevent loading this file directly
defined('ABSPATH') || exit;

class bj_customizer {

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
        add_action('admin_menu', array($this, 'bj_theme_custom_admin'));
        
    }

    /**
     *
     * @param type $header_img
     * @param type $bj_img
     * @return type
     */
    public static function factory($header_img = '', $bj_img = '') {
        return $factory = new bj_customizer($header_img, $bj_img);
    }

    public function default_settings() {

    }

    public function bj_theme_custom_admin() {
        // add the Customize link to the admin menu
        add_theme_page('Customize', 'Theme Customizer', 'edit_theme_options', 'customize.php');
    }

}

class bjc_branding {

    function __construct() {

        add_action('customize_register', array($this, 'customize'));
    }

    public static function factory() {
        return $factory = new bjc_branding();
    }

    public function customize($wp_customize) {
        $wp_customize->add_section('bj_branding_section', array(
            'title' => 'Social Media',
            'priority' => 100,
            'description' => __('This section takes care of you Site Logo and online branding, fan-page, twitter url, google plus url etc', 'bj')
        ));


        $wp_customize->add_setting('bjc_logo', array(
            'default' => '',
        ));


        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bjc_logo', array(
                    'label' => 'Organization(s) Logo ',
                    'section' => 'header_image',
                    'settings' => 'bjc_logo'
                )));


        $wp_customize->add_setting('bjc_twitter_username', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_twitter_username', array(
            'label' => 'Twitter Username',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));


        $wp_customize->add_setting('bjc_fanpage_url', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_fanpage_url', array(
            'label' => 'Facdbook Fan page',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));


        $wp_customize->add_setting('bjc_gplus_url', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_gplus_url', array(
            'label' => 'Google Plus Url',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));


        $wp_customize->add_setting('bjc_gplus_page', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_gplus_page', array(
            'label' => 'Google Plus Page URL',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));


        $wp_customize->add_setting('bjc_feedburner_url', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_feedburner_url', array(
            'label' => 'Feedburner Url',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));
    }

}

class bjc_contact {

    public function __construct() {
        add_action('customize_register', array($this, 'customize'));
    }

    public static function factory() {
        return $factory = new bjc_contact();
    }

    public function customize($customize) {

        $customize->add_section('bjc_contact', array(
            'title' => 'Site Contact',
            'priority' => 110,
            'description' => __('Default contact info', 'basejump')
        ));




        $customize->add_setting('bjc_contact_message', array(
            'default' => __("Please don't hesitate to contact us for more info!", 'basejump'),
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_contact_message', array(
                    'label' => 'Contact Message / Copy',
                    'section' => 'bjc_contact',
                    'settings' => 'bjc_contact_message',
                    'type' => 'bjc_wp_editor'
                )));


        $customize->add_setting('bjc_org_name', array(
            'default' => 'Orgnization Name',
        ));



        $customize->add_control('bjc_org_name', array(
            'label' => 'Organization Name',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_name', array(
            'default' => '',
        ));

        $customize->add_control('bjc_contact_name', array(
            'label' => 'Contact Name',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_email', array(
            'default' => 'email@yourdomain.com',
        ));

        $customize->add_control('bjc_contact_email', array(
            'label' => 'Contact Email',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_tel', array(
            'default' => '',
        ));

        $customize->add_control('bjc_contact_tel', array(
            'label' => 'Telephone',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_address', array(
            'default' => 'Address',
        ));

        $customize->add_control('bjc_contact_address', array(
            'label' => 'Street Address',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_city', array(
            'default' => 'City',
        ));

        $customize->add_control('bjc_contact_city', array(
            'label' => 'City',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_state', array(
            'default' => 'XX',
        ));

        $customize->add_control('bjc_contact_state', array(
            'label' => 'State',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_zip', array(
            'default' => '00000',
        ));

        $customize->add_control('bjc_contact_zip', array(
            'label' => 'Zip Code',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));
    }

}

class bjc_copy_editor {

    public function __construct() {
        add_action('customize_register', array($this, 'customize'));
    }

    public static function factory() {
        return $factory = new bjc_copy_editor();
    }

    public function customize($customize) {

        $customize->add_section('bjc_slug', array(
            'title' => 'Theme Copy',
            'priority' => 105,
            'description' => "Customize the theme(s) content/copy/slug"
        ));

        $customize->add_setting('bjc_site_slug', array(
            'default' => 'Add your super cool SiteSlug or as the guys in marketing call it... Your elevator pitch!',
                //'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_site_slug', array(
                    'label' => 'Site Slug',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_site_slug'
                )));

        /*         * ********* */
        $customize->add_setting('bjc_404_slug', array(
            'default' => 'It looks like nothing was found at this location. Maybe try one of the links below or a search?',
                //'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_404_slug', array(
                    'label' => '404 Page Slug',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_404_slug'
                )));

        /*         * ********* */
        $customize->add_setting('bjc_search_slug', array(
            'default' => 'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
                //'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_search_slug', array(
                    'label' => 'Search Not found',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_search_slug'
                )));

        /*         * ********* */

        $customize->add_setting('bjc_footer_slug', array(
            'default' => 'Here is your footer sulg ',
                //'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_footer_slug', array(
                    'label' => 'Footer Copy / Slug',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_footer_slug',
                    'type' => 'bjc_wp_editor'
                )));

        $customize->add_setting('bjc_copyright_slug', array(
            'default' => 'Here is your copyright info',
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_copyright_slug', array(
                    'label' => 'Copyright Info',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_copyright_slug',
                    'type' => 'bjc_wp_editor'
                )));

        $customize->add_setting('bjc_enable_copyinfo', array(
            'default' => '',
                //'type' => 'option'
        ));

        $customize->add_control('bjc_enable_copyinfo', array(
            'label' => 'Hide Copyright Info',
            'section' => 'bjc_slug',
            'type' => 'checkbox'
        ));

        $customize->add_setting('bjc_copyright_slug', array(
            'default' => 'Here is your footer copy',
                //'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_copyright_slug', array(
                    'label' => 'Copyright Info',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_copyright_slug'
                )));
    }

}

class bjc_theme_settings {

    public function __construct() {
        add_action('customize_register', array($this, 'customize'));
    }

    public static function factory() {
        $factory = new bjc_theme_settings();
        return $factory;
    }

    public function customize($customize) {
        $customize->add_section('bjc_theme_settings', array(
            'title' => 'Custom Settings',
            'priority' => 105,
            'description' => "Manage theme settings"
        ));

//        $customize->add_setting('theme-admin',array(
//            'default' => 'Default theme admin'
//        ));
//
//        $customize->add_control('theme-admin',array(
//            'section' => 'bjc_theme_settings',
//            'label' => 'Theme Admin',
//            'type' => 'text'
//        ));

        $customize->add_setting('theme-admin', array(
            'default' => 'Default Theme Admin',
        ));

        $customize->add_control(new Selected_Users_Control($customize, 'theme-admin', array(
                    'label' => "Select Default ThemeAdmin",
                    'section' => 'bjc_theme_settings',
                    'settings' => 'theme-admin',
                    'description' => 'A Theme(s) admin user profile are used for themes socials links, contact info, about(us), etc',
                    'query' => array('role' => 'administrator')
                )));
    }

}

class content_pages {

    function __construct() {
        add_action('customize_register', array($this,'customizer'));
    }

    public function factory() {
        $fc = new content_pages();
        return $fc;
    }

    function customizer($wp_customize) {

        /*
         * Add the cover page
         */

        //conetent section

        $wp_customize->add_section('bjc_content', array(
            'title' => 'Content Sections',
            'description' => 'Select the page for the cover and parent page for theme content',
            'priority' => 110
        ));

        $wp_customize->add_setting('bjc_content_info', array(
            'default' => ''
        ));

        $wp_customize->add_control(new Info_Control($wp_customize, 'bjc_content_info', array(
                    'info' => '<i>You can set / change the content for you sections by selecting which page will a parent page and the child page(s) that appear (below) in the section.</i>',
                    'label' => 'Content sections',
                    'section' => 'bjc_content'
                )));


        $wp_customize->add_setting('bjc_cover_page', array(
            'default' => ''
        ));

        $wp_customize->add_control(new Selected_Pages_Control($wp_customize, 'bjc_cover_page', array(
                    'label' => "Select theme cover section page",
                    'section' => 'bjc_content',
                    'settings' => 'bjc_cover_page',
                    'description' => '<i>NB: Add child pages to selected page to enable the cover show</i>'
                )));

        $wp_customize->add_setting('bjc_about_page', array(
            'default' => ''
        ));

        $wp_customize->add_control(new Selected_Pages_Control($wp_customize, 'bjc_about_page', array(
                    'label' => "Select about section page",
                    'section' => 'bjc_content',
                    'settings' => 'bjc_about_page',
                    'description' => ''
                )));

        $wp_customize->add_setting('bjc_contact_page', array(
            'default' => ''
        ));

        $wp_customize->add_control(new Selected_Pages_Control($wp_customize, 'bjc_contact_page', array(
                    'label' => "Select contact section page",
                    'section' => 'bjc_content',
                    'settings' => 'bjc_contact_page',
                    'description' => ''
                )));

        $wp_customize->add_setting('bjc_navbox_page', array(
            'default' => ''
        ));

        $wp_customize->add_control(new Selected_Pages_Control($wp_customize, 'bjc_navbox_page', array(
                    'label' => "Select Nav-Box section page",
                    'section' => 'bjc_content',
                    'settings' => 'bjc_navbox_page',
                    'description' => ''
                )));
    }

}

if (class_exists('WP_Customize_Control')):

    class Info_Control extends WP_Customize_Control {

        public $type = 'info',
                $info = 'Setion info';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <span class=""><?php echo $this->info ?></span>
            </label>

            <?php
        }

    }

    class BJC_Editor_Control extends WP_Customize_Control {

        public $type = 'bjc_wp_editor';

//        var $defaults = array();
//        public $args = array();

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>

            <?php
        }

    }

    class Selected_Pages_Control extends WP_Customize_Control {

        public $type = 'option';
        public $args = array();
        public $description = '';

        public function render_content() {
            $pgs = $this->page_array($this->args);
            ?>
            <label>
                <span  class="customize-control-title" ><?php echo esc_html($this->label); ?></span>
                <select <?php $this->link(); ?>>
                    <option></option>
            <?php foreach ($pgs as $key => $value): ?>
                        <option value="<?php echo $key ?>" <?php echo ($key == $this->value() ? 'selected' : '') ?>>
                <?php echo $value; ?>
                        </option>
            <?php endforeach; ?>
                </select>
                <span style="display: block"><?php echo esc_html($this->description) ?></span>
            </label>
                        <?php
                    }

                    public function page_array($args = array()) {
                        /*
                         * get list of pages and output an associate array with post_name and post-title
                         * $pages['post_name'] = 'post_title';
                         */

                        $pages = get_pages();
                        foreach ($pages as $page) {
                            $pgs["{$page->ID}"] = $page->post_title;
                        }
                        return $pgs;
                    }

                }

                class Selected_Users_Control extends WP_Customize_Control {

                    public $type = 'option';
                    public $query = array('orderby' => 'nicename');
                    public $description = '';

                    public function render_content() {
                        $query = $this->query;
                        $pgs = $this->user_array($query);
                        ?>
            <label>
                <span  class="customize-control-title" ><?php echo esc_html($this->label); ?></span>
                <select <?php $this->link(); ?>>
                    <option></option>
            <?php foreach ($pgs as $key => $value): ?>
                        <option value="<?php echo $key ?>" <?php echo ($key == $this->value() ? 'selected' : '') ?>>
                <?php echo $value; ?>
                        </option>
            <?php endforeach; ?>
                </select>
                <span style="display: block"><?php echo esc_html($this->description) ?></span>
            </label>
                        <?php
                    }

                    public function user_array($args = '') {
                        /*
                         * get list of pages and output an associate array with post_name and post-title
                         * $pages['post_name'] = 'post_title';
                         */

                        $arrray = get_users($args);
                        foreach ($arrray as $items) {
                            $pgs["{$items->ID}"] = $items->user_nicename;
                        }
                        return $pgs;
                    }

                }

                /**
                 * @source http://ericjuden.com/2012/08/custom-taxonomy-control-for-the-theme-customizer/
                 */
                class Taxonomy_Dropdown_Control extends WP_Customize_Control {

                    public $type = 'taxonomy_dropdown';
                    var $defaults = array();
                    public $args = array();
                    public $tax = 'category';

                    public function render_content() {
                        // Call wp_dropdown_cats to ad data-customize-setting-link to select tag
                        add_action('wp_dropdown_cats', array($this, 'wp_dropdown_cats'));

                        // Set some defaults for our control
                        $this->defaults = array(
                            'show_option_none' => __('None'),
                            'orderby' => 'name',
                            'hide_empty' => 0,
                            'id' => $this->id,
                            'selected' => $this->value(),
                            'taxonomy' => $this->tax
                        );

                        // Parse defaults against what the user submitted
                        $r = wp_parse_args($this->args, $this->defaults);
                        ?>
            <label><span class="customize-control-title"><?php echo esc_html($this->label); ?></span></label>
            <?php
            // Generate our select box
            wp_dropdown_categories($r);
        }

        function wp_dropdown_cats($output) {
            // Search for <select and replace it with <select data-customize=setting-link="my_control_id"
            $output = str_replace('<select', '<select ' . $this->get_link(), $output);
            return $output;
        }

    }

endif;