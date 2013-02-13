<?php


/**
 * Description of PostTypeMenu
 *
 * @author studio
 */
class Adminbar_PostMenus {

    public function __construct() {

    }

    private $display_published = true,
            $display_pending = true,
            $display_draft = true,
            $display_schedule = true,
            $post_types = array('post' => 'Posts', 'page' => 'Pages'),
            $list_count = 5,
            $node_meta;

    public function set_display_published($display_published) {
        $this->display_published = $display_published;
        return $this;
    }

    public function set_display_pending($display_pending) {
        $this->display_pending = $display_pending;
    }

    public function set_display_draft($display_draft) {
        $this->display_draft = $display_draft;
         return $this;
    }

    public function set_display_schedule($display_schedule) {
        $this->display_schedule = $display_schedule;
         return $this;
    }

    public function set_post_types($post_types) {
        $this->post_types = $post_types;
         return $this;
    }

    public function set_list_count($list_count) {
        $this->list_count = $list_count;
         return $this;
    }

    public function set_node_meta($node_meta) {
        $this->node_meta = $node_meta;
         return $this;
    }



    /**
     * Factory method
     * @return \Adminbar_PostMenus
     */
    public static function factory(){
        $factory = new Adminbar_PostMenus();
        return $factory;
    }

    /**
     * Create the nodes
     */
    public function create_nodes() {


        foreach ($this->post_types as $post_type => $title) {
            // TODO localize note titles

            if ($this->display_published):

               $this->list_count = 10;

                $this->nodes($post_type, 'publish', $title);

            endif;


            if ($this->display_pending):

                $this->nodes($post_type, 'pending', 'Pending',TRUE);

            endif;

            if ($this->display_schedule):

                $this->nodes($post_type, 'future', 'Scheduled',TRUE);

            endif;


            if ($this->display_draft):

                $this->nodes($post_type, 'draft', 'Draft',TRUE);

            endif;

        }

    }


    /**
     *
     * @param type $post_type
     * @param type $post_status
     * @param type $node_title
     * @param bool $is_seperator
     */
    public function nodes($post_type, $post_status, $node_title, $is_seperator = FALSE) {

        $menu_node = Adminbar_Menu::factory();

        $node_id = $post_type . '-menu';
        $node_href = trailingslashit(admin_url()) . 'edit.php?post_type=' . $post_type;
        
        //create parent node
        $menu_node->set_node_id($node_id)
                ->set_node_href($node_href)
                ->set_node_title($node_title);

        /**
         * feeling lazy so auto create meta properties if I didn't
         *
         */
        if (empty($this->node_meta)):
            $this->node_meta = array(
                'class' => $node_id,
                'title' => ucfirst($node_title)
            );
        $menu_node->set_node_meta($this->node_meta);
        endif;

        $seperator_id = $node_id;


        //create seperator node
        if ($is_seperator == TRUE):
            //create seperator node
            $seperator_id = $post_status. '-' . $post_type;
            $menu_node->set_node_id($seperator_id)
                    ->set_node_parent($node_id)
                    ->set_node_href(NULL);
        endif;
        $menu_node->add_node();




        // get the post data

        $post_data = $this->data($post_type, $post_status, $this->list_count);

        //create node items by looping through the data

        foreach ($post_data as $data):
            $item_href = esc_url(get_edit_post_link($data->ID));
            $item_id = $seperator_id . '-' . $data->ID;
            Adminbar_Menu::factory()->set_node_parent($seperator_id)->node_item($item_id, $item_href, $data->post_title);
        endforeach;
    }

    /**
     *
     * @global type $wpdb
     * @global type $post
     * @param type $post_type
     * @param type $post_status
     * @param type $items
     * @return type
     */
    private function data($post_type, $post_status, $items) {
        global $wpdb, $post;
        $qry = "
	SELECT $wpdb->posts.ID, $wpdb->posts.post_title
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = '$post_status'
                AND
                $wpdb->posts.post_type = '$post_type'
                ORDER BY $wpdb->posts.ID DESC LIMIT $items";
        $query = $wpdb->get_results($qry, OBJECT);
        return $query;
    }

}

