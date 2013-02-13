<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CORE
 *
 * @author studio
 */
class CWP_CORE {

    public function __construct() {

    }

    public static function factory() {
        return $factory = new CWP_CORE();
    }

}

class core_media {

    //put your code here
    public function __construct() {

    }

    /**
     * Locates a file url e.g. images/video/stylesheets
     * Searches core-wp/modules plugin directory in plugin,
     * - core-WP in the stylesheet / template directory
     * - modules in the stylesheet / template directory
     * - stylesheet / template directory
     * @param string $file filename
     * @param string $dir path to file - dirname/ (w/trailing slash)
     * @return string
     */
    public static function locate($file, $dir = NULL) {
        $located = false;
        $fname = $dir . $file;
        $file = CM_URL . '/' . $fname;
        if (file_exists(get_stylesheet_directory() . '/core-wp/modules/' . $fname)):
            $file = get_stylesheet_directory_uri() . '/core-wp/modules/' . $fname;
        elseif (file_exists(get_template_directory() . '/core-wp/modules/' . $fname)):
            $file = get_template_directory_uri() . '/core-wp/modules/' . $fname;
        elseif (file_exists(get_stylesheet_directory() . '/modules/' . $fname)):
            $file = get_stylesheet_directory_uri() . '/modules/' . $fname;
        elseif (file_exists(get_template_directory() . '/modules/' . $fname)):
            $file = get_template_directory_uri() . '/modules/' . $fname;
        elseif (file_exists(get_stylesheet_directory() . $fname)):
            $file = get_stylesheet_directory_uri() . $fname;
        elseif (file_exists(get_template_directory() . $fname)):
            $file = get_template_directory_uri() . $fname;
        endif;
        if (file_exists($file)):
            return $file;
        else :
            return false;
        endif;
    }

    /**
     * Locates your modules css files
     * @param string $filename The file name
     * @param String $module_dir The name ot the module directory
     * @return String URL of the css file
     */
    public static function locate_css($filename = 'style', $module_dir = 'default') {
        $file = $filename . '.css';
        $css = self::locate($file, $module_dir . '/css/');
        return $css;
    }

}

/**
 * Description of cwp_social
 *
 * @author Studio365
 */
class cwp_social {

    //@todo modify/add network_id default (key /id)

    function __construct() {

    }

    public static function factory() {
        return new cwp_social;
    }

    public static function parse_feed($feed = null) {

        $stepOne = explode("<content type=\"html\">", $feed);
        $stepTwo = explode("</content>", $stepOne[1]);
        $tweet = $stepTwo[0];
        $tweet = str_replace('&lt;', '<', $tweet);
        $tweet = str_replace('&gt;', '>', $tweet);
        return $tweet;
    }

    public static function last_tweet($username, $prefix = '', $suffix = '') {
        $feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1";
        // Prefix - some text you want displayed before your latest tweet.
        // (HTML is OK, but be sure to escape quotes with backslashes: for example href=\"link.html\")
        //$prefix = "";
        // Suffix - some text you want display after your latest tweet. (Same rules as the prefix.)
        //$suffix = "";
        $twitterFeed = file_get_contents($feed);
        echo stripslashes($prefix) . self::parse_feed($twitterFeed) . stripslashes($suffix);
    }

    /**
     *
     * @param strig $username twitter user name
     */
    public static function latest_tweet($username) {
        include_once(ABSPATH . WPINC . '/class-simplepie.php');
        $tweet = fetch_rss("http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1");
        echo $tweet->items[0]['atom_content'];
    }

    public static function extra_contact_info($contactmethods) {

        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['feedburner_page'] = 'Feedburner Url';
        $contactmethods['facebook'] = 'Facebook Url';
        $contactmethods['facebook_page'] = 'Facebook Fan Page';
        $contactmethods['google_plus_url'] = 'Google Plus Url';
        $contactmethods['google_page_url'] = 'Google Page Url';
        $contactmethods['twitter'] = 'Twitter Url';
        $contactmethods['twitter_user'] = 'Twitter Username';
        $contactmethods['linkedin'] = 'LinkedIn';
        $contactmethods['flickr'] = 'Flickr Username';
        $contactmethods['blog'] = 'Blog Url';
        $contactmethods['cell'] = 'Mobile Phone';
        return $contactmethods;
    }

