<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cts_carts
 *
 * @author studio
 */
class cts_carts {

    private $post_type;

    function __construct($post_name = 'cart', $prefix = 'cts') {

        $this->post_type = new Ext_post_type($post_name, $prefix);

    }

    public static function factory($post_name = 'cart', $prefix = 'cts') {

        $factory = new cts_carts($post_name, $prefix);
        return $factory;
    }

    public function add_cart() {

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('page')
                ->set_show_in_menu('customshop')
                ->set_public(false)
                ->set_show_ui(true)
                ->set_show_in_nav_menus(false)
                ->set_menu_title("Manage Carts")
                ->set_rewrite(array('slug' => 'carts'))
                ->set_supports(array('title', 'excerpt', 'comments'))
                ->set_label("Cart")
                ->set_menu_icon(plugins_url('images/shipping.png', __FILE__))
                ->register();

        add_action('load-post.php', array($this, 'post_screens'));
        add_action('load-post-new.php', array($this, 'post_screens'));
        add_action('add_meta_boxes', array($this, 'change_defaults_labels'), 10);
        add_action('admin_init', array($this, 'meta_boxes'));

        cts_shopping_items::factory()->shopping_items();


        return $this;
    }

    public function change_defaults_labels($post) {
        global $wp_meta_boxes;
        ////        remove_meta_box('authordiv', 'cts_cart', 'normal');

        unset($wp_meta_boxes[$this->post_type->get_post_type_name() ]['normal']['core']['postexcerpt']);
        unset($wp_meta_boxes[$this->post_type->get_post_type_name() ]['normal']['core']['submitdiv']);

        add_meta_box('postexcerpt', 'Order Excerpt', 'post_excerpt_meta_box', $this->post_type->get_post_type_name(), 'normal', 'low');
        add_meta_box('submitdiv', 'Save Cart', 'post_submit_meta_box', $this->post_type->get_post_type_name(), 'side', 'high');



    }

    public function meta_boxes() {



        //create product details metabox metabox
        cts_meta_boxes::factory()
                ->set_include_page(plugin_dir_path(__FILE__) . 'includes/add-to-cart.php')
                ->set_id('cts_add_to_cart')
                ->set_piority('high')
                ->set_screen($this->post_type->get_post_type_name())
                ->set_title('Shopping Cart Items')
                ->metabox();


        //create coupoun meta boxes

        cts_meta_boxes::factory()
                ->set_include_page(plugin_dir_path(__FILE__).'/includes/coupons-metabox.php')
                ->set_id('cts_coupons')
                ->set_context('normal')
                ->set_piority('high')
                ->set_screen($this->post_type->get_post_type_name())
                ->set_title('Coupons / Discounts')
                ->metabox();
        //Cart checkout

        cts_meta_boxes::factory()
                ->set_include_page(plugin_dir_path(__FILE__).'/includes/cart-total-metabox.php')
                ->set_id('cts_cart_total')
                ->set_context('side')
                ->set_piority('high')
                ->set_screen($this->post_type->get_post_type_name())
                ->set_title('Checkout Summary $')
                ->metabox();
    }

    public function post_screens(){
         //dsiplay only on cart pages
        $screen = get_current_screen();
            if ($screen->post_type == $this->post_type->get_post_type_name()):
                //remove_post_type_support( 'post', 'post-formats' );
            add_theme_support('post-formats', $this->post_type->get_post_type_name());
            add_action('save_post', array($this,'cts_save_cart_items'), 10, 2);
            endif;
    }

    public function cts_save_cart_items($post_id) {

        if (defined('DOING_AUTOSAVE') AND DOING_AUTOSAVE)
            return;

        if (!wp_verify_nonce($_POST['items_nonce_name'], 'items_nonce_action'))

            return;


        if ($this->post_type->get_post_type_name() == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return;

        } else {

            if (!current_user_can('edit_page', $post_id))
                return;
        }

        if(!empty($_POST['name']))
        update_post_meta($post_id, '_nonce-test', $_POST['name'], 0);

    }


}



class cts_shopping_items{

    private $post_type;

    public function __construct() {
        $this->post_type = new Ext_post_type('shopping_items', 'cts');
    }

    public static function factory(){
        $factory = new cts_shopping_items();
        return $factory;
    }

    public function shopping_items(){

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('page')
                ->set_show_in_menu('customshop')
                ->set_public(false)
                ->set_show_ui(false)
                ->set_show_in_nav_menus(false)
                ->set_menu_title("Shopping Items")
                ->set_rewrite(array('slug' => 'shopping_items'))
                ->set_supports(array('title','excerpt', 'comments'))
                ->set_label("Shopping Item")
                ->set_menu_icon(plugins_url('images/shipping.png', __FILE__))
                ->register();

    }

}