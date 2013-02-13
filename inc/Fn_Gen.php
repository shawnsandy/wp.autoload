<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FUNC_Theme
 *
 * @author studio
 */
class FN_Gen {

    private $image_quality = 100,
            $excerpt_lenght = 40,
            $title,
            $post_type,
            $width,
            $height,
            $user,
            $user_ID,
            $user_email,
            $post_id,
            $post_slug,
            $post_category;

    public function __construct() {

    }

    public static function load() {
        return new FN_Gen();
    }

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     * Create your own twentyeleven_posted_on to override in a child theme
     *
     * @since Twenty Eleven 1.0
     */
    public function twentyeleven_posted_on($slug = 'Posted on') {
        printf(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven'), esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s', 'twentyeleven'), get_the_author())), get_the_author()
        );
    }

    public function custom_background($image = '/images/default-background.png') {
        add_theme_support('custom-background', array(
            'default-image' => get_template_directory_uri() . $image,
        ));
    }

}

class Fn_Post extends Fn_Gen {

    function __construct() {
        parent::__construct();
    }

    public static function load() {
        return new Fn_Post();
    }

    public function excerpt_length($excerpt_length = 100) {
        add_filter('excerpt_length', array($this, 'excerptLength'));
    }

    public function excerptLenght() {

        return $length = $excerpt_length;
    }

    public function pagination() {
        /**
         * @link http://wp.smashingmagazine.com/2011/05/10/new-wordpress-power-tips-for-template-developers-and-consultants/
         */
        global $wp_query;
        $total = $wp_query->max_num_pages;
// only bother with the rest if we have more than 1 page!
        if ($total > 1) {
            // get the current page
            if (!$current_page = get_query_var('paged'))
                $current_page = 1;
            // structure of "format" depends on whether we're using pretty permalinks
            $permalink_structure = get_option('permalink_structure');
            $format = empty($permalink_structure) ? '&page=%#%' : 'page/%#%/';
            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => $format,
                'current' => $current_page,
                'total' => $total,
                'mid_size' => 4,
                'type' => 'list'
            ));
        }
    }

}

class Fn_Images extends Fn_Gen {

    function __construct() {
        parent::__construct();
    }

    public static function factory() {
        $factory = new Fn_Images();
        return $factory;
    }

    /**
     * Replace <p>img</p> with <figure>img</img>
     * better
     */
    public static function image_figure() {

        add_filter('the_content', array("Fn_Images",'fb_unautop_4_img'), 99);
    }

    // unautop for images
    function fb_unautop_4_img($content) {

        $content = preg_replace(
                '/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $content
        );

        return $content;
    }

    /**
     *
     * @param init $quality set  the WP jpeg image quality default 100
     * @return type
     */
//    public function image_compression($quality = 100) {
//        add_filter('jpeg_quality', function($arg) {
//                    return $quality;
//                });
//        return $this->image_quality = $quality;
//    }

    /**
     * Removes images width and heights attrs great for fluid images
     */
    public function fluid_images() {
        add_filter('image_send_to_editor', array($this, 'no_image_dimensions'), 10);
        add_filter('post_thumbnail_html', array($this, 'no_image_dimensions'), 10);
    }

    public function no_image_dimensions($content) {
        $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $content);
        return $html;
    }

    public function jquery_remove_img_dimesions($selector_id = null) {
        $id = isset($selector_id) ? $selector_id . ' ' : null;
        ob_start();
        ?>
        <script type="text/javascript">
            jQuery.noConflict();
            jQuery(document).ready(function($){

                $("<?php echo $id ?> img").each(function(){
                    $(this).removeAttr('width')
                    $(this).removeAttr('height');
                });

            });
        </script>
        <?php
        return $contents = ob_get_clean();
    }

}

class Fn_Admin {

    function __construct() {
        parent::__construct();
    }

    public static function load() {
        return $factory = new FN_Admin();
    }

    function change_editor_title($title) {
        $screen = get_current_screen();
        if ('post' == $screen->post_type) {
            $title = 'Enter Pricing CPT Title';
        }
        return $title;
    }

    public function change_() {
        add_filter('enter_title_here', array($this, 'change_default_title'));
    }

}