    public static function contact_info() {
        //http://www.wprecipes.com/how-to-easily-modify-user-contact-info
        //http://thomasgriffinmedia.com/blog/2010/09/how-to-add-custom-user-contact-info-in-wordpress/
        //the_author_meta('facebook', $current_author->ID);
        add_filter('user_contactmethods', array('cwp_social', 'extra_contact_info'));
    }

    /**
     *
     * @param string $name -- twitter, facebook, google_plus, linkedin, feedburner_page
     */
    public static function connections($name = null) {
        $link = false;
        $theme_admin = (cwp::theme_options('themeadmin') ? cwp::theme_options('themeadmin') : 1);
        if (isset($name)):
            $link = the_author_meta($name, $theme_admin);
        endif;
        return $link;
    }

    /**
     *
     * @param type $user_id
     * @return string feed subscriptions url for verification
     */
    public static function feedburner_subscriptions($user_id = 1) {
        $feed = get_the_author_meta('feedburner_page', $user_id);
        //$r = explode('=', $feed);
        return "http://feedburner.google.com/fb/a/mailverify?uri={$feed}";
    }

    public static function feedburner_url($user_id = 1) {
        $feed = the_author_meta('feedburner_url', $user_id);
        $r = explode('=', $feed);
        return $feed;
    }

    public static function google_plusone($content) {
        $content = $content . '<div class="plusone"><g:plusone size="tall" href="' . get_permalink() . '"></g:plusone></div>';
        return $content;
    }

    public static function google_plusone_script() {
        wp_enqueue_script('google-plusone', 'https://apis.google.com/js/plusone.js', array(), null);
    }

    public static function add_plus_one() {
        add_action('wp_enqueue_scripts', array('cwp_social', 'google_plusone_script'));
        add_filter('the_content', array('cwp_social', 'google_plusone'));
    }

    public static function plusone() {
        self::google_plusone_script();
        $content = '<div class="plusone"><g:plusone size="tall" href="' . get_permalink() . '"></g:plusone></div>';
        return $content;
    }

    /**
     *
     * FB html5 share
     * @param Array $data - href,faces,width,font
     * @return type output html/js
     */
    public static function fb_like($data = null) {
        $faces = isset($data['faces']) ? $data['faces'] : 'true';
        $href = isset($data['href']) ? $data['href'] : site_url();
        $width = isset($data['width']) ? $data['width'] : '450';
        $font = isset($data['font']) ? $data['font'] : 'arial';
        ob_start();
        ?>
        <div class="fb-like" data-href="<?php echo esc_attr($href) ?>"data-send="true" data-width="<?php echo ecs_attr($width) ?>"
             data-show-faces="<?php echo esc_attr($faces) ?>" data-font="<?php echo esc_attr($font) ?>"></div>
             <?php
             return ob_get_clean();
         }

         /**
          * FB html5 share
          * Include the JavaScript SDK on your page once, ideally right after the opening <body> tag.
          * @param type $app_id
          * @return html/js
          */
         public static function fb_js($app_id = null) {
             ob_start();
             ?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo esc_attr($app_id) ?>";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <?php
        return ob_get_clean();
    }

    public static function sfc_like_button() {
        if (function_exists('sfc_like_button')) {
            sfc_like_button();
        } else {
            echo _e('Please install Simple Facebook Connect', 'corewp');
        }
    }

    public static function sfc_share_button() {
        if (function_exists('sfc_share_button')):
            sfc_share_button();
        else :
            echo _e('Please install Simple Facebook Connect', 'corewp');
        endif;
    }

