<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of theme_content
 *
 * @author Studio365
 */
class theme_content {

    //put your code here

    public $post_formats = array('gallery', 'image', 'video');
    public $post_type = "post";

    public function add() {
        return new theme_content();
    }

    public function __construct() {

    }

    /**
     * *************************POST FORMATS***********************************
     *
     */

    /**
     * sets custom post type and this post formats
     * @param type $this - 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'
     */
    public static function post_formats($post_type, $formats = array('video', 'image', 'gallery')) {
        if (!empty($post_type) AND is_array($formats)):
            $screen = get_current_screen();
            if ($screen->post_type == $post_type):
                //remove_post_type_support( 'post', 'post-formats' );
                add_theme_support('post-formats', $formats);
            endif;
        endif;
    }

    public static function portfolio() {
        $pt = new cwp_post_type('portfolio');
        $pt->set_publicly_queryable(true)
                ->set_menu_postion(5)
                ->set_public(true)
                ->set_menu_title("Portfolio")
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'portfolio'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author'))
                ->set_label("Folio")
                ->set_menu_icon(CWP_URL . '/menu-images/photography.png')
                ->register();

        self::categories('portfolio', 'cwp_portfolio');
        self::tags('portfolio', 'cwp_portfolio');
        add_action('load-post.php', array('theme_content', 'folio_formats'));
        add_action('load-post-new.php', array('theme_content', 'folio_formats'));

        //instatiate BJ_Metaboxes
        $details = BJ_METABOXES::factory();
        //create meta box fields
        $folio_fields[] = $details->text_field('_bj_folio_type', 'Project Type', 'Commercial, ProBono, Personal, Not For Profit');
        $folio_fields[] = $details->text_field('_bj_folio_client', 'Client');
        $folio_fields[] = $details->text_field('_bj_folio_url', 'Project URL');
        //set metabox setting
        $details->set_metabox_context('side');
        $details->set_metabox_fields($folio_fields);
        //create the metabox
        $details->add_metabox('bj_folio_meta','Item Details',array('cwp_portfolio'));
    }

    public function folio_formats() {
        $formats = array('image', 'gallery', 'video',);
        $post_type = 'cwp_portfolio';
        theme_content::post_formats($post_type, $formats);
    }

    public static function faq() {
        $pt = new cwp_post_type('faq');
        $pt->set_publicly_queryable(true)
                ->set_public(true)
                ->set_menu_postion(5)
                ->set_menu_title("FAQ")
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'faq'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author'))
                ->set_label("Frequently Asked Question")
                ->set_menu_icon(CWP_URL . '/menu-images/pencil.png')
                ->register();
        self::categories('faq', 'cwp_faq');
        self::tags('faq', 'cwp_faq');
    }

    public static function article() {
        $pt = new cwp_post_type('article');
        $pt->set_publicly_queryable(true)
                ->set_public(true)
                ->set_menu_postion(5)
                ->set_menu_title("Articles")
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'article'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author', 'liveblog'))
                ->set_label("Articles")
                ->set_menu_icon(CWP_URL . '/menu-images/premium.png')
                ->register();
        self::categories('article', 'cwp_article');
        self::tags('article', 'cwp_article');
    }

    public static function product() {
        $pt = new cwp_post_type('product');
        $pt->set_publicly_queryable(true)
                ->set_public(true)
                ->set_menu_postion(5)
                ->set_menu_title("Products")
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'products'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author'))
                ->set_label("Products")
                ->set_menu_icon(CWP_URL . '/menu-images/cost.png')
                ->register();
        self::categories('product', 'cwp_product');
        self::tags('product', 'cwp_product');
    }

    public static function info() {
        $pt = new cwp_post_type('info');
        $pt->set_publicly_queryable(true)
                ->set_public(true)
                ->set_menu_title("Infomation")
                ->set_hierarchical(true)
                ->set_menu_postion(5)
                ->set_rewrite(array('slug' => 'info'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author'))
                ->set_label("Information")
                ->set_menu_icon(CWP_URL . '/menu-images/pen.png')
                ->register();
        self::categories('info', 'cwp_info');
        self::tags('info', 'cwp_info');
    }

    public static function feedback() {
        $pt = new cwp_post_type('feedback');
        $pt->set_publicly_queryable(true)
                ->set_public(true)
                ->set_menu_title("Feedback")
                ->set_hierarchical(true)
                ->set_menu_postion(5)
                ->set_rewrite(array('slug' => 'feedback'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author', 'custom-fields'))
                ->set_label("Fedback")
                ->set_menu_icon(CWP_URL . '/menu-images/communication.png')
                ->register();
        self::categories('feedback', 'cwp_feedback');
        //self::tags('info', 'cwp_info');
    }

    public static function code() {
        $pt = new cwp_post_type('code');
        $pt->set_publicly_queryable(true)
                ->set_public(true)
                ->set_menu_title("Code")
                ->set_hierarchical(true)
                ->set_menu_postion(5)
                ->set_rewrite(array('slug' => 'code'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'page-attributes', 'author'))
                ->set_label("Code / Snippets")
                ->set_menu_icon(CWP_URL . '/menu-images/attibutes.png')
                ->register();
        self::categories('code', 'cwp_code');
        self::tags('code', 'cwp_code');
    }

    public static function advert() {
        $pt = new cwp_post_type('advert');
        $pt->set_public(false)
                ->set_publicly_queryable(false)
                ->set_menu_postion(5)
                ->set_menu_title("Advertising")
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'ads'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author'))
                ->set_label("Adverts")
                ->set_menu_icon(CWP_URL . '/menu-images/project.png')
                ->register();
        self::tags('advert', 'cwp_advert');
        //add_theme_support('post-formats',array('aside', 'gallery', 'video'));
    }

    /**
     * ********************************TAXONOMY*********************************
     */
    public static function categories($name, $type) {
        $cat = new cwp_taxonomy($name . '_category', ucfirst($name) . ' Category');
        $cat->set_post_types($type);
        $cat->register();
    }

    public static function tags($name, $type, $show_admin_col = false) {
        $tags = new cwp_taxonomy($name . '_tag', ucfirst($name) . ' Tags');
        $tags->set_post_types($type);
        $tags->set_show_admin_col($show_admin_col);
        $tags->tags();
    }

}

