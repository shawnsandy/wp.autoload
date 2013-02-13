<?php

/**
 * Description of BJ_POSTGALLERY
 * ceate gallaries using wp_query
 *
 * @author studio
 */
class BJ_POSTGALLERY {

    private $ID = null,
            $order = 'ASC',
            $total_thumbnails,
            $post_type = 'post',
            $template_slug = 'gallery',
            $post_per_page = -1,
            $template_name,
            $template_dir = 'views';

    public function set_template_dir($template_dir) {
        $this->template_dir = $template_dir;
        return $this;
    }

    public function set_template_name($template_name) {
        $this->template_name = $template_name;
        return $this;
    }

    public function set_template_slug($template_slug) {
        $this->template_slug = $template_slug;
        return $this;
    }

    public function set_post_per_page($post_per_page) {
        $this->post_per_page = $post_per_page;
        return $this;
    }

    public function get_post_type() {
        return $this->post_type;
    }

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
    }

    public function set_ID($ID) {
        $this->ID = $ID;
        return $this;
    }

    public function set_order($order) {
        $this->order = $order;
        return $this;
    }

    public function set_total_thumbnails($total_thumbnails) {
        $this->total_thumbnails = $total_thumbnails;
        return $this;
    }

    public function get_total_thumbnails() {
        return $this->total_thumbnails;
    }

    public function __construct() {

    }

    public static function factory() {
        $factory = new BJ_POSTGALLERY();
        $factory->set_template_slug($template_slug);
        $factory->set_post_per_page($post_per_page);
        return $factory;
    }

    /**
     * Create a page gallery
     * @global type $post
     */
    public function images() {

        global $post;
        //if $ID NULL use the global post->ID
        if (!isset($this->ID))
            $this->ID = $post->ID;
        //get the post thumbnail ID
        $thumb_id = get_post_thumbnail_id($this->ID);
        //image query
        $images = new WP_Query(array(
                    'post_parent' => $this->ID,
                    'post_status' => 'inherit',
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'order' => $this->order,
                    'orderby' => 'menu_order ID',
                    'posts_per_page' => $this->post_per_page,
                    'post__not_in' => array($thumb_id),
                    'update_post_term_cache' => false,
                ));

        if ($images->have_posts()):
            while ($images->have_posts()):
                $images->the_post();
                bj_layout::get_template_part($this->template_slug, $this->template_name, $this->template_dir);
            endwhile;
        endif;
    }

    /**
     * Displays post index/archive with post-format-gallery and category(s) gallery
     * @global type $query_string
     */
    public function posts() {

        global $query_string;

        $args = wp_parse_args($query_string);

        $query = array(
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'post_format',
                    'terms' => array('post-format-gallery'),
                    'field' => 'slug',
                ),
                array(
                    'taxonomy' => 'category',
                    'terms' => array('gallery'),
                    'field' => 'slug',
                ),
            ),
            //'paged' => $args['paged'],
            'post_type' => $this->post_type,
        );

        query_posts($query);
        if (have_posts()):
            while (have_posts()):
            bj_layout::get_template_part($this->template_slug, $this->template_name, $this->template_dir);
            endwhile;
        endif;
        wp_reset_query();
    }

}