    /**
     *
     * @global type $post
     * @param type $text default post title or site desctiption;
     * @param type $hashtags default sitename
     * @param type $via
     * @param type $btn_title
     */
    public static function twitter_button($text = null, $hashtags = null, $via = null, $btn_title = 'Tweet') {
        global $post;
        if (!isset($via))
            $via = get_bloginfo('name');
        if (!isset($text))
            $text = get_the_title($post->ID) ? get_the_title($post->ID) : get_bloginfo('description');
        if (!isset($hashtags))
            $hashtags = get_bloginfo('hashtags');
        ?>
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $text; ?>" data-via="@<?php echo $via; ?>" data-size="large" data-hashtags="<?php echo $hashtags; ?>">

            <?php echo $btn_title; ?> </a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <?php
    }

    public static function fb_comment_script() {
        $app_id = cwp::theme_options('fbappid');
        if ($app_id AND !empty($app_id)):
            ?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $app_id; ?>";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            </script>
            <?php
        endif;
    }

    /**
     * adds a facebook comment to your to your theme/page
     * <code>
     * <?php
     * $title "Comment and Share on Facebook"
     * cwp_social::fb_comment($title);
     * ?>
     * </code>
     * @param string $title
     * @param string $url -
     * @param init $post
     * @param init $width
     * @param string $colorscheme
     */
    public static function fb_comment($title = "Share your comment with us via Facebook", $url = null, $post = 10, $width = 600, $colorscheme = 'light') {
        $siteurl = isset($url) ? $url : get_permalink();
        add_action('wp_footer', array('cwp_social', 'fb_comment_script'));

        ob_start();
        ?>
        <div class="fb-comment-box">
            <h3><?php echo $title ?></h3>
            <div class="fb-comments" data-href="<?php echo $siteurl ?>" data-num-posts="<?php echo $post ?>" data-colorscheme="<?php echo $colorscheme ?>" data-width="<?php echo $width ?>"></div>
        </div>

        <?php
        return $content = ob_get_clean();
    }

    /**
     *
     * @param type $url_value link text or image value -default 1
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function twitter_link($url_value = 'l', $class_attr = 'social-icons font-large') {
        self::social_links('twitter', $url_value, $class_attr);
    }

    /**
     *
     * @param type $url_value link text or image value -default f
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function facebook_link($url_value = 'f', $class_attr = 'social-icons font-large') {
        self::social_links('facebook', $url_value, $class_attr);
    }

    /**
     *
     * @param type $url_value link text or image value -default g
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function gplus_link($url_value = 'g', $class_attr = 'social-icons font-large') {
        self::social_links('google_plus', $url_value, $class_attr);
    }

    /**
     *
     * @param type $url_value link text or image value -default i
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function linkedin_link($url_value = 'i', $class_attr = 'social-icons font-large') {

        self::social_links('linkedin', $url_value, $class_attr);
    }

    /**
     *
     * @param type $url_value link text or image value -default r
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function rss_link($url_value = 'r', $class_attr = 'social-icons font-large') {
        self::social_links('feedburner_page', $url_value, $class_attr);
    }

    /**
     *
     * @param type $url_value link text or image value -default 1
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function flickr_link($url_value = 'l', $class_attr = 'social-icons font-large') {
        self::social_links('twitter', $url_value, $class_attr);
    }

    /**
     *
     * @param type $network social network value - default twitter
     * @param type $url_value link text or image value -default 1
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function social_links($network = 'twitter', $url_value = 'l', $class_attr = 'social-icons font-large') {

        ob_start()
        ?>
        <a href="<?php the_author_meta($network, cwp_themeadmin()); ?>">
            <span class="<?php echo $class_attr ?>"><?php echo $url_value ?></span>

        </a>
        <?php
        echo $link = ob_get_clean();
    }

}

class cwp_social_twitter {

    private $user,
            $timeline_widget_id,
            $timeline_title;

    public function set_timeline_title($timeline_title) {
        $this->timeline_title = $timeline_title;
        return $this;
    }

    public function set_user($user) {
        $this->user = $user;
        return $this;
    }

    public function set_timeline_widget_id($timeline_widget_id) {
        $this->timeline_widget_id = $timeline_widget_id;
        return $this;
    }

    public function __construct() {

    }

    public static function factory() {
        return $factory = new cwp_social_twitter();
    }

    public function embed_timelines($user, $timeline_id) {

        add_action('wp_footer', array($this, 'timelines_js'));

        ob_start();
        ?>
        <a class="twitter-timeline" href="https://twitter.com/<?php echo $this->user ?>" data-widget-id="<?php echo $this->timeline_widget_id; ?>">
        <?php echo $this->timeline_title ?>
        </a>
            <?php
            return $content = ob_get_clean();
        }

        public function timelines_js() {
            ?>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        </script>
        <?php
    }

}

/**
 * Description of cwp_social_fb
 *
 * @author Studio365
 */
class cwp_social_fb {

