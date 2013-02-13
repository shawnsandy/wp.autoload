<?php


/**
 * Description of Gallery
 *
 * @author studio
 */


class Post_Gallery extends Post_Query {

    public function __construct() {

        parent::__construct();

    }

    private $post_ID = null,
            $post_order,
            $post_orderby;

    public function set_post_ID($post_ID) {
        $this->post_ID = $post_ID;
    }

    public function set_post_order($post_order) {
        $this->post_order = $post_order;
    }

    public function set_post_orderby($post_orderby) {
        $this->post_orderby = $post_orderby;
    }


    public static function factory($template_slug = 'gallery', $template_name = '') {
        parent::factory($template_slug, $template_name);
        return new Post_Gallery();
    }

    public function images($post_order = 'ASC', $post_orderby = 'menu_order_ID'){

        global $post;

        $this->post_order = $post_order;
        $this->post_orderby = $post_orderby;
        /** never display pagination */
        $this->display_pagination = false;

        /** get the post id if it not set */
        if(!isset($this->post_ID))
            $this->post_ID = $post->ID;

        /** then the parent post thumbnail id **/
        $thumb = get_post_thumbnail_id($this->post_ID);

        /** set the query arguments */
        $this->query = array(
            'post_parent' => $this->post_ID,
            'post_status' => 'inherit',
            'post_mimetype' => 'image',
            'order' => $this->post_order,
            'orderby' =>$this->post_orderby,
            'post_per_page' => $this->post_per_page,
            'post_not_in' => array($thumb),
            'update_post_term_cache' => false
        );

        /** display the post loop **/
        $this->the_posts();

    }

//    public function galleries(){
//
//    }

}


//Post_Gallery::factory('gallery')->images();