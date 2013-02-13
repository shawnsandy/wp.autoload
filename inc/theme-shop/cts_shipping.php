<?php



/**
 * Description of cts_shipping
 *
 * @author studio
 */


class cts_shipping {

    function __construct() {

    }

    public static function factory() {
        $factory = new cts_shipping();
        return $factory;
    }

    public function add_shipping() {

        $this->post_type = new Ext_post_type('Shipping', 'cts');

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('post')
                ->set_show_in_menu('customshop')
                ->set_public(false)
                ->set_show_ui(false)
                ->set_show_in_nav_menus(false)
                ->set_menu_title("Manage Shipping")
                ->set_rewrite(array('slug' => 'order'))
                ->set_supports(array('title', 'excerpt', 'comments'))
                ->set_label("Shipping")
                ->set_menu_icon(plugins_url('images/shipping.png', __FILE__))
                ->register();

        return $this;
    }

}
