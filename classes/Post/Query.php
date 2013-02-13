<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Data
 *
 * @author studio
 */
class Post_Query {

    protected
            /** the query arguments */
            $query = null,
            /** template name */
            $template_name = '',
            /** template slug */
            $template_slug = 'content',
            /** number of post per page */
            $post_per_page = 4,
            /** tpl slug for empty queries */
            $blank_tpl = 'no-post',
            /** tpl name for empty quires */
            $blank_tpl_name = '',
            /** bool display pagination default = false */
            $display_pagination = false,
            /** custom query */
            $custom_query = false,
            /**  the current page number */
            $current_page,
            /** pagination previous text */
            $prev_text = '« Previous',
            /** pagination next text */
            $next_text = 'Next';

    public function get_custom_query() {
        return $this->custom_query;
    }

    public function set_custom_query($custom_query) {
        $this->custom_query = $custom_query;
    }

    public function set_display_pagination($create_pagination) {
        $this->display_pagination = $create_pagination;
        return $this;
    }

    public function set_blank_tpl($blank_tpl) {
        $this->blank_tpl = $blank_tpl;
        return $this;
    }

    public function set_blank_tpl_name($blank_tpl_name) {
        $this->blank_tpl_name = $blank_tpl_name;
        return $this;
    }

    public function set_post_per_page($post_per_page) {
        $this->post_per_page = $post_per_page;
        return $this;
    }

    public function set_query($query) {
        $this->query = $query;
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

    /**
     * set query for wp query
     * @param array $wp_query
     * @return \BJ_POSTDATA
     */
    public function set_wp_query($wp_query) {
        $this->wp_query = $wp_query;
        return $this;
    }

    public function get_query() {
        return $this->query;
    }

    public function get_wp_query() {
        return $this->wp_query;
    }

    public function get_template_name() {
        return $this->template_name;
    }

    public function get_template_slug() {
        return $this->template_slug;
    }

    public function get_post_per_page() {
        return $this->post_per_page;
    }

    public function __construct() {

    }

    /**
     *
     * @param type $query
     * @param type $template_slug
     * @param type $template_name
     * @return \Post_Query
     */
    public static function factory() {

        $factory = new Post_Query();
        return $factory;
    }

    /**
     * The WP_Query object holds the WP_query object
     *
     * @return object - WP_Query object;
     */
    public function wp_queries() {
        $query = new WP_Query($this->query);
        $this->custom_query = $query;
        return $query;
    }

    public function pagination($query = null) {
        if (!isset($query))
            return;
        //pagination custom pagination with wp_pagenavi()
        if ($this->display_pagination && function_exists('wp_pagenavi')):
            wp_pagenavi(array('query' => $query));
        //else display pagination using wordpress paginate_links()
        elseif ($this->display_pagination) :
            //set the paging methods
            if ($query->max_num_pages > 1) :
                echo '<div class="wp-pagination">';
                $big = 999999999;
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, $paged),
                    'prev_text' => $this->prev_text,
                    'next_text' => $this->next_text,
                    'total' => $query->max_num_pages
                ));
                echo '</div>';
            endif;
        endif;
    }

    /**
     * Get the current page number using the get_query_var()
     *
     * @return type
     */
    public function get_current_page() {

        //global $wp_query;
        $paged = 1;
        if (is_front_page()):
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        else :
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        endif;
        return $this->current_page = $paged;
    }

    /**
     * run query
     */
    public function loop() {

        global $query;

        if (have_posts()):
            while (have_posts()):
                the_post();
                //if the slug is post_type use the post type name for slug and post format for the name
                if ($this->template_slug == 'post_type'):
                    get_template_part(get_post_type(), get_post_format());
                //if the name is format will use the post format for the template name
                elseif ($this->template_name == 'format'):
                    get_template_part($this->template_slug, get_post_format());
                else:
                    get_template_part($this->template_slug, $this->template_name);
                endif;
            endwhile;
        else :
            //cwp_layout::tpl_part(null, 'no_post');
            get_template_part($this->blank_tpl, $this->blank_tpl_name);
        endif;
        wp_reset_query();
    }

    /**
     * runs the pre_get_post for queries in the loop
     */
    public function pre_post() {
        /**
         * built the query using pre_get_post@link URL description
         */
        if (isset($this->query)):
            add_action('pre_get_posts', array($this, 'pre_get_posts'));
        endif;
    }

    public function pre_get_posts($query) {
        if (!$query->is_main_query())
            return;
        foreach ($this->query as $key => $value):
            $query->set($key, $value);
        endforeach;
    }

    /**
     * Run query
     * Uses WP_Query to create post loops
     * @param string / array $query
     * @param string $tpl_slug // default - base
     * @param string $tpl_name // default - general
     * @param string $def_tpl
     * <code></code>
     */
    public function query($query = null) {

        global $wp_query;

        if (isset($query) and is_array($query))
            $this->query = $query;

        //set up a default query argument array();
        if (!isset($this->query)) {
            //get the current page ready for pagination
            $this->get_current_page();
            $this->query = array('posts_per_page' => 5, 'paged' => $this->current_page);
        }

        //if the slug is post_type use the post type name for slug instead of default content
        if ($this->template_slug == 'post_type')
            $this->template_slug = get_post_type();
        //if the name is format will use the post format for the template name
        if ($this->template_name === 'format'):
            $this->template_name = get_post_format();
        endif;

        $this->the_posts();
    }

    /**
     * Get post with post thumbnails (set)
     * @param type $query
     * @param type $template_slug
     * @param type $template_name
     */
    public function query_post_thumbnails($query = null, $template_slug = 'thumbnails', $template_name = '') {

        $this->template_slug = $template_slug;
        $this->template_name = $template_name;

        if (!isset($query))
            $this->query = array(
                'meta_key' => '_thumbnail_id',
                'posts_per_page' => $this->post_per_page,
                'post_type' => 'post');

        /** get the post */
        $this->the_posts();
    }

    /**
     * the post loop
     */
    public function the_posts() {

        $post = $this->wp_queries();
        if ($post->have_posts()):
            while ($post->have_posts()):
                $post->the_post();
                get_template_part($this->template_slug, $this->template_name);
            endwhile;
        endif;
        /** add pagination */
        $this->pagination($post);
        /** now reset post fata */
        wp_reset_postdata();
    }

}