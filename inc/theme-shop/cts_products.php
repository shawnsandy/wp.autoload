<?php



/**
 * Description of cts_products
 *
 * @author studio
 */

class cts_products {

    private $post_type;

    function __construct() {
        $this->post_type = new Ext_post_type('products', 'cts');
    }

    public static function factory() {
        $factory = new cts_products();
        return $factory;
    }

    public function add_post_type() {

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('post')
                ->set_menu_postion(11)
                ->set_public(true)
                ->set_menu_title("Products")
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'products'))
                ->set_supports(array('title', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author'))
                ->set_label("Product")
                ->set_menu_icon(plugins_url('images/product-design.png', __FILE__))
                ->register();


        add_action('load-post.php', array($this, 'formats'));
        add_action('load-post-new.php', array($this, 'formats'));
        $this->categories('products');
        $this->tags('products');
        return $this;
    }

    /**
     * ******************************post formats*******************************
     */
    public function formats($post_formats = array('video', 'image', 'aside')) {
        $this->post_type->set_post_formats($post_formats = array('video', 'image'));
        $this->post_type->post_formats();
    }

    /**
     * ********************************TAXONOMY*********************************
     */
    public function categories($name) {
        $cat = new Ext_taxonomies($name . '_category', ucfirst($name) . ' Categories');
        $cat->set_post_types($this->post_type->get_post_type_name());
        $cat->register();
    }

    public function tags($name) {
        $tags = new Ext_taxonomies($name . '_tag', ucfirst($name) . ' Tags');
        $tags->set_post_types($this->post_type->get_post_type_name());
        $tags->tags();
    }

    /**
     * ********************************METABOXES*********************************
     */
    public function product_details() {


        add_action('admin_init', array($this, '_product_details'));
    }

    public function _product_details() {

        $prefix = '_cts_';


        if (!class_exists('RW_Meta_Box'))
            return;

        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'custom_options',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Product Details',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'normal',
            // Order of meta box: high (default), low; optional
            'piority' => 'high',
            'fields' => array(
                // TEXTAREA
                array(
                    'name' => 'Product Slug/Copy',
                    'desc' => '<strong>A short description of your for the cover/ads/cart and messages</strong>',
                    'id' => "{$prefix}products_detail",
                    'type' => 'textarea',
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Feature List',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'feature_list',
                    // Field description (optional)
                    'desc' => 'Featue List (Format: First Last)',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => 'Anh Tran',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'SKU',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'sku',
                    // Field description (optional)
                    'desc' => 'Product SKU',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Product Price',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'product_price',
                    // Field description (optional)
                    'desc' => 'Set your standard product price',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Sale Price',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'sale_price',
                    // Field description (optional)
                    'desc' => 'Set your sale price',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Shipping Weight',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'shipping_weight',
                    // Field description (optional)
                    'desc' => 'Add product shipping weight',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // RADIO BUTTONS
                array(
                    'name' => 'Stock quantity',
                    'id' => "{$prefix}stock_quantity",
                    'type' => 'radio',
                    // Array of 'key' => 'value' pairs for radio options.
                    // Note: the 'key' is stored in meta field, not the 'value'
                    'options' => array(
                        'available' => 'In Stock',
                        'low' => 'Low',
                        'out' => 'Out of Stock',
                    ),
                    'std' => 'available',
                    'desc' => 'Enter your stock quantity',
                ),
                // PLUPLOAD IMAGE UPLOAD (WP 3.3+)
                array(
                    'name' => 'Product Images',
                    'desc' => 'Add images of your products (10 max)',
                    'id' => "{$prefix}product_images",
                    'type' => 'plupload_image',
                    'max_file_uploads' => 10,
                ),
            )
        );

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
        return $this;
    }

}