    //put your code here

    private static $appID;

    public function __construct() {

    }

    public static function factory() {
        return new cwp_social_fb();
    }

    /**
     *
     * FB html5 share
     * @param Array $data - href,faces,width,font
     * @return type output html/js
     *
     */
    public function fb_like($data = null) {
        $faces = isset($data['faces']) ? $data['faces'] : 'true';
        $href = isset($data['href']) ? $data['href'] : site_url();
        $width = isset($data['width']) ? $data['width'] : '450';
        $font = isset($data['font']) ? $data['font'] : 'arial';
        ob_start();
        ?>
        <div class="fb-like" data-href="<?php echo esc_attr($href) ?>"data-send="true" data-width="<?php echo ecs_attr($width) ?>"
             data-show-faces="<?php echo esc_attr($faces) ?>" data-font="<?php echo esc_attr($font) ?>"></div>
        <?php
        return ob_get_clean();
    }

    /**
     * FB html5 share
     * Include the JavaScript SDK on your page once, ideally right after the opening <body> tag.
     * @param type $app_id
     * @return html/js
     */
    public function fb_script() {
        $app_id = cwp::theme_options('fbappid');
        if ($app_id AND !empty($app_id)):
            ?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $app_id; ?>";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            </script>
            <?php
        endif;
    }

    /**
     * <?php
     * $title "Comment and Share on Facebook"
     * cwp_social_fb::factory('010101010','So what do you think',800,5,'dark);
     * ?>
     * @param type $app_id
     * @param type $title
     * @param type $width
     * @param type $post
     * @param type $colorscheme
     * @param type $url
     * @return type
     */
    public function fb_comment($title = "Share your thoughts", $width = 600, $post = 10, $colorscheme = 'light', $url = null) {
        $siteurl = isset($url) ? $url : get_permalink();
        add_action('wp_footer', array($this, 'fb_script'));
        ob_start();
        ?>
        <div class="fb-comment-box">
            <h3><?php echo $title ?></h3>
            <div class="fb-comments" data-href="<?php echo $siteurl ?>" data-num-posts="<?php echo $post ?>" data-colorscheme="<?php echo $colorscheme ?>" data-width="<?php echo $width ?>"></div>
        </div>

        <?php
        return $content = ob_get_clean();
    }

}

/**
 * Description of ss_tools
 *
 * @author Studio365
 */
class core_functions {

    //put your code here


    function __construct() {

    }

    public static function theme_default() {
        self::favicon();
    }

    public static function getPostViews($postID = Null) {
        global $post;
        if (!isset($postID))
            $postID = $post->ID;
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 View";
        }
        return $count;
    }

