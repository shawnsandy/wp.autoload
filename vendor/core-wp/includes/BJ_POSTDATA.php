<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BJ_POSTDATA
 *
 * @author studio
 */
class BJ_POSTDATA {

    private $query = null,
            $wp_query = array('posts_per_page' => 5),
            $query_thumbnail_posts = array('meta_key' => '_thumbnail_id', 'showposts' => 5, 'post_type' => 'post'),
            $template_name = '',
            $template_slug = 'content',
            $base_directory = 'views',
            $post_per_page = 4,
            $blank_tpl = 'no-post',
            $blank_tpl_name = '';

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

    public function set_query_thumbnail_posts($query_thumbnail_posts) {
        $this->query_thumbnail_posts = $query_thumbnail_posts;
        return $this;
    }

    public function set_base_directory($base_directory) {
        $this->base_directory = $base_directory;
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

    public function get_base_directory() {
        return $this->base_directory;
    }

    public function get_post_per_page() {
        return $this->post_per_page;
    }

    public function __construct() {

    }

    /**
     *
     * @return type
     */
    public static function factory() {
        $factory = new BJ_POSTDATA();
        return $factory;
    }

    /**
     * run query
     */
    public function loop() {

        $this->get_post();

        if (have_posts()):
            while (have_posts()):
                the_post();
                //if the slug is post_type use the post type name for slug and post format for the name
                if ($this->template_slug == 'post_type'):
                    bj_layout::get_template_part(get_post_type(), get_post_format(), $this->base_directory);
                //if the name is format will use the post format for the template name
                elseif ($this->template_name == 'format'):
                    bj_layout::get_template_part($this->template_slug, get_post_format(), $this->base_directory);
                else:
                    bj_layout::get_template_part($this->template_slug, $this->template_name, $this->base_directory);
                endif;
            endwhile;
        else :
            //cwp_layout::tpl_part(null, 'no_post');
            bj_layout::get_template_part($this->blank_tpl, $this->blank_tpl_name ,  $this->base_directory);
        endif;
        wp_reset_query();
    }

    /**
     * runs the pre_get_post for queries in the loop
     */
    public function get_post(){
      /**
         * built the query using pre_get_post@link URL description
         */
        if (isset($this->query)):
           add_action( 'pre_get_posts', array($this,'modify_loop') );
        endif;
    }

    public function modify_loop($query){
        if($query->is_main_query()):
            foreach($this->query as $key => $value):
            $query->set($key,$value);
            endforeach;
        endif;
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
    public function query() {

        global $wp_query;

        $query = new WP_Query($this->wp_query);
        //$wp->query();
        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                //if the slug is post_type use the post type name for slug instead of default content
                if ($this->template_slug == 'post_type'):
                    bj_layout::get_template_part(get_post_type(), get_post_format(), $this->base_directory);
                //if the name is format will use the post format for the template name
                elseif ($this->template_name === 'format'):
                    bj_layout::get_template_part($this->template_slug, get_post_format(), $this->base_directory);
                else:
                    bj_layout::get_template_part($this->template_slug, $this->template_name, $this->base_directory);
                endif;
            endwhile;
        else :
            bj_layout::get_template_part($this->blank_tpl, $this->blank_tpl_name ,  $this->base_directory);
        endif;
        wp_reset_postdata();
        //wp_reset_query();
    }

    public static function fluid_grid($query = null, $tpl_slug = 'masonry') {
        /**
         * custom home page contene
         */
        if (is_front_page()):
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        else :
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        endif;
        if (!isset($query))
            $query = array('posts_per_page' => 10, 'paged' => $paged)
            ?>

        <?php
        $bjc_home_args = array('posts_per_page' => 10, 'paged' => $paged);
        $p_query = new WP_Query();
        $p_query->query($query);

        while ($p_query->have_posts()):
            $p_query->the_post();
            bj_layout::get_template_part($tpl_slug, get_post_format(), 'views');
        endwhile;
        ?>
        </div>
        <div class="row">
            <div class="span12">
        <?php //echo $paged; //check the page value   ?>

                <?php
                if (function_exists('wp_pagenavi'))
                    wp_pagenavi(array('query' => $p_query));
                wp_reset_postdata();
                ?>
            </div>

        <?php
    }


}

class BJ_POSTDATA_Thumbnails extends BJ_POSTDATA {

    public function __construct() {
        parent::__construct();
    }

    private $qty = 5,
            $post_type = 'post',
            $thumb_size = 'thumbnail',
            $text = 'title',
            $tpl = null,
            $excerpt_length = 20;

    public function set_qty($qty) {
        $this->qty = $qty;
        return $this;
    }

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    public function set_thumb_size($thumb_size) {
        $this->thumb_size = $thumb_size;
        return $this;
    }

    public function set_text($text) {
        $this->text = $text;
        return $this;
    }

    public function set_tpl($tpl) {
        $this->tpl = $tpl;
        return $this;
    }

    public function set_excerpt_lenght($excerpt_lenght) {
        $this->excerpt_length = $excerpt_lenght;
        return $this;
    }

    public function the_post() {
        $q_args = array(
            'meta_key' => '_thumbnail_id',
            'showposts' => $this->qty,
            'post_type' => $this->post_type,
        );
        $t_query = new WP_Query($q_args);
        if ($t_query->have_posts()):
            while ($t_query->have_posts()):
                $t_query->the_post();
                $thumbnail = the_post_thumbnail($this->thumb_size);
                $excerpt_lenght = $this->excerpt_length;
                if (isset($this->tpl)):
                    /*
                     * use the tpl if it is set tpl/views/$tpl.php
                     */
                    bj_layout::get_template_part($this->tpl);
                else:
                    ?>
                        <div class="recent-thumbs">
                            <span class="recent-thumb">
                    <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php echo get_permalink(get_the_ID()); ?>" title="">
                                    <?php echo $thumbnail; ?>
                                    </a>
                                    <?php endif ?>
                            </span>
                                <?php if ($this->text == 'excerpt'): ?>
                                <span class="recent-thumb-desc">
                                    <a href="<?php echo get_permalink(get_the_ID()); ?>" title="">
                                        <strong><?php the_title(); ?></strong>
                                    </a>
                        <?php echo wp_trim_words(get_the_excerpt(), $excerpt_lenght, '...'); ?>
                                </span>
                                <?php else : ?>
                                <span class="recent-thumb-desc">
                                    <a href="<?php echo get_permalink(get_the_ID()); ?>" title="">
                                        <strong><?php the_title(); ?></strong>
                                    </a>
                                </span>
                    <?php endif; ?>
                            <br class="clear"/>
                        </div>
                <?php
                endif;
            endwhile;
        endif;
        wp_reset_postdata();
    }


}

