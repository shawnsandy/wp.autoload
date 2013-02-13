<?php

/**
 * Description of cts_orders
 *
 * @author studio
 */
class cts_orders {

    private $post_type;

    function __construct() {

    }

    public static function factory() {
        $factory = new cts_orders();

        return $factory;
    }

    public function add_orders() {

        $this->post_type = new Ext_post_type('orders', 'cts');

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('page')
                ->set_show_in_menu('customshop')
                ->set_public(false)
                ->set_show_ui(true)
                ->set_show_in_nav_menus(false)
                ->set_menu_title("Manage Orders")
                ->set_rewrite(array('slug' => 'order'))
                ->set_supports(array('title', 'comments'))
                ->set_label("Order")
                ->set_menu_icon(plugins_url('images/product-design.png', __FILE__))
                ->register();
        return $this;
    }

    public function order_info() {
        //add_action('add_meta_boxes', array($this, 'order_items'));
        //add_action('save_post', array($this, 'save_post'));
        add_action('admin_init', array($this, 'order_summary'));
        add_action('add_meta_boxes', array($this, 'change_defaults_labels'), 10);
        //**************************************************

        add_action('load-post.php', array($this, 'edit_post_screens'));
        add_action('load-post-new.php', array($this, 'new_post_screens'));

        //**************************************************

        add_action('load-post.php', array($this, 'post_screens'));
        add_action('load-post-new.php', array($this, 'post_screens'));
    }


    public function new_post_screens(){
        $this->order_info();
    }

    public function edit_post_screens() {

    }

    public function post_screens(){

    }


    public function save_post($post_id) {
        if (defined('DOING_AUTOSAVE') AND DOING_AUTOSAVE)
            return;
    }

    public function order_summary(){

        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = '_cts_orders_';

        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_orders_meta',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Orders Info',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'normal',
            // Order of meta box: high (default), low; optional
            'piority' => 'high',
            'fields' => array(
                // TEXTAREA
                array(
                    'name' => 'Order Summary',
                    'desc' => "Orders summary and details",
                    'id' => "{$prefix}summary",
                    'type' => 'textarea',
                    'std' => "",
                    'cols' => '40',
                    'rows' => '20',
                ),
                // SELECT BOX
                array(
                    'name' => 'Order Status',
                    'id' => "{$prefix}status",
                    'type' => 'select',
                    // Array of 'key' => 'value' pairs for select box
                    'options' => array(
                        'processing' => 'In Processing',
                        'deleyed' => 'Delayed',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled'
                    ),
                    // Select multiple values, optional. Default is false.
                    'multiple' => false,
                    // Default value, can be string (single value) or array (for both single and multiple values)
                    'std' => array('processing'),
                    'desc' => 'Select the order status.',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Customer',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'customer',
                    // Field description (optional)
                    'desc' => 'Customer',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                ));

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }

    }

    public function _order_info() {


        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = '_cts_orders_';

        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_orders_meta',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Orders Info',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'normal',
            // Order of meta box: high (default), low; optional
            'piority' => 'high',
            'fields' => array(
                // TEXTAREA
                array(
                    'name' => 'Order Summary',
                    'desc' => "Orders summary and details",
                    'id' => "{$prefix}summary",
                    'type' => 'textarea',
                    'std' => "",
                    'cols' => '40',
                    'rows' => '20',
                ),
                // SELECT BOX
                array(
                    'name' => 'Order Status',
                    'id' => "{$prefix}status",
                    'type' => 'select',
                    // Array of 'key' => 'value' pairs for select box
                    'options' => array(
                        'processing' => 'In Processing',
                        'deleyed' => 'Delayed',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled'
                    ),
                    // Select multiple values, optional. Default is false.
                    'multiple' => false,
                    // Default value, can be string (single value) or array (for both single and multiple values)
                    'std' => array('processing'),
                    'desc' => 'Select the order status.',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Customer',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'customer',
                    // Field description (optional)
                    'desc' => 'Customer',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                ));
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_orders_billing',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Bill To',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'side',
            // Order of meta box: high (default), low; optional
            'piority' => 'low',
            'fields' => array(
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'First Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'first_name',
                    // Field description (optional)
                    'desc' => 'Customer Full Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Last Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'flast_name',
                    // Field description (optional)
                    'desc' => 'Customer Last Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address',
                    // Field description (optional)
                    'desc' => 'Address',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address 2',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address_2',
                    // Field description (optional)
                    'desc' => 'Address 2',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'City',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'city',
                    // Field description (optional)
                    'desc' => 'City',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Postal Code',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'postal_code',
                    // Field description (optional)
                    'desc' => 'Postal Code',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Country',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'country',
                    // Field description (optional)
                    'desc' => 'Country',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // CHECKBOX
                array(
                    'name' => 'Same for Shipping', // File type: checkbox
                    'id' => "{$prefix}same_shipto",
                    'type' => 'checkbox',
                    'desc' => 'Yes use this address for shipping',
                    // Value can be 0 or 1
                    'std' => 0,
                ),
                ));

        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_orders_shipto',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Ship To',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'side',
            // Order of meta box: high (default), low; optional
            'piority' => 'low',
            'fields' => array(
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'First Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'first_name',
                    // Field description (optional)
                    'desc' => 'Customer Full Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Last Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'flast_name',
                    // Field description (optional)
                    'desc' => 'Customer Last Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address',
                    // Field description (optional)
                    'desc' => 'Address',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address 2',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address_2',
                    // Field description (optional)
                    'desc' => 'Address 2',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'City',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'city',
                    // Field description (optional)
                    'desc' => 'City',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Postal Code',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'postal_code',
                    // Field description (optional)
                    'desc' => 'Postal Code',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Country',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'country',
                    // Field description (optional)
                    'desc' => 'Country',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                ));





        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }

    public function change_defaults_labels($post) {
        global $wp_meta_boxes;
        //remove_meta_box('authordiv', 'cts_cart', 'normal');

        //unset($wp_meta_boxes[$this->post_type->get_post_type_name()]['normal']['core']['postexcerpt']);
        unset($wp_meta_boxes[$this->post_type->get_post_type_name()]['normal']['core']['submitdiv']);


        add_meta_box('submitdiv', 'Save Order', 'post_submit_meta_box', $this->post_type->get_post_type_name(), 'side', 'high');
    }

}

