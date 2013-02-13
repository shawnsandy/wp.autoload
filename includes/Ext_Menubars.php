<?php

/**
 * Description of Ext_Admin_Menus
 *
 * @author studio
 */
class Ext_Menubars {

}

/**
 * Quickly add post edits links to the Adminbar
 * <code>
 * /** Display most recent Post (all Post Types)
  Post_Menus::add()->set_node_id('recent')->set_node_title('Recent Post')->set_post_types(TRUE)->published();
  //** Display published Post
  Post_Menus::add()->set_node_id('menu-published')->set_node_title('Post')->published();
  //** Display published pages
  Post_Menus::add()->set_node_id('menu-pages')->set_node_title('Pages')->published('page');
  //** Display Custom Options pages
  Post_Menus::add()->set_node_id('custom_options')->set_node_title('UI.Options')->published('cwp_custom_options');
 * </code>
 */
class Ext_Post_Menus {

    private $items = 10,
            $node_parent = false,
            $parent_url = '',
            $post_status = 'publish',
            $post_type = 'post',
            $post_types = false,
            $node_id = 'menu-node',
            $node_title = 'Menu Title';

    public function set_parent_url($parent_url) {
        $this->parent_url = $parent_url;
        return $this;
    }

    public function set_node_parent($node_parent) {
        $this->node_parent = $node_parent;
        return $this;
    }

    /**
     * Menu ID
     * @param type $node_id
     * @return \Post_Menus
     */
    public function set_node_id($node_id) {
        $this->node_id = $node_id;
        return $this;
    }

    /**
     * Menu Title
     * @param type $node_title
     * @return \Post_Menus
     */
    public function set_node_title($node_title) {
        $this->node_title = $node_title;
        return $this;
    }

    /**
     * Number of items to list
     * @param type $items
     * @return \Post_Menus
     */
    public function set_items($items) {
        $this->items = $items;
        return $this;
    }

    /**
     * Set post status
     * @param type $post_status
     * @return \Post_Menus
     */
    public function set_post_status($post_status) {
        $this->post_status = $post_status;
        return $this;
    }

    /**
     * Set Post Type
     * @param type $post_type
     * @return \Post_Menus
     */
    public function set_post_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    /**
     * Set post
     * @param type $post_types
     * @return \Post_Menus
     */
    public function set_post_types($post_types) {
        $this->post_types = $post_types;
        return $this;
    }

    private static $instance;

    /**
     * Singleton pattern
     * @return type
     */
    public static function instance() {
        if (!is_object(self::$instance)):
            $class = __CLASS__;
            self::$instance = new $class;
        endif;
        return self::$instance;
    }

    /**
     * Factory Pattern
     * @return Post_Menus method (chainable);
     */
    public static function add() {
        //$class = __CLASS__;
        $factory = new Ext_Post_Menus();
        return $factory;
    }

    private function __construct() {

    }

    /**
     * Grabs the menus data form posts
     * @param type $post_type
     * @param type $post_status
     * @param type $items
     */
    public function menu_data($post_type = 'post', $post_status = 'publish', $items = 5) {
        $this->post_type = $post_type;
        $this->items = $items;
        $this->post_status = $post_status;
        $this->add_nodes($this->node_id, $this->node_title);
    }

    /**
     *
     * @global type $wpdb
     * @param array $where
     * @return type
     */
    private function data() {

        global $wpdb, $post;
        $qry = "
	SELECT $wpdb->posts.ID, $wpdb->posts.post_title
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = '$this->post_status'
                AND
                $wpdb->posts.post_type = '$this->post_type'
                ORDER BY $wpdb->posts.ID DESC LIMIT $this->items";
        $query = $wpdb->get_results($qry, OBJECT);
        return $query;
    }

    /**
     * get all post
     * @global type $wpdb
     * @param array $where
     * @return type
     */
    private function data_all() {

        global $wpdb, $post;
        $qry = "
	SELECT $wpdb->posts.ID, $wpdb->posts.post_title
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = '$this->post_status'
        ORDER BY $wpdb->posts.ID DESC LIMIT $this->items
                ";
        $query = $wpdb->get_results($qry, OBJECT);
        return $query;
    }

    /**
     *
     * @param type $node_id
     * @param type $node_title
     */
    public function add_nodes($node_id = 'menu-id', $node_title = 'node_title') {
        $this->node_id = $node_id;
        $this->node_title = $node_title;
        add_action('admin_bar_menu', array($this, 'nodes'), 999);
    }

    /**
     * Add the nodes to your menubar
     * //http://codex.wordpress.org/Function_Reference/add_menu
     * @global type $wp_admin_bar
     * @param type $wp_admin_bar
     */
    public function nodes($wp_admin_bar) {

        //@todo fix node title seperate from meta > title
        //** parent node **//
        $parent = $this->node_parent ? $this->node_parent : $this->node_id;


        // sets a parent or child node
        if ($this->node_parent):
            /*             * * parent node seperator ** */
            $args = array(
                'id' => $this->node_id,
                'title' => '<span class="apm-child" style="text-shadow: none; font-weight:normal">' . $this->node_title . '</span>',
                'class' => 'ext-menubars-' . $this->node_id,
                'parent' => $parent,
                'meta' => array(
                    'class' => $this->node_id,
                    'title' => $this->node_title . ' Menu')
            );
        else:
            /*             * * parent node ** */
            $args = array(
                'id' => $this->node_id,
                'title' => $this->node_title,
                'href' => $this->parent_url,
                'class' => 'ext-menubars-' . $this->node_id,
                'meta' => array(
                    'class' => $this->node_id,
                    'title' => $this->node_title . ' Menu')
            );
        endif;




        /**
         * parent nodes
         */
        $wp_admin_bar->add_node($args);



        //** get the post data **//
        if ($this->post_types)
            $data = $this->data_all();
        else
            $data = $this->data();


        /** Check the data and proceed * */
        //if (!$data OR !is_array($data))return false;
        //** loop thorugh the data and create the nodes **//

        foreach ($data as $item):
            if (current_user_can('edit_posts')):
                $args = array(
                    'id' => $this->node_id . '-' . $item->ID,
                    'title' => esc_attr($item->post_title),
                    'href' => esc_url(get_edit_post_link($item->ID)),
                    'parent' => $parent,
                    'meta' => array(
                        'class' => $this->node_id . '-class',
                        'title' => 'Edit ' . esc_attr($item->post_title),
                    )
                );

                /**
                 * child nodes
                 */
                $wp_admin_bar->add_node($args);
            endif;
        endforeach;
        return $this->node_id;
    }

}
