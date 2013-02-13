<?php

/**
 * Description of cwp_ui
 *
 * @author Studio365
 */
class cwp_ui {

    //put your code here

    private static $instance;

     /**
     * Singleton Pattern
     * @return class object
     */
     public static function instance(){
         if (!is_object(self::$instance)) {
             $class = __CLASS__ ;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function __construct() {
        //$this->add_roles();
        //if (current_user_can('administrator'))
        if(!current_user_can('manage_options') )
            return;
        $this->post_types();

        /**
         * *****************************************************************************
         * Custom Options page
         * *****************************************************************************
         */

        if (file_exists(get_stylesheet_directory() . '/includes/theme-options/custom_ui_options.php')):
            require_once get_stylesheet_directory() . '/includes/theme-options/custom_ui_options.php';
            custom_ui_options::instance()->opts();
        elseif (file_exists(CWP_PATH . '/theme-options/custom_ui_options.php')):
            require_once CWP_PATH . '/theme-options/custom_ui_options.php';
            if (is_admin())
                custom_ui_options::instance()->instructions()->theme_options()->offline_options()->custom_404_options()->search_options()->theme_images();
        endif;


//        if(is_admin()):
//        $screen = get_current_screen();
//        if ('cwp_custom_options' == $screen->post_type) {
//            add_filter('enter_title_here', function($title) {
//                        //global $_title, $post_type;
//                        $title = "My New Title";
//                        return $title;
//                    });
//        }
//        endif;


    }

    public static function factory() {
        return new cwp_ui;
    }

    public function post_types() {
        $icon = CWP_URL . '/menu-images/process.png';
        $labels = array(
            'name' => _x('Custom UI' . 's', 'post type general name'),
            'singular_name' => _x('Custom UI', 'post type singular name'),
            'add_new' => _x('Add New', 'Custom UI Option'),
            'add_new_item' => __('Add New Custom UI Item'),
            'edit_item' => __('Edit Custom UI'),
            'new_item' => __('New Custom UI'),
            'view_item' => __('View Custom UI'),
            'search_items' => __('Search Custom UI'),
            'not_found' => __('No Custom UI(s) found'),
            'not_found_in_trash' => __('No Custom Theme Options found in Trash'),
            'parent_item_colon' => '',
            'menu_name' => 'UI Options'
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array("slug" => "cwp_options"),
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => true,
            'menu_position' => 25,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'menu_icon' => $icon,
            'supports' => array('title', 'thumbnail', 'custom-fields'),
            'taxonomies' => array('post_tage','category'),
            'meta_cap' => null
                //'title','editor','author','thumbnail','excerpt','comments',trackbacks,custom-fields,post-formats,revisions,page-attributes
        );
        //>>>>> change post type from Article
        register_post_type('cwp_custom_options', $args);

        add_filter('post_updated_messages', array(&$this, 'updated_messages'));
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
        //add_action('load-post.php', array($this,'input_title'));
        add_action('load-post-new.php', array($this,'input_title'));
    }

    public function input_title() {
        $screen = get_current_screen();
        if ($screen->post_type == 'cwp_custom_options'):
            add_filter('enter_title_here', array($this,'cwp_input_title'));
        endif;
    }

    public function cwp_input_title($title) {
        $title = "UI-Option Title";
        return $title;
    }

    public function add_roles() {
        global $wp_roles;
        $wp_roles->add_role('custom_options', 'UI Admin', array('manage_ui_options', 'delete_ui_options'));
        //$wp_roles->add_cap('administrator','manage_ui_options');
        //$wp_roles->add_cap('manage_ui_options');
    }

    /**
     * ************************MESSAGE*****************************************
     */

    /**
     * Add postype update message filter
     */
    public function update_message_filter() {
        add_filter('post_updated_messages', array(&$this, 'updated_messages'));
    }

//add filter to ensure the text Article, or Article, is displayed when user updates a Article
//add_filter('post_updated_messages', 'codex_Article_updated_messages');
    public function updated_messages($messages) {
        global $post, $post_ID;

        //************** change name here*********************
        //$name = ($this->get_label() ? $this->get_label() : $this->get_menu_title());
        $messages['cwp_custom_options'] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf(__('Custom Theme Option' . ' updated.'), esc_url(get_permalink($post_ID))),
            2 => __('Custom Theme Option updated.'),
            3 => __('Custom Theme Option deleted.'),
            4 => __('Custom Theme Option updated.'),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf(__('Custom Theme Option  restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__('Custom Theme Option published.'), esc_url(get_permalink($post_ID))),
            7 => __('Custom Theme Option  saved.'),
            8 => sprintf(__('Custom Theme Option  submitted.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__('Custom Theme Option  scheduled for: <strong>%1$s</strong>. '),
                    // translators: Publish box date format, see http://php.net/date
                    date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__('Custom Theme Option draft updated. '), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );

        return $messages;
    }

    /**
     * ******************************HELP**************************************
     */
    //display contextual help for Articles
    //remove comments on contextual_hel action (//) to use

    public function help_text_filter() {
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
    }

    public function help_text($contextual_help, $screen_id, $screen) {
        //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
        if ('cwp_custom_options' == $screen->id) {
            $contextual_help = 'The title field and the big Post Editing Area are fixed in place, but you can reposition all the other boxes using drag and drop, and can minimize or expand them by clicking the title bar of each box. Use the Screen Options tab to unhide more boxes (Excerpt, Send Trackbacks, Custom Fields, Discussion, Slug, Author) or to choose a 1- or 2-column layout for this screen.

<strong>Title</strong> - Enter a title for your post. After you enter a title, you’ll see the permalink below, which you can edit.

<strong>Post editor</strong> - Enter the text for your post. There are two modes of editing: Visual and HTML. Choose the mode by clicking on the appropriate tab. Visual mode gives you a WYSIWYG editor. Click the last icon in the row to get a second row of controls. The HTML mode allows you to enter raw HTML along with your post text. You can insert media files by clicking the icons above the post editor and following the directions. You can go the distraction-free writing screen, new in 3.2, via the Fullscreen icon in Visual mode (second to last in the top row) or the Fullscreen button in HTML mode (last in the row). Once there, you can make buttons visible by hovering over the top area. Exit Fullscreen back to the regular post editor.

<strong>Publish</strong> - You can set the terms of publishing your post in the Publish box. For Status, Visibility, and Publish (immediately), click on the Edit link to reveal more options. Visibility includes options for password-protecting a post or making it stay at the top of your blog indefinitely (sticky). Publish (immediately) allows you to set a future or past date and time, so you can schedule a post to be published in the future or backdate a post.

<strong>Post Format</strong> - This designates how your theme will display a specific post. For example, you could have a <em>standard</em> blog post with a title and paragraphs, or a short <em>aside</em> that omits the title and contains a short text blurb. Please refer to the Codex for<a href="http://codex.wordpress.org/Post_Formats#Supported_Formats">descriptions of each post format</a>. Your theme could enable all or some of 10 possible formats.

<strong>Featured Image</strong> - This allows you to associate an image with your post without inserting it. This is usually useful only if your theme makes use of the featured image as a post thumbnail on the home page, a custom header, etc.

<strong>Send Trackbacks</strong> - Trackbacks are a way to notify legacy blog systems that you’ve linked to them. Enter the URL(s) you want to send trackbacks. If you link to other WordPress sites they’ll be notified automatically using pingbacks, and this field is unnecessary.

<strong>Discussion</strong> - You can turn comments and pings on or off, and if there are comments on the post, you can see them here and moderate them.

You can also create posts with the <a href="http://jesusnowministry.org/wp-admin/options-writing.php">Press This bookmarklet</a>.

<strong>For more information:</strong>

<a href="http://siteflowmedia.com" target="_blank">Documentation on Managing Articles</a>

<a href="http://support.siteflowmedia.com/" target="_blank">Support Forums</a>';
        } elseif ('edit-cwp_custom_options' == $screen->id) {
            $contextual_help =
                    '<p>You can customize the display of this screen in a number of ways</p>:
<ul>
	<li>You can hide/display columns based on your needs and decide how many Articles to list per screen using the Screen Options tab.</li>
	<li>You can filter the list of Articles by Article status using the text links in the upper left to show All, Published, Draft, or Trashed Articles. The default view is to show all Articles.</li>
	<li>You can view Articles in a simple title list or with an excerpt. Choose the view you prefer by clicking on the icons at the top of the list on the right.</li>
	<li>You can refine the list to show only Articles in a specific category or from a specific month by using the dropdown menus above the Articles list. Click the Filter button after making your selection. You also can refine the list by clicking on the Article author, category or tag in the Articles list.</li>
</ul>
Hovering over a row in the Articles list will display action links that allow you to manage your Article. You can perform the following actions:
<ul>
	<li>Edit takes you to the editing screen for that Article. You can also reach that screen by clicking on the Article title.</li>
	<li>Quick Edit provides inline access to the metadata of your Article, allowing you to update Article details without leaving this screen.</li>
	<li>Trash removes your Article from this list and places it in the trash, from which you can permanently delete it.</li>
	<li>Preview will show you what your draft Article will look like if you publish it. View will take you to your live site to view the Article. Which link is available depends on your Article’s status.</li>
</ul>
You can also edit multiple Articles at once. Select the Articles you want to edit using the checkboxes, select Edit from the Bulk Actions menu and click Apply. You will be able to change the metadata (categories, author, etc.) for all selected Articles at once. To remove a Article from the grouping, just click the x next to its name in the Bulk Edit area that appears.

<strong>For more information:</strong>

<a href="http://siteflowmedia.com" target="_blank">Documentation on Managing Articles</a>

<a href="http://support.siteflowmedia.com/" target="_blank">Support Forums</a>';
        }
        return $contextual_help;
    }

}
