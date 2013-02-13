<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * A simple and easy to use set of templates tags and function for BaseJump WP theme Kit
 *
 * @author studio
 */
class BJ {

    public function __construct() {

    }

    /**
     * Displays themes site logo
     * @param type $img_url default logo img url
     * @return string hmtl img of site name or set $img_url
     */
    public static function site_logo($img_url = null) {
        $logo = get_theme_mod('bjc_logo');
        if (!empty($logo)):
            echo '<figure class="site-logo"><img src="' . $logo . '" alt="' . get_bloginfo('name') . '"  ></figure>';
        elseif (isset($img_url)):
            echo '<figure class="site-logo"><img src="' . $img_url . '" alt="' . get_bloginfo('name') . '"  ></figure>';
        else :
            echo get_bloginfo('name');
        endif;
        BJ_ACTIONS::bj_logo_slug();
    }

    /**
     * Displaye the site slug of the default description
     * @return type
     */
    public static function site_slug() {
        $description = get_bloginfo('description');
        return $slug = get_theme_mod('bjc_site_slug', $description);
    }

    public static function footer_info() {
        ?>
        <?php do_action('bj_credits'); ?>
        <p class="footer-slug">
            <?php echo esc_textarea($bjc_fslug = get_theme_mod('bjc_footer_slug')); ?>
        </p>
        <p class="copyrignt-info">
        <p class="copyright">&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>.
            <?php echo esc_textarea($bjc_cslug = get_theme_mod('bjc_copyright_slug', __('All rights reserved', 'bj'))); ?>

        </p>

        </p>

        <!-- ###### -->

        <?php
        $bjc_copyinfo = get_theme_mod('bjc_enable_copyinfo');
        if (empty($bjc_copyinfo)):
            ?>
            <a href="http://wordpress.org/" title="<?php esc_attr_e('A Semantic Personal Publishing Platform', 'bj'); ?>" rel="generator"><?php printf(__('Proudly powered by %s', 'bj'), 'WordPress'); ?></a>
            <span class="sep"> | </span>
            <?php printf(__('Theme: %1$s by %2$s.', 'bj'), 'bj', '<a href="http://shawnsandy.com/" rel="designer">ShawnSandy.com</a>'); ?>
        <?php else : ?>
            <!--     <?php printf(__('Proudly powered by %s', 'bj'), 'WordPress'); ?>      -->
            <!--     <?php printf(__('Theme: %1$s by %2$s.', 'bj'), 'bj', '<a href="http://shawnsandy.com/" rel="designer">ShawnSandy.com</a>'); ?>       -->
        <?php endif; ?>
        <?php
    }

    public static function contact_org() {
        ?>

        <address>
            <span class="bjc-contact-message">
                <?php echo get_theme_mod('bjc_contact_message') ?></br>
            </span>
            <strong><?php echo get_theme_mod('bjc_org_name'); ?></strong><br>
            <?php echo get_theme_mod('bjc_contact_address') ?>
            <br>
            <?php echo get_theme_mod('bjc_contact_city') . '  ' . get_theme_mod('bjc_contact_zip') . ' ' . get_theme_mod('bjc_contact_zip'); ?>
            <br>
            <abbr title="Phone">P:</abbr> <?php echo get_theme_mod('bjc_contact_tel'); ?>
        </address>

        <?php
    }

    public static function contact_author() {

        global $post;
        if (!is_single() OR !is_page())
            return false;
        $author = $post->post_author;
        ?>
        <address>
            <strong><?php echo get_the_author_meta('first_name', $author) . ' ' . get_the_author_meta('last_name', $author); ?></strong><br>
            <a href="mailto:#"><?php echo antispambot(get_the_author_meta('user_email', $author)); ?></a>
        </address>
        <?php
    }

    public static function flickr_badge($flickrID = null, $postcount = 9, $display = 'latest', $type = 'user') {
        if (isset($flickrID)):
            ?>
            <div id="bj-flickr-badge">
                <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
            </div>
            <?php
        else :
            echo "Flickr ID required";
        endif;
        
    }

