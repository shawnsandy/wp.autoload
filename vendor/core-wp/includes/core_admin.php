<?php

/**
 * Description of ss_admin
 *
 * @author Studio365
 */
function _fb_AddThumbColumn($cols) {

    $cols['thumbnail'] = __('Thumbnail');

    return $cols;
}

function _fb_AddThumbValue($column_name, $post_id) {

    $width = (int) 35;
    $height = (int) 35;

    if ('thumbnail' == $column_name) {
        // thumbnail of WP 2.9
        $thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
        // image from gallery
        $attachments = get_children(array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
        if ($thumbnail_id)
            $thumb = wp_get_attachment_image($thumbnail_id, array($width, $height), true);
        elseif ($attachments) {
            foreach ($attachments as $attachment_id => $attachment) {
                $thumb = wp_get_attachment_image($attachment_id, array($width, $height), true);
            }
        }
        if (isset($thumb) && $thumb) {
            echo $thumb;
        } else {
            echo __('None');
        }
    }
}

function posts_columns_id($defaults) {
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}

function posts_custom_id_columns($column_name, $id) {
    if ($column_name === 'wps_post_id') {
        echo $id;
    }
}

class core_admin {

    //put your code here

    private $login_page;
    private $admin_logo;
    private $admin_footer;
    private $admin_credits;
    private $dash_message;

    public function getLogin_page() {
        return $this->login_page;
    }

    public function getAdmin_logo() {
        return $this->admin_logo;
    }

    public function getAdmin_footer() {
        return $this->admin_footer;
    }

    public function getAdmin_credits() {
        return $this->admin_credits;
    }

    public function getDash_message() {
        return $this->dash_message;
    }

    function __construct() {

    }

    public function get_options() {
        $options = get_option('custadmin_options', false);
        $this->admin_credits = $options['admin_credits'];
        $this->admin_footer = $options['admin_footer'];
        $this->admin_logo = $options['admin_logo'];
        $this->dash_message = $options['dash_message'];
        $this->login_page = $options['login_page'];
    }

    /**
     * Add a feed widget to the dashboard
     * @param string $feed_url rss feed url
     */
    public function db_feed($feed_url=null) {
        echo '<div class="rss-widget">';
        if ($feed):
            wp_widget_rss_output(array(
                'url' => $fee_url,
                'title' => 'What\'s up at 10up',
                'items' => 2,
                'show_summary' => 1,
                'show_author' => 0,
                'show_date' => 1
            ));
        endif;
        echo "</div>";
    }

    public function db_view($view, $array=null) {
        $view = ss_layout::layout_view($view, $array);
        echo $view;
    }

    public function user_login() {
        add_action('login', array(&$this, '_user_login'));
    }

    public function _user_login() {
        if (!is_admin()) {
            $pg = bloginfo('url') . '/' . 'user-login';
            if ($this->getLogin_page())
                $pg = bloginfo('url') . '/' . $pg;
            $r = wp_redirect($pg);
            return;
        }
    }

    public function create_login_page() {
        global $user_ID;
        $postarr = array(
            'post_title' => 'User Login',
            'post_name' => 'user-login',
            'post_content' => 'User login page; set or change user login page tamplate',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page',
            'post_category' => array(8, 39)
        );
        $id = wp_insert_post($postarr);
        if ($id)
            update_post_meta($id, '_wp_page_template', 'user-logip.php');
        //update_post_meta($post_id, '_wp_page_template', 'tp-file.php');
    }

    /**
     * Changes admin post titles to articles
     */
    public function rename_post() {
        /**
         * post to articles
         */
        // hook the translation filters
        add_filter('gettext', array('ss_functions', 'change_post_to_article'));
        add_filter('ngettext', array('ss_functions', 'change_post_to_article'));
    }

    function change_post_to_article($translated) {
        $translated = str_ireplace('Post', 'Article', $translated);  // ireplace is PHP5 only
        return $translated;
    }

    /**
     * Generic function to show a message to the user using WP's
     * standard CSS classes to make use of the already-defined
     * message colour scheme.
     *
     * @param $message The message you want to tell the user.
     * @param $errormsg If true, the message is an error, so use
     * the red message style. If false, the message is a status
     * message, so use the yellow information message style.
     */
    public static function showMessage($message, $errormsg = false) {
        if ($errormsg) {
            echo '<div id="message" class="error">';
        } else {
            echo '<div id="message" class="updated fade">';
        }

        echo "<p><strong>$message</strong></p></div>";
    }

    /**
     * adds
     * @global type $wp_admin_bar
     * @param type $array
     */
    public static function admin_bar_render($array=array()) {

        global $wp_admin_bar;
        $wp_admin_bar->add_menu(array(
            'parent' => $array['parent'], //'new-content', // use 'false' for a root menu, or pass the ID of the parent menu
            'id' => $array['id'], //'new_media', // link ID, defaults to a sanitized title value
            'title' => __($array['title']), // __('Media'), // link title
            'href' => $array['href'], // admin_url('media-new.php'), // name of file
            'meta' => $array['meta'] // false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
        ));
    }

    public static function bar_link() {
        /**
         * add_action( 'wp_before_admin_bar_render', 'bar_link' );
         */
    }

    function custom_login_logo() {
        echo '<style type="text/css">
        h1 a { background-image:url(' . get_stylesheet_directory_uri() . '/images/login-logo.gif) !important; }
    </style>';
    }

    public static function login_logo() {
        add_action('login_head', 'my_custom_login_logo');
    }

    public static function admin_css($css_url) {
        //check for theme admin css exists
        if (file_exists(STYLESHEETPATH . '/custom-admin/admin.css')) {
            $css = STYLESHEETPATH . '/custom-admin/admin.css';
        } elseif (file_exists(TEMPLATEPATH . '/custom-admin/admin.css')) {
            $css = TEMPLATEPATH . '/custom-admin/admin.css';
        } else {
            $css = $css_url . '/custom-admin/admin.css';
        }
        //$plugins =  ;
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$css}\"/>";


        if (file_exists(STYLESHEETPATH . '/custom-admin/admin-icon.png')) {
            $icon = STYLESHEETPATH . '/custom-admin/admin-icon.png';
        } elseif (file_exists(TEMPLATEPATH . '/custom-admin/admin-icon.png')) {
            $icon = TEMPLATEPATH . '/custom-admin/admin-icon.png';
        } else {
            $icon = $css_url . '/custom-admin/admin-icon.png';
        }
        ?>
        <style type="text/css" >
            #header-logo
            {
                /*
                visibility: hidden;
                */
                background-image: url(<?php echo $icon ?>);
                width: 38px;
                height: 38px;
            }
        </style>
        <?php
    }

    /* Custom CSS styles on WYSIWYG Editor */

//    // Add body class to Visual Editor to match class used live
//    public function mce_settings($initArray) {
//        $initArray['body_class'] = 'post';
//        return $initArray;
//    }
//
//    public static function editor_style() {
//        add_editor_style(get_template_directory_uri() . '/library/css/post-style.css');
//        add_filter('tiny_mce_before_init', array('core_admin', 'mce_settings'));
//    }

    public static function post_list_thumbs() {
        // for posts
        add_filter('manage_posts_columns', '_fb_AddThumbColumn');
        add_action('manage_posts_custom_column', '_fb_AddThumbValue', 10, 2);

        // for pages
        add_filter('manage_pages_columns', '_fb_AddThumbColumn');
        add_action('manage_pages_custom_column', '_fb_AddThumbValue', 10, 2);
    }

    public static function column_id() {
        add_filter('manage_posts_columns', 'posts_columns_id', 5);
        add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
        add_filter('manage_pages_columns', 'posts_columns_id', 5);
        add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);
    }

    public static function _remove_editor_menu() {
        //http://wp-snippets.com/2061/remove-theme-editor-submenu/
        remove_action('admin_menu', '_add_themes_utility_last', 101);
    }

    public static function remove_editor_menu() {
        add_action('_admin_menu', array('core_admin', '_remove_editor_menu'), 1);
    }

    public function _restrict_access_admin_panel() {
        global $current_user;
        get_currentuserinfo();

        if ($current_user->user_level < 4) { //if not admin, die with message
            wp_redirect(get_bloginfo('url'));
            exit;
        }
    }

    public static function restrict_admin_access() {

        add_action('admin_init', 'restrict_access_admin_panel', 1);
    }

    public static function shortcode_buttons() {
        // http://wpsnipp.com/index.php/functions-php/update-automatically-create-media_buttons-for-shortcode-selection/
        add_action('media_buttons', array('core_admin', 'add_sc_select'), 11);
        add_action('admin_head', array('core_admin', 'button_js'));
    }

    //add_action('media_buttons','add_sc_select',11);
    public function add_sc_select() {
        global $shortcode_tags;
        /* ------------------------------------- */
        /* enter names of shortcode to exclude bellow */
        /* ------------------------------------- */
        $exclude = array("wp_caption", "embed");
        echo '&nbsp;<select id="sc_select"><option>Shortcode</option>';
        foreach ($shortcode_tags as $key => $val) {
            if (!in_array($key, $exclude)) {
                $shortcodes_list .= '<option value="[' . $key . '][/' . $key . ']">' . $key . '</option>';
            }
        }
        echo $shortcodes_list;
        echo '</select>';
    }

