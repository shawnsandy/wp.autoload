<?php
// Prevent loading this file directly
defined('ABSPATH') || exit;

/**
 * Description of BJ_shortcodes
 *
 * @author studio
 */
class BJ_Shortcodes {

    public function __construct() {

    }

    public static function add() {
        return $factory = new BJ_Shortcodes();
    }

    public function shortcode($tag = null, $func = null) {
        add_shortcode($tag, array($this, $func));
    }

    public function fixie($atts, $content = null) {

        extract(shortcode_atts(array(
                    'element' => '',
                        ), $atts));
        $fixie = BJ::fixie($element);
        return $fixie;
    }

    public static function browser_shot($attributes, $content = '', $code = '') {

        extract(shortcode_atts(array(
                    'url' => '',
                    'width' => 250,
                    'target' => '_blank',
                        ), $attributes));

        $imageUrl = BJ_Shortcodes::bm_mshot($url, $width);

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

    public static function recent_posts($atts) {
        extract(shortcode_atts(array(
                    'posts' => 1,
                        ), $atts));

        $return_string = '<ul>';
        $args = array('orderby' => 'date', 'order' => 'DESC', 'showposts' => $posts);
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $return_string .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            endwhile;
        endif;
        $return_string .= '</ul>';
        wp_reset_postdata();
        return $return_string;

    }

    public static function related_post() {
        //for use in the loop, list 5 post titles related to first tag on current post
        global $post;
        $tags = wp_get_post_tags($post->ID);
        if ($tags) {
            echo 'Related Posts';
            $first_tag = $tags[0]->term_id;
            $args = array(
                'tag__in' => array($first_tag),
                'post__not_in' => array($post->ID),
                'showposts' => 5,
                'caller_get_posts' => 1
            );
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    ?>
              <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
                    <?php
                endwhile;
            }
        }
    }

    public function gallery(){

    }

}