    /**
     * Find the location og file
     * @param type $file
     * @return string
     */
    public static function locate_uri($file = NULL) {
        if (!isset($file))
            return false;
        $located = FALSE;
        if (file_exists(get_stylesheet_directory() . '/' . $file)) {
            $located = get_stylesheet_directory_uri() . '/' . $file;
        } else if (file_exists(get_template_directory() . '/' . $file)) {
            $located = get_template_directory_uri() . '/' . $file;
        }
        return $located;
    }

    public static function fixie($element = null) {

        wp_enqueue_script('fixie');

        switch ($element) {
            case 'h1':
                $content = '<h1 class="fixie"></h1>';
                break;
            case 'h2':
                $content = '<h2 class="fixie"></h2>';
                break;
            case 'h3':
                $content = '<h31 class="fixie"></h3>';
                break;
            case 'h4':
                $content = '<h4 class="fixie"></h4>';
                break;
            case 'h5':
                $content = '<h5 class="fixie"></h5>';
                break;
            case 'h6':
                $content = '<h6 class="fixie"></h6>';
                break;
            case 'article' :
                $content = '<article class="fixie"></article>';
                break;
            case 'section':
                $content = '<section class="fixie"></section>';
                break;
            case 'a':
                $content = '<a class="fixie"></a>';
                break;
            default:
                $content = '<p class="fixie"></p>';
                break;
        }
        echo $content;
    }

    /**
     * Display a place holder images in your blog
     * use array with sizes for desktop tablet and phone required to display on each device
     * @param array $size : array( 'desktop' => '300x200', 'tablet' => '300x200', 'phone' => '300x200' )
     * @param string $color : #000:#fff (background/foreground)
     * @param string $text
     */
    public static function img_placeholder($size = array('desktop' => '300x200'), $color = '#000:#fff', $text = 'SAMPLE-IMAGE') {
        //@link http://imsky.github.com/holder/

        wp_enqueue_script('holder-js');

        if (isset($size['desktop']))
            echo $content = '<figure class="img-placeholder visible-desktop" ><img  data-src="holder.js/' . $size['desktop'] . '/' . $color . '/' . $text . '"></figure>';

        if (isset($size['tablet']))
            echo $content = '<figureclass="img-placeholder visible-tablet" ><img  data-src="holder.js/' . $size['tablet'] . '/' . $color . '/' . $text . '"></figure>';

        if (isset($size['phone']))
            echo $content = '<figure class="img-placeholder visible-phone" ><img  data-src="holder.js/' . $size['phone'] . '/' . $color . '/' . $text . '"></figure>';

    }

    /**
     * display a default post thumbnail.
     */
    public static function default_post_thumbanils() {
        add_filter('post_thumbnail_html', array('BJ', 'default_thumbnail'));
    }

    function default_thumbnail($html) {
        global $_wp_additional_image_sizes;
        $isize = $_wp_additional_image_sizes;
        $w = $isize['post-thumbnail']['width'];
        $h = $isize['post-thumbnail']['height'];
        if (empty($html)) {
            $html = '<figure class="default-post-thumbnail">';
            $html .= '<img src="http://placehold.it/' . $w . 'x' . $h . '" alt="" />';
            $html .='</figure>';
        }
        return $html;
    }

    public static function posts_summary($ps_query = null, $length = 55) {
        if (!isset($ps_query))
            $q_args = array('showposts' => 5, 'post__not_in' => get_option('sticky_posts'));
        $q_args = $ps_query;
        $t_query = new WP_Query($q_args);
        if ($t_query->have_posts()):
            while ($t_query->have_posts()):
                $t_query->the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'general');

//                if ($tpl_slug == 'post_type')
//                    $tpl_slug = $post_type;
//                if ($tpl_slug == 'format')
//                    $tpl_slug = $post_format;
//
//                $slug = isset($tpl_slug) ? $tpl_slug : 'base';
//                $name = isset($tpl_name) ? $tpl_name : 'general';
                //cwp_layout::tpl_part($slug, $name);
                ?>