    public static function setPostViews($postID = Null) {
        global $post;
        if ($postID == null)
            $postID = $post->ID;
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

    public static function breadcrumbs() {
        /**
         * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
         */
        $delimiter = '&raquo;';
        $home = 'Home'; // text for the 'Home' link
        $before = '<span class="current">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb

        if (!is_home() && !is_front_page() || is_paged()) {

            echo '<div id="crumbs">';

            global $post;
            $homeLink = get_bloginfo('url');
            echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

            if (is_category()) {
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0)
                    echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
                echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
            } elseif (is_day()) {
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
                echo $before . get_the_time('d') . $after;
            } elseif (is_month()) {
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                echo $before . get_the_time('F') . $after;
            } elseif (is_year()) {
                echo $before . get_the_time('Y') . $after;
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                    echo $before . get_the_title() . $after;
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                    echo $before . get_the_title() . $after;
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                echo $before . $post_type->labels->singular_name . $after;
            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } elseif (is_page() && !$post->post_parent) {
                echo $before . get_the_title() . $after;
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb)
                    echo $crumb . ' ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } elseif (is_search()) {
                echo $before . 'Search results for "' . get_search_query() . '"' . $after;
            } elseif (is_tag()) {
                echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo $before . 'Articles posted by ' . $userdata->display_name . $after;
            } elseif (is_404()) {
                echo $before . 'Error 404' . $after;
            }

            if (get_query_var('paged')) {
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo ' (';
                echo __('Page') . ' ' . get_query_var('paged');
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo ')';
            }

            echo '</div>';
        }
    }

    /**
     *
     * @global int $paged
     * @global string $wp_query
     * @param <type> $pages
     * @param <type> $range
     * @link http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
     * @link http://design.sparklette.net/teaches/how-to-add-wordpress-pagination-without-a-plugin/
     */
    public static function pagination($wp_query = null) {
        if (!isset($wp_query))
            global $wp_query;
        //set the paging methods
        if (is_front_page()):
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        else :
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        endif;

        if ($wp_query->max_num_pages > 1) :
            echo '<div class="wp-pagination">';
            $big = 999999999;
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, $paged),
                'total' => $wp_query->max_num_pages
            ));
            echo '</div>';
        endif;
    }

    /**
     *
     * @global int $paged
     * @global string $wp_query
     * @param <type> $pages
     * @param <type> $range
     * @link http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
     * @link http://design.sparklette.net/teaches/how-to-add-wordpress-pagination-without-a-plugin/
     */
    public static function pagination_plus($pages = '', $range = 4) {
        $showitems = ($range * 2) + 1;

        global $paged;
        if (empty($paged))
            $paged = 1;

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages) {
            echo "<ul class=\"pagination\"><li>Page " . $paged . " of " . $pages . "</li>";
            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
                echo "<li><a href='" . get_pagenum_link(1) . "'>&laquo; First</a></li>";
            if ($paged > 1 && $showitems < $pages)
                echo "<li><a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; Previous</a></li>";

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    echo ($paged == $i) ? "<li class=\"current\">" . $i . "</li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"unavailable\">" . $i . "</li></a>";
                }
            }

            if ($paged < $pages && $showitems < $pages)
                echo "<li><a href=\"" . get_pagenum_link($paged + 1) . "\">Next &rsaquo;</a></li>";
            if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
                echo "<li><a href='" . get_pagenum_link($pages) . "'>Last &raquo;</a><li>";
            echo "</ul>\n";
        }
    }

    public function add_theme_favicon() {
        //get_stylesheet_directory_uri();
        $file = CWP_URL . '/images/favicon.ico';
        if (file_exists(get_stylesheet_directory() . '/images/favicon.ico')):
            $file = get_stylesheet_directory_uri() . '/images/favicon.ico';
        elseif (file_exists(get_template_directory() . '/images/favicon.ico')) :
            $file = get_template_directory_uri() . '/images/favicon.ico';
        endif;
        echo '<link rel="shortcut icon" href="' . $file . '" >';
    }

    public static function favicon() {
        add_action('wp_head', array('core_functions', 'add_theme_favicon'));
        add_action('admin_head', array('core_functions', 'add_theme_favicon'));
    }

    public static function time_ago($trail_text = 'ago') {
        $t = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . $trail_text;
        return $t;
    }

    public static function time_ago_comments() {
        return $t = human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ago';
    }

    public static function tweet($data = null, $name = "Tweet") {
        ob_start()
        ?>
        <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>" data-count="vertical" data-via="<?php $data; ?>"> <?php echo $name ?></a>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

    /**
     *
     * @global type $post
     * @param type $length
     * @uses print_excerpt(50);
     */
    public static function print_excerpt($length = 100) { // Max excerpt length. Length is set in characters
        global $post;
        $text = $post->post_excerpt;
        if ('' == $text) {
            $text = get_the_content('');
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]>', $text);
        }
        $text = strip_shortcodes($text); // optional, recommended
        $text = strip_tags($text); // use ' $text = strip_tags($text,' <p><a>'); ' if you want to keep some tags</p><p>
        $text = substr($text, 0, $length);
        $excerpt = self::reverse_strrchr($text, '.', 1);
        if ($excerpt) {
            echo apply_filters('the_excerpt', $excerpt);
        } else {
            echo apply_filters('the_excerpt', $text);
        }
    }

    public static function reverse_strrchr($haystack, $needle, $trail) {
        return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
    }

    public static function editor() {

        add_editor_style('post_css');
    }

    function fb_move_admin_bar() {
        echo '
    <style type="text/css">
    body {
    margin-top: -28px;
    padding-bottom: 28px;
    }
    body.admin-bar #wphead {
       padding-top: 0;
    }
    body.admin-bar #footer {
       padding-bottom: 28px;
    }
    #wpadminbar {
        top: auto !important;
        bottom: 0;
    }
    #wpadminbar .quicklinks .menupop ul {
        bottom: 28px;
    }
    </style>';
    }

