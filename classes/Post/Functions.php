<?php

class Post_Functions {

    function __construct() {

    }

    public static function factory() {
        $factory = new Post_Functions();
        return $factory;
    }

    private $post_types,
            $query;

    public static function searchable_postypes($post_types = null) {
        if (!isset($post_types))
            $post_types = get_post_types(array('public' => true, 'exclude_from_search' => false), 'objects');

        $factory = Post_Functions::factory();
        $factory->post_types = $post_types;

        add_action('pre_get_posts', array($factory, 'add_search'));
    }

    public function add_search() {
        // Check to verify it's search page
        if (is_search()) {
            // Get post types
            $post_types = $this->post_types;
            $searchable_types = array();
            // Add available post types
            if ($post_types) {
                foreach ($post_types as $type) {
                    $searchable_types[] = $type->name;
                }
            }
            $query->set('post_type', $searchable_types);
        }

        return $query;
    }

    /**
     * runs the pre_get_post for queries in the loop
     */
    public static function pre_post($query, $use_main_query = false) {
        /**
         * built the query using pre_get_post@link URL description
         */
        $factory = Post_Functions::factory();
        $factory->query = $query;
        if (isset($query)) {

            $action = 'pre_get_posts';
            if ($use_main_query == TRUE)
                $action = 'main_pre_get_post_query';
            add_action('pre_get_posts', array($factory, 'pre_get_posts'));
        }
    }

    public function pre_get_posts($query) {

        if ($query->is_home()):
            foreach ($this->query as $key => $value):
                $query->set($key, $value);
            endforeach;
        endif;
    }

    public function main_pre_get_posts($query) {

        if ($query->is_main_query()):
            foreach ($this->query as $key => $value):
                $query->set($key, $value);
            endforeach;
        endif;

    }

}
