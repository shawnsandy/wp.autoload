<?php

/**
 * Description of theme_shop
 *
 * @author studio
 */
class custom_theme_shop {

    public function __construct() {

        add_action('admin_menu', array($this, 'admin_init'));
        add_action('admin_init', array($this,'scripts'));
    }


    public function scripts() {

        wp_register_script('bootstrap-js', FN_core::locate_in_vendor('bootstrap/js/bootstrap.min.js'), null);
        wp_register_style('bootstrap-style', FN_core::locate_in_vendor('bootstrap/css/bootstrap.min.css'));
        wp_register_style('bootstrap-responsive', FN_core::locate_in_vendor('bootstrap/css/bootstrap-responsive.min.css'));
        wp_enqueue_script('bootstrap-js');
        wp_enqueue_style('bootstrap-style');
        wp_enqueue_style('bootstrap-responsive');


    }

    public static function factory() {

        $factory = new custom_theme_shop();
        return $factory;
    }

    public function admin_init() {

        add_menu_page('CTS_Shop', 'ThemeShop', 'manage_options', 'customshop', array($this, 'shop_menu'), plugins_url('images/suppliers.png', __FILE__), '10.5');

        add_submenu_page('customshop', 'Settings', 'Manage Settings', 'manage_options', 'cts_settings', array($this, 'cts_settings'));

        //create an post_type array(post_type, menu_title);
        $post_types = array('cts_products' => 'Products', 'cts_orders' => "Orders");

        //load and run the class
        $apmmenus = AdminbarPostMenus::add_menus()->set_list_count(10)->set_post_types($post_types)->nodes();
    }

    public function shop_menu() {
        echo 'Shop Menu';
    }

    public function cts_settings() {
        echo "<div class='wrap'><h2>Manage Settings</h2></div>";
    }

}



class cts_meta_boxes {

//add_meta_box($id, $title, $callback, $screen, $context, $priority)

            private $id,
            $title,
            $screen = 'post',
            $context = 'normal',
            $piority = 'low',
            $include_page = null;

    /**
     *
     * <code>
      cts_meta_box::factory()->include_page(meta-page.page)->id(box_id)->set_title(box_title)
      ->set_screen('side')->set_context(normal)->piority(low);
      </code>
     * @return \ccts_meta_boxes     */
    public static function factory() {

        $factory = new cts_meta_boxes();
        return $factory;
    }

    public function set_include_page($include_page) {
        $this->include_page = $include_page;
        return $this;
    }

    public function set_id($id) {
        $this->id = $id;
        return $this;
    }

    public function set_title($title) {
        $this->title = $title;
        return $this;
    }

    public function set_screen($screen) {
        $this->screen = $screen;
        return $this;
    }

    public function set_context($context) {
        $this->context = $context;
        return $this;
    }

    public function set_piority($piority) {
        $this->piority = $piority;
        return $this;
    }

    function __construct() {

    }

    public function metabox() {
        add_action('add_meta_boxes', array($this, 'meta'));
    }

    public function meta() {

        //add_meta_box($id, $title, $callback, $screen, $context, $priority)

        add_meta_box($this->id, $this->title, array($this, 'create'), $this->screen, $this->context, $this->piority);
    }

    public function create($post) {

        if (!isset($this->include_page) OR !file_exists($this->include_page)) {
            echo "File Error";
            return;
        }

        include_once $this->include_page;
    }

}