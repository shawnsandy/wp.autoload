<?php

/**
 * @package WordPress
 * @subpackage Toolbox
 */
class POST_TYPE_NAME {

    function __construct() {

    }

       /**
    * *********************************************************************
    * post types
    * *********************************************************************
    */

    public function post_type() {
        /**
         * custom post type template
         * http://codex.wordpress.org/Function_Reference/register_post_type
         */
        $labels = array(
            'name' => _x('TYPE_NAMEs', 'post type general name'),
            'singular_name' => _x('TYPE_NAME', 'post type singular name'),
            'add_new' => _x('Add New', 'TYPE_NAME'),
            'add_new_item' => __('Add New TYPE_NAME'),
            'edit_item' => __('Edit TYPE_NAME'),
            'new_item' => __('New TYPE_NAME'),
            'view_item' => __('View TYPE_NAME'),
            'search_items' => __('Search TYPE_NAMEs'),
            'not_found' => __('No TYPE_NAMEs found'),
            'not_found_in_trash' => __('No TYPE_NAMEs found in Trash'),
            'parent_item_colon' => '',
            'menu_name' => 'TYPE_NAME'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'can_export' => true,//set it to true, your posts will behave like pages
            //'show_in_menu' => 'index.php',//
            'menu_icon' => plugins_url('/images/menu-icon.png', __FILE__),
            'supports' => array('title', 'editor')
            //'title','editor','author','thumbnail','excerpt','comments',trackbacks,custom-fields,post-formats,revisions,page-attributes
        );
        //>>>>> change post type from TYPE_NAME
        register_post_type('csf_TYPE_NAME', $args);
    }

    /**
     * ************************messages*****************************************
     */

    /**
     * Add postype update message filter
     */
    public function update_message_filter() {
        add_filter('post_updated_messages', array(&$this, 'updated_messages'));
    }

//add filter to ensure the text TYPE_NAME, or TYPE_NAME, is displayed when user updates a TYPE_NAME
//add_filter('post_updated_messages', 'codex_TYPE_NAME_updated_messages');
    public function updated_messages($messages) {
        global $post, $post_ID;

        //************** change name here*********************
        $messages['TYPE_NAME'] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf(__('TYPE_NAME updated. <a href="%s">View TYPE_NAME</a>'), esc_url(get_permalink($post_ID))),
            2 => __('Custom field updated.'),
            3 => __('Custom field deleted.'),
            4 => __('TYPE_NAME updated.'),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf(__('TYPE_NAME restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__('TYPE_NAME published. <a href="%s">View TYPE_NAME</a>'), esc_url(get_permalink($post_ID))),
            7 => __('TYPE_NAME saved.'),
            8 => sprintf(__('TYPE_NAME submitted. <a target="_blank" href="%s">Preview TYPE_NAME</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__('TYPE_NAME scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview TYPE_NAME</a>'),
                    // translators: Publish box date format, see http://php.net/date
                    date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__('TYPE_NAME draft updated. <a target="_blank" href="%s">Preview TYPE_NAME</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );

        return $messages;
    }

    /**
     * ******************************HELP**************************************
     */
    //display contextual help for TYPE_NAMEs
    //remove comments on contextual_hel action (//) to use
    //

    public function help_text_filter() {
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
    }

    public function help_text($contextual_help, $screen_id, $screen) {
        //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
        if ('TYPE_NAME' == $screen->id) {
            $contextual_help =
                    '<p>' . __('Things to remember when adding or editing a TYPE_NAME:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Specify the correct genre such as Mystery, or Historic.') . '</li>' .
                    '<li>' . __('Specify the correct writer of the TYPE_NAME.  Remember that the Author module refers to you, the author of this TYPE_NAME review.') . '</li>' .
                    '</ul>' .
                    '<p>' . __('If you want to schedule the TYPE_NAME review to be published in the future:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
                    '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
                    '</ul>' .
                    '<p><strong>' . __('For more information:') . '</strong></p>' .
                    '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
                    '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>';
        } elseif ('edit-TYPE_NAME' == $screen->id) {
            $contextual_help =
                    '<p>' . __('This is the help screen displaying the table of TYPE_NAMEs blah blah blah.') . '</p>';
        }
        return $contextual_help;
    }

    /**
     * ******************************TAXONMY**********************************
     */

    function taxonomy_TYPE_NAMEs() {

        /**
         * *******************************************
         */

        $labels = array(
            'name' => _x('TYPE_NAME Tags', 'TYPE_NAME tags'),
            'singular_name' => _x('TYPE_NAME Tag', 'TYPE_NAME Tag'),
            'search_items' => __('Search TYPE_NAMEs'),
            'popular_items' => __('Popular TYPE_NAMEs'),
            'all_items' => __('All TYPE_NAMEs'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit TYPE_NAME'),
            'update_item' => __('Update TYPE_NAME'),
            'add_new_item' => __('Add New TYPE_NAME'),
            'new_item_name' => __('New TYPE_NAME Name'),
            'separate_items_with_commas' => __('Separate TYPE_NAMEs with commas'),
            'add_or_remove_items' => __('Add or remove TYPE_NAMEs'),
            'choose_from_most_used' => __('Choose from the most used TYPE_NAMEs'),
            'menu_name' => __('TYPE_NAMEs Tags'),
        );

        register_taxonomy('csf_TYPE_NAMEs_tags', array('csf_TYPE_NAME'),
                array(
            'public' => true,
            'labels' => $labels,
                )
        );
    }


      /**
     * *************************************************************************
     * meta boxes
     * *************************************************************************
     */

    public function TYPE_NAME_options_meta(){
        $csf_options_meta = new MetaBox(array(
                    'id' => 'TYPE_NAME-options',
                    'title' => 'TYPE_NAME Options',
                    'types' => array('csf_TYPE_NAME'), //
                    'context' => 'side', //side, advance, normal
                    'priority' => 'high', //low , high
                    'template' => MTS_PATH . '/includes/TYPE_NAME-options.php', //meta from
                    'autosave' => TRUE
                ));
    }


}

?>
