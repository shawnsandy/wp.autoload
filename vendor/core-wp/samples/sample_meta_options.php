<?php




class XXX_meta_option {

    private $meta_name;
    private $meta_feilds = array();
    private $meta_form_url = null;
    private $meta_post_types = "'page','post'";

    public function set_meta_post_types($meta_post_types) {
        $this->meta_post_types = $meta_post_types;
        return $this;
    }


    public function get_meta_name() {
        return $this->meta_name;

    }

    public function set_meta_name($meta_name) {
        $this->meta_name = $meta_name;
        return $this;
    }

    public function get_meta_feilds() {
        return $this->meta_feilds;
    }

    public function set_meta_feilds($meta_feilds) {
        $this->meta_feilds = $meta_feilds;
        return $this;
    }

    public function get_meta_box_tpl() {
        return $this->meta_form_url;
    }

    public function set_meta_box_tpl($meta_form_url) {
        $this->meta_form_url = $meta_box_tpl;
        return $this;
    }



    public function __construct() {

    }

    public function add_meta_box() {
        add_action("admin_init", array(&$this,"admin_init"));
        add_action('save_post', array(&$this,'save_meta'));
        return $this;
    }

    public function admin_init() {
        //add_meta_box($id, $title, $callback, $page, $context, $priority)
        add_meta_box("{$this->meta_name}-meta", "{$this->meta_name} Options", array(&$this,"meta_options"), "product", "side", "low");
    }

    public function meta_options() {
        wp_nonce_field( plugin_basename( __FILE__ ), 'uioptions_wpnonce', false, true );
        global $post;
        $custom = get_post_custom($post->ID);
        $price = $custom["XXXX"][0];
        if(isset($this->meta_form_url) AND file_exists($this->meta_form_url)):
            include_once $this->meta_form_url;
            else :
           ?>
        <label>Price:</label><input name="XXX" value="<?php echo $price; ?>" />
        <?php
        endif;
    }

    public function save_meta($value=array()) {
        global $post;
        foreach($value as $key => $val):
        update_post_meta($post->ID, $key, $_POST[$value]);
        endforeach;
    }

}

