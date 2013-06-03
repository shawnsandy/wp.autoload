<?php

/**
 * Description of BJ_METABOXES
 *
 * @author studio
 */
class BJ_METABOXES {

    /**
     *
     * @var type
     */
    private $meta_box = array(),
            $field_class,
            $field_std,
            $field_type,
            $field_clone = false,
            $metabox_class = 'bj-metabox',
            $metabox_context = 'normal',
            $metabox_piority = 'high',
            $post_types = 'post',
            $metabox_fields = array();

    public function set_metabox_fields($metabox_fields) {
        $this->metabox_fields = $metabox_fields;
    }

    public function set_post_types($metabox_post_types) {
        $this->post_types = $metabox_post_types;
    }

    /**
     * Sets where the metabox is displayed normal/advanced/side
     * @param string $metabox_context
     */
    public function set_metabox_context($metabox_context) {
        $this->metabox_context = $metabox_context;
    }

    /**
     * Sets the order of the boxes - high/low
     * @param string $metabox_piority
     */
    public function set_metabox_piority($metabox_piority) {
        $this->metabox_piority = $metabox_piority;
    }

    public function set_metabox_class($metabox_class) {
        $this->metabox_class = $metabox_class;
        return $this;
    }

//    public function set_meta_box($meta_box) {
//        $this->meta_box = $meta_box;
//        return $this;
//    }
//    public function set_field_class($field_class) {
//        $this->field_class = $field_class;
//    }
//
//    public function set_field_std($field_std) {
//        $this->field_std = $field_std;
//    }
//
//    public function set_field_type($field_type) {
//        $this->field_type = $field_type;
//    }
//
//    public function set_field_clone($field_clone) {
//        $this->field_clone = $field_clone;
//    }

    public function __construct() {

    }

    public static function factory($meta_boxes = '') {

        $factory = new BJ_METABOXES();
        return $factory;
    }

    /**
     * Register the metaboxes on admin_init()
     */
    public function metaboxes() {
        //$this->register_metaboxes();
        add_action('admin_init', array($this, 'register_metaboxes'));
    }

    public function register_metaboxes() {

        //Make sure there's no errors when the plugin is deactivated or during upgrade
        if (!class_exists('RW_Meta_Box') && !is_array($this->meta_box))
            return;
        foreach ($this->meta_box as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }

    /**
     * Set up the metabox attributes and register the metabox
     * @param type $metabox_id
     * @param type $metabox_title
     * @param type $post_types
     */
    public function add_metabox($metabox_id, $metabox_title, $post_types = array('post')) {
        //setup create the metabox

        $meta_box[] = array(
            'id' => $metabox_id,
            'title' => $metabox_title,
            'pages' => $post_types,
            'context' => $this->metabox_context,
            'piority' => $this->metabox_piority,
            'fields' => $this->metabox_fields
        );

        $this->meta_box = $meta_box;
        $this->metaboxes();
    }

    /**
     * Create a single field attribute
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $clone
     * @return array
     */
    private function field_attributes($id, $name, $description = '') {
        $array = array(
            'name' => $name,
            'id' => $id,
            'type' => $this->field_type,
            'desc' => $description,
            'std' => $this->field_std,
            'class' => $this->field_class,
            'clone' => $this->field_clone
        );
        return $array;
    }

    /**
     *
     * @param string $id metabox id
     * @param string name/label of metabox field
     * @param string desc field descriotion
     * @param bool $clone allow copies of this field
     * @return field array
     */
    public function text_field($id, $name, $desc = '', $default= '', $clone = false) {
        $this->field_type = 'text';
        $this->field_clone = $clone;
        $this->field_std = $default;
        return $this->field_attributes($id, $name, $desc);
    }

    /**
     *
     * @param string $id metabox id
     * @param string name/label of metabox field
     * @param string desc field descriotion
     * @param bool $clone allow copies of this field
     * @return field array
     */
    public function checkbox_field($id, $name, $desc = '', $std = 0) {
        $this->field_type = 'checkbox';
        $this->field_std = $std;
        return $this->field_attributes($id, $name, $desc);
    }

    public function text_area($id, $name, $desc = '', $clone = false) {
        $this->field_type = 'textarea';
        $this->field_clone = $clone;
        return $this->field_attributes($id, $name, $desc);
    }

    public function post_selection($id, $name, $post_type = 'post', $desc = '') {
        $array = array(
            'name' => $name,
            'id' => $id,
            'type' => 'post',
            'desc' => $desc,
            'std' => $this->field_std,
            'class' => $this->field_class,
            // Post type
            'post_type' => $post_type,
            // Field type, either 'select' or 'select_advanced' (default)
            'field_type' => 'select',
            // Query arguments (optional). No settings means get all published posts
            'query_args' => array(
                'post_status' => 'publish',
                'posts_per_page' => '-1',
            )
        );

        return $array;
    }

    public function posts() {
        $field = array(
            'name' => 'Posts (Pages)',
            'id' => "_pages",
            'type' => 'post',
            // Post type
            'post_type' => 'page',
            // Field type, either 'select' or 'select_advanced' (default)
            'field_type' => 'select',

        );
        return $field;
    }

}