//add_action('admin_head', 'button_js');
    public function button_js() {
        echo '<script type="text/javascript">
	jQuery(document).ready(function(){
	   jQuery("#sc_select").change(function() {
			  send_to_editor(jQuery("#sc_select :selected").val());
        		  return false;
		});
	});
	</script>';
    }


    public function excerpt_count_js() {
        //http://wpsnipp.com/index.php/functions-php/create-custom-post-status-mesasges-in-admin/
        echo ' <script>jQuery(document).ready(function(){
    jQuery("#postexcerpt .handlediv").after("<div style=\"position:absolute;top:0px;right:5px;color:#666;\"><small>Excerpt length: </small><input type=\"text\" value=\"0\" maxlength=\"3\" size=\"3\" id=\"excerpt_counter\" readonly=\"\" style=\"background:#fff;\"> <small>character(s).</small></div>");
    jQuery("#excerpt_counter").val(jQuery("#excerpt").val().length);
    jQuery("#excerpt").keyup( function() {
    jQuery("#excerpt_counter").val(jQuery("#excerpt").val().length);
    });
});</script>';
    }

    public static function excerpt_count() {
        add_action('admin_head-post.php', array('core_admin', 'excerpt_count_js'));
        add_action('admin_head-post-new.php', array('core_admin', 'excerpt_count_js'));
    }

    public function themeit_mce_buttons_2($buttons) {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }
    /**
     * @todo add some common theme sytles
     */
    function themeit_tiny_mce_before_init($settings) {
        $settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
        $style_formats = array(
            array('title' => 'Button', 'inline' => 'span', 'classes' => 'button'),
            array('title' => 'Green Button', 'inline' => 'span', 'classes' => 'button button-green'),
            array('title' => 'Rounded Button', 'inline' => 'span', 'classes' => 'button button-rounded'),
            array('title' => 'Other Options'),
            array('title' => '&frac12; Col.', 'block' => 'div', 'classes' => 'one-half'),
            array('title' => '&frac12; Col. Last', 'block' => 'div', 'classes' => 'one-half last'),
            array('title' => 'Callout Box', 'block' => 'div', 'classes' => 'callout-box'),
            array('title' => 'Highlight', 'inline' => 'span', 'classes' => 'highlight')
        );
        $settings['style_formats'] = json_encode($style_formats);
        return $settings;
    }

    public static function editor_styles_button() {
        //http://wpsnipp.com/index.php/functions-php/creating-custom-styles-drop-down-in-tinymce/
        add_filter('tiny_mce_before_init', array('core_admin','themeit_tiny_mce_before_init'));
        add_filter('mce_buttons_2', array('core_admin','themeit_mce_buttons_2'));
    }


    /**
     * @todo add some twitter bootstrap theme sytles
     */

      public function tbs_mce_buttons_2($buttons) {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    function boot_styles($settings) {
        //$settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
        $style_formats = array(
            array('title' => 'Button', 'inline' => 'span', 'classes' => 'btn'),
            array('title' => 'Primary', 'inline' => 'span', 'classes' => 'btn btn-primary'),
            array('title' => 'info', 'inline' => 'span', 'classes' => 'btn btn-info'),
            array('title' => 'Success', 'inline' => 'span', 'classes' => 'btn btn-success'),
            array('title' => 'Warning', 'inline' => 'span', 'classes' => 'btn btn-warning'),
            array('title' => 'Danger', 'inline' => 'span', 'classes' => 'btn btn-danger'),
            array('title' => 'Inverse', 'inline' => 'span', 'classes' => 'btn btn-inverse'),
            array('title' => 'Font Size'),
            array('title' => 'Tiny', 'inline' => 'span', 'classes' => 'font-tiny'),
            array('title' => 'Small', 'inline' => 'span', 'classes' => 'font-small'),
            array('title' => 'Medium', 'inline' => 'span', 'classes' => 'font-medium'),
            array('title' => 'Large', 'inline' => 'span', 'classes' => 'font-large'),
            array('title' => 'Larger', 'inline' => 'span', 'classes' => 'font-larger'),
            array('title' => 'Labels'),
            array('title' => 'Default', 'inline' => 'span', 'classes' => 'label'),
            array('title' => 'Success', 'inline' => 'span', 'classes' => 'label label-success'),
            array('title' => 'Warning', 'inline' => 'span', 'classes' => 'label label-warning'),
            array('title' => 'Info', 'inline' => 'span', 'classes' => 'label label-info'),
            array('title' => 'Important', 'inline' => 'span', 'classes' => 'label label-important'),
            array('title' => 'Alerts'),
            array('title' => 'Default', 'block' => 'div', 'classes' => 'alert'),
            array('title' => 'Info', 'block' => 'div', 'classes' => 'alert alert-info'),
            array('title' => 'Others'),
            array('title' => 'Well', 'block' => 'div', 'classes' => 'well'),
            array('title' => 'Highlight', 'inline' => 'span', 'classes' => 'highlight')
        );
        $settings['style_formats'] = json_encode($style_formats);
        return $settings;
    }

    public static function boot_styles_button() {
        //http://codex.wordpress.org/TinyMCE_Custom_Buttons
        //http://wpsnipp.com/index.php/functions-php/creating-custom-styles-drop-down-in-tinymce/
        add_filter('tiny_mce_before_init', array('core_admin','boot_styles'));
        add_filter('mce_buttons_2', array('core_admin','tbs_mce_buttons_2'));
    }



    public static function remove_screen_options() {
        //http://wpsnipp.com/index.php/functions-php/remove-the-screen-options-tab-with-screen_options_show_screen-hook/
        return false;
    }

    /**
     * hides screen options from non admins
     */
    public static function hide_screen_options() {
        if (!is_admin())
            add_filter('screen_options_show_screen', 'remove_screen_options');
    }

    public static function message($message='', $error=false) {
        //http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area

        /**
         * Generic function to show a message to the user using WP's
         * standard CSS classes to make use of the already-defined
         * message colour scheme.
         *
         * @param $message The message you want to tell the user.
         * @param $errormsg If true, the message is an error, so use
         * the red message style. If false, the message is a status
         * message, so use the yellow information message style.
         */
        if ($errormsg) {
            echo '<div id="message" class="error">';
        } else {
            echo '<div id="message" class="updated fade">';
        }

        echo "<p><strong>$message</strong></p></div>";
    }

    public static function no_self_ping(&$links) {
        $home = get_option('home');
        foreach ($links as $l => $link)
            if (0 === strpos($link, $home))
                unset($links[$l]);
    }

    public static function end_self_ping() {
        add_action('pre_ping', array('core_admin', 'no_self_ping'));
    }

    /**
     * Manipulate Child Pages to Use Parent Page Templates Automatically
     */
    public static function switch_page_template() {

        global $post;

        $post_type = get_post_type($post->ID);

        if (is_page() or is_post_type_hierarchical($post_type)) {// Checks if current post type is a page, rather than a post
            $current_page_template = get_post_meta($post->ID, '_wp_page_template', true);
            $parent_page_template = get_post_meta($post->post_parent, '_wp_page_template', true);
            $parents = get_post_ancestors($post->ID);

            if ($parents) {
                update_post_meta($post->ID, '_wp_page_template', $parent_page_template, $current_page_template);
            }
        }// End check for page
    }

    /**
     * force child pages to use a parent page template
     */
    public static function use_parent_template() {
        add_action('save_post', array('core_admin', 'switch_page_template'));
    }

    public function wp_logo_adminbar_remove() {
        global $wp_admin_bar;
        /* Remove their stuff */
        $wp_admin_bar->remove_menu('wp-logo');
    }

    public static function remove_wp_adminbar_logo() {
        add_action('wp_before_admin_bar_render', array('core_admin', 'wp_logo_adminbar_remove'), 0);
    }

    /**
     * Hide Editor on Specific Template Page
     *
     */
    public function be_hide_editor() {
        // Get the Post ID
        if (isset($_GET['post']))
            $post_id = $_GET['post'];
        elseif (isset($_POST['post_ID']))
            $post_id = $_POST['post_ID'];

        if (!isset($post_id))
            return;

        // Get the Page Template
        $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);

        //if ('template-photos.php' == $template_file)
        //echo '<style>#postdivrich{display: none;}</style>';
        remove_post_type_support('post', 'editor');
    }

    public static function hide_editor() {
        add_action('admin_init', array('core_admin', 'be_hide_editor'));
    }

    public static function remove_dashboard_widgets() {
        add_action('admin_init', array('core_admin', 'remove_dashboard'));
    }

    // http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
    public function remove_dashboard() {
        // Globalize the metaboxes array, this holds all the widgets for wp-admin
        global $wp_meta_boxes;
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_primary', 'dashboard', 'normal');
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    }

}

