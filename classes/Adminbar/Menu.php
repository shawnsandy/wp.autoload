<?php

/**
 * Description of Adminbar_Menus
 *
 * @author studio
 */
class Adminbar_Menu {

    public function __construct() {

    }

    protected $node_id,
            $node_parent = false,
            $node_title = '',
            $node_href = NUll,
            $node_meta = array(),
            $node_group = false;

    /**
     * call the admin_bar_menu action
     */
    public function add_node() {

        add_action('admin_bar_menu', array($this, 'node'),9999);
    }

    public function set_node_id($node_id) {
        $this->node_id = $node_id;
        return $this;
    }

    public function set_node_parent($node_parent) {
        $this->node_parent = $node_parent;
        return $this;
    }

    public function set_node_title($node_title) {
        $this->node_title = $node_title;
        return $this;
    }

    public function set_node_href($node_href) {
        $this->node_href = $node_href;
        return $this;
    }

    public function set_node_meta($node_meta) {
        $this->node_meta = $node_meta;
        return $this;
    }

    public function set_node_group($node_group) {
        $this->node_group = $node_group;
        return $this;
    }


    public static function factory() {
        $factory = new Adminbar_Menu();
        return $factory;
    }

    /**
     * Add the nodes to your menubar
     *
     * @global type $wp_admin_bar
     * @param type $wp_admin_bar
     * @link http://codex.wordpress.org/Function_Reference/add_node - Codex Docs
     */
    public function node($wp_admin_bar) {

        $args['id'] = $this->node_id;
        $args['title'] = $this->node_title;
        $args['parent'] = $this->node_parent;
        if (isset($this->node_href))
            $args['href'] = $this->node_href;
        $args['meta'] = $this->node_meta;
        $args['group'] = $this->node_group;
        // add node
        $wp_admin_bar->add_node($args);
    }

    /**
     * Quickly add a node,
     * @param string $node_id - node id required
     * @param string $node_href - menu item link
     * @param string $node_title - the tit of the menu
     * @since 0.1
     */
    public function node_item($node_id, $node_href, $node_title = '') {

        /**
         * feeling lazy so auto create meta properties if I didn't
         *
         */
        if (empty($this->node_meta)):
            $this->node_meta = array(
                'class' => $node_id,
                'title' => $node_title . ' menu'
            );
        endif;

        $this->node_id = $node_id;
        $this->node_href = $node_href;
        $this->node_title = $node_title;

        $this->add_node();
    }

}