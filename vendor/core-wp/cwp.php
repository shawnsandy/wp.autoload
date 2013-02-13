<?php
/**
 * Description of cwp
 *
 * @author Studio365
 */
/**
 * Loads core.wp classes
 * @package Wordpress
 * @subpackage core.wp
 */

if(!defined('CWP_PATH'))
define('CWP_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));

if(!defined('CWP_URL'))
define('CWP_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));

define('CM_PATH',  WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/modules');

define('CM_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)) . '/modules');

define('CORE_WP', plugin_dir_path(__FILE__));
/**
 * autoload with compat
 */
if (function_exists('__autoload'))
    spl_autoload_register('__autoload');

spl_autoload_register('cwp_autoLoader');

function cwp_autoLoader($class) {

    if (file_exists(get_stylesheet_directory() . '/core-wp/modules/' . $class . '.php')):
        require_once get_stylesheet_directory() . '/core-wp/modules/' . $class . '.php';
    endif;

    if (file_exists(get_template_directory() . '/core-wp/modules/' . $class . '.php')):
        require_once get_template_directory() . '/core-wp/modules/' . $class . '.php';
    endif;

    if (file_exists(WP_PLUGIN_DIR . '/core-wp/modules/' . $class . '.php')):
        require_once WP_PLUGIN_DIR . '/core-wp/modules/' . $class . '.php';
    endif;

    if (file_exists(WP_PLUGIN_DIR . '/core-wp/includes/' . $class . '.php')):
        require_once WP_PLUGIN_DIR . '/core-wp/includes/' . $class . '.php';
    endif;

    if (file_exists(get_stylesheet_directory() . '/core-wp/modules/core_' . $class . '.php')):
        require_once get_stylesheet_directory() . '/core-wp/modules/core_' . $class . '.php';
    endif;

    if (file_exists(get_template_directory() . '/core-wp/modules/core_' . $class . '.php')):
        require_once get_template_directory() . '/core-wp/modules/core_' . $class . '.php';
    endif;

    if (file_exists(WP_PLUGIN_DIR . '/core-wp/modules/core_' . $class . '.php')):
        require_once WP_PLUGIN_DIR . '/core-wp/modules/core_' . $class . '.php';
    endif;

    if (file_exists(WP_PLUGIN_DIR . '/core-wp/includes/core_' . $class . '.php')):
        require_once WP_PLUGIN_DIR . '/core-wp/includes/core_' . $class . '.php';
    endif;
}

class cwp {

    private $args = array();

    public function set_args($args) {
        $this->args = $args;
    }

    public function __construct() {

    }

    public static function factory() {
        return new cwp;
    }

    /**
     *
     */
    public static function logo($_name = null) {
        $name = 'logo.png';
        if (isset($_name))
            $name = $_name;
        $logo_url = get_template_directory_uri() . '/images/basejump.png';
        if (file_exists(get_stylesheet_directory() . "/images/{$name}"))
            $logo_url = get_stylesheet_directory_uri() . "/images/{$name}";
        else if (file_exists(get_template_directory() . "/images/{$name}.png"))
            $logo_url = get_template_directory_uri() . "/images/{$name}";
        return $logo_url;
    }

    /**
     * *************************************************************************
     * file functions
     * *************************************************************************
     */

    /**
     * Locates the file url
     * @param type $filename
     * @return string
     */
    public static function locate_file_url($filename) {
        //$path = '/tpl/' . $dir . '/' . $file;
        $located = FALSE;
        if (file_exists(get_stylesheet_directory() . '/' . $filename)):
            $file = get_stylesheet_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(get_template_directory() . '/' . $filename)):
            $file = get_template_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(get_stylesheet_directory() . $filename)):
            $file = get_stylesheet_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(get_template_directory() . '/' . $filename)):
            $file = get_template_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(get_stylesheet_directory() . '/' . $filename)):
            $file = get_stylesheet_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(get_template_directory() . '/' . $filename)):
            $file = get_template_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(STYLESHEETPATH . '/' . $filename)):
            $file = get_stylesheet_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(TEMPLATEPATH . '/' . $filename)):
            $file = get_template_directory_uri() . '/' . $filename;
            return $located = true;
        elseif (file_exists(CWP_URL . '/' . $filename)):
            $file = CWP_URL . '/' . $filename;
            return $file;
        endif;
        if (!$located):
            return false;
        else :
            return $file;
        endif;
    }

    /**
     * Locate core-wp file template/modules/** , template/tpl/** , core-wp/modules/**
     * @param type $filepath directory/filename.ext / filenamt.ext
     * @return string
     */
    public static function locate_file_path($filepath = null) {

        //$file = PLUGINDIR . '/core-wp/' . $filepath;
        $located = false;
        if (file_exists(STYLESHEETPATH . $filepath)):
            $file = STYLESHEETPATH . $filepath;
            $located = true;
        elseif (file_exists(TEMPLATEPATH . $filepath)):
            $file = TEMPLATEPATH . $filepath;
            $located = true;
        elseif (file_exists(STYLESHEETPATH . $filepath)):
            $file = STYLESHEETPATH . $filepath;
            $located = true;
        elseif (file_exists(TEMPLATEPATH . $filepath)):
            $file = TEMPLATEPATH . '/' . $filepath;
            $located = true;
        elseif (file_exists(STYLESHEETPATH . '/' . $filepath)):
            $file = STYLESHEETPATH . '/' . $filepath;
            $located = true;
        elseif (file_exists(TEMPLATEPATH . '/' . $filepath)):
            $file = TEMPLATEPATH . '/' . $filepath;
            $located = true;
        elseif (file_exists(CM_PATH . '/' . $filepath)):
            $file = CWP_PATH . '/' . $filepath;
            $located = true;
        endif;
        if (!$located):
            return false;
        else :
            return $file;
        endif;
    }

    /**
     * Locates a resource in the library file
     * <code> <?php echo cwp::locate_in_libary('myfile.css','css') ?> </code>
     * @param string $filename
     * @param string $dir default- css
     * @return string
     */
    public static function locate_in_library($filename = null, $dir = 'css') {

        $file = false;
        if (isset($filename)):
            $filepath = 'library/' . $dir . '/' . $filename;
            if (file_exists(get_stylesheet_directory() . '/' . $filepath)):
                $file = get_stylesheet_directory_uri() . '/' . $filepath;

            elseif (file_exists(get_template_directory() . '/' . $filepath)):
                $file = get_template_directory_uri() . '/' . $filepath;

            elseif (CWP_PATH . '/' . $filepath):
                $file = CWP_URL . '/' . $filepath;

            endif;
            return $file;
        endif;

    }

    public static function css($name = 'style', $module = null) {
        $path = $name . '.css';
        if (isset($module))
            $path = $module . '/css/' . $path;
        $css = cwp::locate_file_url($path);
        return $css;
    }

    public static function config($name = 'config', $module = null) {
        $path = $name . '.php';
        if (isset($module))
            $path = $module . '/' . $path;
        return $path;
    }

    public static function jquery() {

        add_action('wp_enqueue_scripts', array('cwp', 'replace_jquery'));
    }

    public function replace_jquery() {
        $url = 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js';
        $version = '1.6.1';
        // comment out the next two lines to load the local copy of jQuery
        wp_deregister_script('jquery');
        wp_register_script('jquery', $url, false, $version);
        wp_enqueue_script('jquery');
    }

    public static function inuit_css($style = 'inuit') {
        $path = CM_URL . '/inuit/css/';
        $css = $path . 'inuit.css';
        wp_enqueue_style('inuit', $css);
        $grid = $path . 'grid.inuit.css';
        wp_enqueue_style('grid-inuit', $grid, array('inuit'));
        $dropdown = $path . 'dropdown.inuit.css';
        wp_enqueue_style('dropdown-inuit', $dropdown, array('inuit'));
    }

    /**
     * *************************************************************************
     * MODULES
     * *************************************************************************
     */
    public static function get_module($template = 'index', $module = 'default', $data = array()) {
        $mod = new core_tpl();
        $mod->modules($template, $module, $data);
    }

    /**
     *
     * @global type $posts
     * @global type $post
     * @global type $wp_did_header
     * @global type $wp_did_template_redirect
     * @global type $wp_query
     * @global type $wp_rewrite
     * @global type $wpdb
     * @global type $wp_version
     * @global type $wp
     * @global type $id
     * @global type $comment
     * @global type $user_ID
     * @param string $template
     * @param type $module
     * @param type $data
     * @param type $require_once
     */
    public static function modules($template = 'loop', $module = 'default', $data = array(), $require_once = false) {
        global $posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        if (is_array($data) AND !empty($data))
            extract($data);

        $template = $template . '.php';

        //$file = PLUGINDIR . '/core-wp/modules/' . $module . '/tpl/' . $template;
        $file = CM_PATH . '/' . $module . '/tpl/' . $template;

        if (file_exists(STYLESHEETPATH . '/tpl/' . $template)) {
            $file = STYLESHEETPATH . '/tpl/' . $template;
        } elseif (file_exists(STYLESHEETPATH . '/' . $template)) {
            $file = STYLESHEETPATH . '/' . $template;
        } elseif (file_exists(TEMPLATEPATH . '/tpl/' . $template)) {
            $file = TEMPLATEPATH . '/tpl/' . $template;
        } elseif (file_exists(TEMPLATEPATH . '/' . $template)) {
            $file = TEMPLATEPATH . '/' . $template;
        }

        if (file_exists($file))
            if ($require_once):
                require_once $file;
            else:
                require $file;
        endif;
        else
            echo "MODULE NOT FOUND";
    }

    public static function css_reset($normalize = false) {
        if ($normalize):
            wp_enqueue_style('normalize', CM_URL . '/css/normalize.css');
        else :
            wp_enqueue_style('reset', CM_URL . '/css/reset.css');
        endif;
    }

    public static function baseline() {
        //wp_enqueue_style('baseline-type', CM_URL .'/baseline/baseline.type.css');
        //wp_enqueue_style('baseline-form', CM_URL .'/baseline/baseline.form.css');
    }

    public static function css_960() {
        ?>
        <link rel="stylesheet" href="<?php echo CM_URL ?>/css/adapt.css" />
        <noscript>
        <link rel="stylesheet" href="<?php echo CM_URL ?>/adapt/assets/css/mobile.min.css" />
        </noscript>
        <script>
            // Edit to suit your needs.
            var ADAPT_CONFIG = {
                // Where is your CSS?
                path: '<?php echo CM_URL ?>/adapt/assets/css/',

                // false = Only run once, when page first loads.
                // true = Change on window resize and page tilt.
                dynamic: true,

                // First range entry is the minimum.
                // Last range entry is the maximum.
                // Separate ranges by "to" keyword.
                range: [
                    '0px    to 760px  = mobile.min.css',
                    '760px  to 980px  = 720.min.css',
                    '980px  to 1280px = 960.min.css',
                    '1280px to 1600px = 1200.min.css',
                    '1600px to 1920px = 1560.min.css',
                    '1920px           = fluid.min.css'
                ]
            };
        </script>
        <script src="<?php echo CM_URL; ?>/adapt/assets/js/adapt.min.js"></script>
        <?php
    }

    /**
     * *************************************************************************
     * images
     * *************************************************************************
     */

    /**
     * fluid image src link - only use in post loop
     * @global type $post
     * @param type $size
     * @todo fix to use out of loop
     */
    public static function fluid_img($size = 'thumbnail', $max_w = 100, $class = "") {
        global $post;
        $id = $post->ID;
        if (isset($ID))
            $id = $ID;
        $img_id = get_post_thumbnail_id($id);
        $imgs = wp_get_attachment_image_src($img_id, $size);
        if ($imgs):
            $src = '<img class="' . $class . '" src="' . $imgs[0] . '" alt="" style="display:block; max-width:' . $max_w . '%" />';
        else :
            $src = '<img src="noimage.jpg" alt="no image found" />';
        endif;
        echo $src;
    }

    /**
     * *************************************************************************
     * Themes / TPL
     * *************************************************************************
     */

    /**
     *
     * @param type $slug default content
     */
    public static function get_tpl($slug = 'default') {
        $tpl = new core_tpl($slug);
        $template = $tpl->tpl($slug);
        load_template($template, false);
    }

    public static function get_tpl_part($slug, $name = null) {
        //core_tpl::locate_tpl($template_names, $slug);
    }

    public static function get_tpl_content($name = null) {
        //core_tpl::locate_tpl($template_names, $slug);
        $template = core_tpl::get_tpl_part('content', $name);
        //echo 'pate--'.$template;
    }

    public static function get_tpl_design($name = null) {
        //core_tpl::locate_tpl($template_names, $slug);
        $template = core_tpl::get_tpl_part('design', $name);
        //echo 'pate--'.$template;
    }

    public static function get_tpl_code($name = null) {
        //core_tpl::locate_tpl($template_names, $slug);
        $template = core_tpl::get_tpl_part('code', $name);
        //echo 'pate--'.$template;
    }

    public static function get_tpl_data($name = null) {
        //core_tpl::locate_tpl($template_names, $slug);
        $template = core_tpl::get_tpl_part('data', $name);
        //echo 'pate--'.$template;
    }

    /**
     * mover to the csf_functions file theme directory
     */
    public static function theme_images() {
        add_image_size('slideshow-980', 980, 420, true);
        add_image_size('slideshow-1200', 1180, 550, true);
        add_image_size('slideshow-1560', 1540, 550, true);
        add_image_size('slideshow-720', 600, 550, true);
        add_image_size('grid-thumbnail', 370, 270, true);
        add_image_size('icon-60', 60, 60, true);
        add_image_size('icon-100', 100, 100, true);
        add_image_size('icon-40', 40, 40, true);
    }

    public static function remove_update_notification() {

        global $user_login;
        get_currentuserinfo();
        if ($user_login !== "admin") { // change admin to the username that gets the updates
            add_action('init', create_function('$a', "remove_action( 'init', 'wp_version_check' );"), 2);
            add_filter('pre_option_update_core', create_function('$a', "return null;"));
        }
    }

    public static function remove_head_meta() {
        // remove junk from head
        if (!is_admin()):
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wp_generator');
            //remove_action('wp_head', 'feed_links', 2);
            remove_action('wp_head', 'index_rel_link');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'feed_links_extra', 3);
            remove_action('wp_head', 'start_post_rel_link', 10, 0);
            remove_action('wp_head', 'parent_post_rel_link', 10, 0);
            remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
        endif;
    }

    public static function shortcodes_in_widgets() {
        // shortcode in widgets
        if (!is_admin()) {
            add_filter('widget_text', 'do_shortcode', 11);
        }
    }

    public static function theme_setup() {
        self::jquery();
        self::shortcodes_in_widgets();
        self::remove_head_meta();
        self::remove_update_notification();
        self::theme_images();
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        core_functions::favicon();
        core_functions::no_smiley_face();
        core_functions::all_post_formats();
    }

    /**
     * Deprecated use register sidebar
     * @param type $name
     * @param type $widget_id
     * @param type $description
     * @param type $id
     * @param type $div
     * @param type $title
     */
    public static function add_widget($name, $widget_id, $description = "", $id = 'widgets', $div = "aside", $title = 'h3') {
        //$widget_id = preg_replace(" ", "-", $name);
        register_sidebar(array(
            'name' => ucfirst($name),
            'id' => $widget_id,
            'description' => __($description),
            'before_widget' => '<' . $div . ' id="%1$s" class="widget %2$s">',
            'after_widget' => "</{$div}>",
            'before_title' => '<' . $title . ' class="widget-title">',
            'after_title' => '</' . $title . '>',
        ));
    }

    /**
     *
     * @param type $name
     * @param type $widget_id
     * @param type $description
     * @param type $id
     * @param type $div
     * @param type $title
     *
     * <code>
     * //example
     * cwp::add_widget('Top Sidebar', 'top-sidebar', 'Top sidebar widget');
     * </code>
     */
    public static function register_sidebar($name, $widget_id, $description = "", $div = "div", $title = 'h3') {
        //$widget_id = preg_replace(" ", "-", $name);
        register_sidebar(array(
            'name' => ucfirst($name),
            'id' => $widget_id,
            'description' => $description,
            'before_widget' => '<' . $div . ' id="%1$s" class="widget %2$s">',
            'after_widget' => "</{$div}>",
            'before_title' => '<' . $title . ' class="widget-title">',
            'after_title' => '</' . $title . '>',
        ));
    }

    /**
     *
     * @param type $name
     * @param type $widget_id
     * @param type $description
     * @param type $id
     * @param type $div
     * @param type $title
     *
     * <code>
     * //example
     * cwp::add_widget('Top Sidebar', 'top-sidebar', 'Top sidebar widget');
     * </code>
     */
    public static function register_sidebar_footer($name, $widget_id, $description = "",  $class = "span3", $id = 'widgets', $title = 'h3') {
        //$widget_id = preg_replace(" ", "-", $name);
        register_sidebar(array(
            'name' => ucfirst($name),
            'id' => $widget_id,
            'description' => $description,
            'before_widget' => '<div id="%1$s" class="'.$class.' widget %2$s">',
            'after_widget' => "</div>",
            'before_title' => '<' . $title . ' class="widget-title">',
            'after_title' => '</' . $title . '>',
        ));
    }

    /**
     * Bootstrap thumbnail grids based widgets
     * @param type $name
     * @param type $widget_id
     * @param type $description
     * @param type $div
     * @param type $id
     * @param type $title
     * <code>
     * //example
     * cwp::add_widget('Top Sidebar', 'top-sidebar', 'Top sidebar widget');
     * </code>
     */
    public static function register_sidebar_grid($name, $widget_id, $description = "", $class = "span4", $id = 'widgets', $title = 'h3') {
        //$widget_id = preg_replace(" ", "-", $name);
        register_sidebar(array(
            'name' => ucfirst($name),
            'id' => $widget_id,
            'description' => $description,
            'before_widget' => '<li id="%1$s" class="' . $class . ' widget %2$s"><div class="thumbnail">',
            'after_widget' => "</thumbnail></li>",
            'before_title' => '<' . $title . ' class="widget-title">',
            'after_title' => '</' . $title . '>',
        ));
    }

    /**
     *
     * @param type $slug
     */
    public static function get_theme_header($slug = 'default') {
        cwp_layout::tpl_part($slug, 'theme-header');
    }

    /**
     *
     * @param type $slug
     */
    public static function header($slug = null) {
        $tpl = 'header';
        if (isset($slug))
            $tpl = "{$slug}-header";
        cwp_layout::tpl_part(null, $tpl);
    }

    /**
     *
     * @param type $slug
     */
    public static function footer($slug = null) {
        $tpl = 'footer';
        if (isset($slug))
            $tpl = "{$slug}-footer";
        core_tpl::get_tpl_part(null, $tpl);
    }

    /**
     *
     * @param type $slug
     */
    public static function get_theme_footer($slug = 'default') {
        core_tpl::get_tpl_part($slug, 'theme-footer');
    }

    public static function related($tpl = 'related') {
        global $post;

// Reference : http://codex.wordpress.org/Function_Reference/wp_get_post_tags
// we are using this function to get an array of tags assigned to current post
        $tags = wp_get_post_tags($post->ID);

        if ($tags) {

            $first_tag = $tags[0]->term_id; // we only need the id of first tag
            // arguments for query_posts : http://codex.wordpress.org/Function_Reference/query_posts
            $args = array(
                'tag__in' => array($first_tag),
                'post__not_in' => array($post->ID),
                'showposts' => 4, // these are the number of related posts we want to display
                'ignore_sticky_posts' => 1 // to exclude the sticky post
            );

            // WP_Query takes the same arguments as query_posts
            $related_query = new WP_Query($args);

            if ($related_query->have_posts()) {

                core_module::tpl();
                wp_reset_query(); // to reset the loop : http://codex.wordpress.org/Function_Reference/wp_reset_query
            }
        } else {
            echo "Sorry there are no Related Post";
        }
    }

    /**
     * @link http://wp-snippets.com/1365/dynamic-custom-length-excpert/
     * @global type $post
     * @param type $length
     */
    public static function excerpt($length = 150, $trailing = '...') { // Max excerpt length. Length is set in characters
        global $post;
        $text = $post->post_excerpt;
        if ('' == $text) {
            $text = get_the_content('');
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]>', $text);
        }
        $text = strip_shortcodes($text); // optional, recommended
        $text = strip_tags($text); // use ' $text = strip_tags($text,'<p><a>'); ' if you want to keep some tags
        //$text = substr($text,0,strpos($text,' ',$length));
        $text = substr($text, 0, $length);
        $text = substr($text, 0, strrpos($text, ' '));
        $excerpt = self::reverse_strrchr($text, ' ', 1);
        if ($excerpt) {
            echo apply_filters('the_excerpt', $excerpt . $trailing);
        } else {
            echo apply_filters('the_excerpt', $text . $trailing);
        }
    }