                <div class="post-summary">
                    <!-- ###### -->
                    <h3 class="post-summary-title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>">
                            <?php the_title() ?>
                        </a>
                    </h3>
                    <p class="post-summary">
                        <?php echo wp_trim_words($text = get_the_excerpt(), $length); ?>
                    </p>
                </div>
                <!-- ###### -->
                <?php
            endwhile;
        else :
            cwp_layout::tpl_part(null, $def_tpl);
        endif;
        wp_reset_postdata();
    }

    public static function image_navigation() {
        ?>
        <nav id="image-navigation">
            <span class="previous-image"><?php previous_image_link(false, __('&larr; Previous', '_s')); ?></span>
            <span class="next-image"><?php next_image_link(false, __('Next &rarr;', '_s')); ?></span>
        </nav><!-- #image-navigation -->

        <?php
    }

    public static function tag_list($name = 'Tags') {

        $tags = get_tags();
        echo '<ul class="tag-list"><li>' . $name . '</li>';
        foreach ($tags as $tag):
            $tag_link = get_tag_link($tag->term_id);
            ?>
            <li><a href="<?php echo $tag_link ?>" ><?php echo esc_attr($tag->name); ?></a></li>
            <?php
        endforeach;
        echo '<ul>';
    }

    /**
     * Display  post tagged featured or highlights
     * @param array $query - wp_query
     * @param string $tpl tpl name
     */
    public static function highlights($query = array('showposts' => 5, 'tag' => 'featured,highlights'), $tpl = 'highlights') {

        //$query_highlights = array('showposts' => 3);
        BJ_POSTDATA::factory()
                ->set_template_slug($tpl)
                ->set_wp_query($query)
                ->query();
    }

    public static function google_authorship($user_id = null, $meta_field = '1') {
        echo '<link rel="author" href="' . get_theme_mod('bjc_gplus_url') . '" />';
    }

    public static function twitter_card() {
        global $post;
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        if (is_single() || is_page()):
            setup_postdata($post);
            ?>
            <meta name="twitter:card" content="summary">
            <meta name="twitter:site" content="@<?php echo $site = get_theme_mod('bjc_twitter_username'); ?>">
            <meta name="twitter:creator" content="@<?php echo get_the_author_meta('twitter_user'); ?>">
            <meta name="twitter:url" content="<?php echo get_permalink(); ?>">
            <meta name="twitter:title" content="<?php echo get_the_title() ?>">
            <meta name="twitter:description" content="<?php echo esc_html(get_the_excerpt()); ?>">
            <meta name="twitter:image" content="<?php echo $img[0] ?>">

            <?php
        endif;
    }

    public static function tweets($twitter_user = null, $quantity = 3) {

        if (!isset($twitter_user))
            $twitter_user = get_theme_mod('bjc_twitter_username', 'shawnsandy');


        include_once(ABSPATH . WPINC . '/feed.php');
        $rss = fetch_feed('https://api.twitter.com/1/statuses/user_timeline.rss?screen_name=shawnsandy');
        $maxitems = $rss->get_item_quantity($quantity);
        $rss_items = $rss->get_items(0, $maxitems);
        ?>

        <ul>
            <?php
            if ($maxitems == 0)
                echo '<li>No items.</li>';
            else
// Loop through each feed item and display each item as a hyperlink.
                foreach ($rss_items as $item) :
                    ?>
                    <li>
                        <a href='<?php echo $item->get_permalink(); ?>'>
                <?php echo $item->get_title(); ?>
                        </a>
                    </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    public static function register_metaboxes($meta_boxes = array()) {

        // Make sure there's no errors when the plugin is deactivated or during upgrade
//	if ( !class_exists( 'RW_Meta_Box' ) && !is_array($meta_boxes) )
//		return;


        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }

}