// on backend area
//add_action( 'admin_head', 'fb_move_admin_bar' );
// on frontend area
    public static function admin_bar_footer() {
        add_action('wp_head', array('core_functions', 'fb_move_admin_bar'));
    }

    public static function hide_bar_admin() {
        add_filter('show_admin_bar', '__return_false');
    }

    /**
     * Add all post format support
     * @param array $array -default : 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status'
     */
    public static function all_post_formats($array = array('aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat')) {
        add_theme_support('post-formats', $array);
    }

    /**
     *
     * @param string $theme_name
     * @param string $option_value
     */
    public function theme_activation($theme_name = null, $option_value = 'yes') {
        $theme = $theme_name . '_activated';
        if (get_option($theme) != $option_value) {
            update_option($theme, $option_value);
        }
    }

    /**
     *
     * @param type $theme_name
     */
    public function theme_deactivation($theme_name = null) {
        $theme = $theme_name . '_activated';
        delete_option($theme);
    }

    public static function no_smiley_face() {
        add_action('wp_head', array('core_functions', '_smiley_face'));
    }

    public function _smiley_face() {
        echo '
        <script type="text/css">
            img#wpstats {
                 display: none;
            }
        </script>';
    }

    public static function jquery($url = 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js', $version = '1.6.1') {
        if (!is_admin()) {
            // comment out the next two lines to load the local copy of jQuery
            wp_deregister_script('jquery');
            wp_register_script('jquery', $url, false, $version);
            wp_enqueue_script('jquery');
        }
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

    public static function extra_contact_info($contactmethods) {
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['facebook'] = 'Facebook';
        $contactmethods['twitter'] = 'Twitter';
        $contactmethods['linkedin'] = 'LinkedIn';
        $contactmethods['flickr'] = 'Flickr';

        return $contactmethods;
    }

    public static function add_contact_info() {
        //http://www.wprecipes.com/how-to-easily-modify-user-contact-info
        //http://thomasgriffinmedia.com/blog/2010/09/how-to-add-custom-user-contact-info-in-wordpress/
        //the_author_meta('facebook', $current_author->ID);
        add_filter('user_contactmethods', array('core_functions', 'extra_contact_info'));
    }

}