// Returns the portion of haystack which goes until the last occurrence of needle
    public static function reverse_strrchr($haystack, $needle, $trail) {
        return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
    }

    public static function recaptcha($publickey = "") {
        if (file_exists(CWP_PATH . '/includes/recaptchalib.php')):
            require_once(CWP_PATH . '/includes/recaptchalib.php');
            return $o_cpatcha = recaptcha_get_html($publickey);
        endif;
    }

    public static function recaptcha_valid($privatekey = "") {
        if (file_exists(CWP_PATH . '/includes/recaptchalib.php')):
            require_once(CWP_PATH . '/includes/recaptchalib.php');
            if (isset($_POST["recaptcha_challenge_field"]) AND isset($_POST["recaptcha_response_field"])):
                $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                if (!$resp->is_valid) {
                    // What happens when the CAPTCHA was entered incorrectly
                    die("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
                            "(reCAPTCHA said: " . $resp->error . ")");
                } else {
                    return $o_validate = true;
                }
            endif;
        endif;
    }

    public static function filter_images($content, $before = "<span class=\"image-wrap\">", $after = "</span>") {
        return preg_replace('/<img (.*) \/>\s*/iU', '' . $before . '<img \1 />' . $after . '', $content);
    }

    /**
     * wrap image in span imagewrap
     */
    public static function image_wrap() {
        add_filter('the_content', array('cwp', 'filter_images'));
    }

    /**
     * @todo depreciate use theme settings
     * @param strung $name
     * @param string $default_array
     * @return type
     */
    public static function theme_options($name = null, $default_array = null) {
        $keys = array(
            'supportkey' => false,
            'offline' => 0,
            'defaultpages' => 0,
            'sometext' => false,
            'themeadmin' => 1,
            'uidefault' => false,
            'gakey' => false,
            'gsearchbox' => false,
            'gsearchpage' => false,
            'twitterwidget' => false,
            'fbappid' => '');
        if (!isset($default_array) AND in_array($name, $keys)):
            $default_array = $keys;
        endif;
        if (isset($name)):
            $opts = get_option('cwp_theme_options', $default_array);
            $opt = (isset($opts["$name"]) ? $opts[$name] : false);
            return $opt;
        else:
            return false;
        endif;
    }

    /**
     *
     * @param strung $name
     * @param string $default_array
     * @return type
     */
    public static function theme_settings($name = null, $default_array = null) {
        $keys = array(
            'supportkey' => false,
            'offline' => 0,
            'defaultpages' => 0,
            'sometext' => false,
            'themeadmin' => 1,
            'uidefault' => false,
            'gakey' => false,
            'gsearchbox' => false,
            'gsearchpage' => false,
            'twitterwidget' => false,
            'fbappid' => '');
        if (!isset($default_array) AND in_array($name, $keys)):
            $default_array = $keys;
        endif;
        if (isset($name)):
            $opts = get_option('cwp_theme_options', $default_array);
            $opt = (isset($opts["$name"]) ? $opts[$name] : false);
            return $opt;
        else:
            return false;
        endif;
    }

    public static function bm_sc_mshot($attributes, $content = '', $code = '') {

        extract(shortcode_atts(array(
                    'url' => '',
                    'width' => 250,
                    'target' => null,
                        ), $attributes));

        $imageUrl = cwp::bm_mshot($url, $width);

        if ($imageUrl == '') {
            return '';
        } else {
            $image = '<img src="' . $imageUrl . '" alt="' . $url . '" width="' . $width . '"/>';
            return '<div class="browsershot mshot"><a href="' . $url . '" target="' . $target . '">' . $image . '</a></div>';
        }
    }

    /**
     *
     * @param string $url
     * @param init $width
     * @return string / false
     */
    public static function bm_mshot($url = null, $width = 250) {

        if (isset($url)) {
            return 'http://s.wordpress.com/mshots/v1/' . urlencode(esc_url($url)) . '?w=' . $width;
        } else {
            return false;
        }
    }

    /**
     * add browser shots
     */
    public static function browsershots() {
        add_shortcode('browsershot', array('cwp', 'bm_sc_mshot'));
    }

    /**
     * updates options stored in an array format
     * <code>
     * cwp::update_option_key('option_name','my_key','new_value');
     * </code>
     */
    public static function update_option_key($option_name, $key, $value) {
        $opts = get_option($option_name);
        $option = isset($opts["{$key}"]) ? $opts["{$key}"] : false;
        if ($option != $value):
            $newoption = array($key => $value);
            $array = array_merge($opts, $newoption);
            update_option($option_name, $array);
        endif;
        return $opts["{$key}"];
    }



}
