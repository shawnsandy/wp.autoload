<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */
class cwp_post_type {
    /*
     * post vars
     */

    //Class variables
    private $post_type_name;
    private $publicly_queryable = true;
    private $menu_icon = null;
    private $public = true;
    private $show_ui = true;
    private $show_in_menu = true;
    private $query_var = true;
    private $rewrite = true;
    private $capabilities = null;
    private $capability_type = 'post';
    private $has_archive = true;
    private $hierarchical = false;
    private $menu_postion = 5;
    private $supports = array('title', 'editor', 'author', 'thumbnail');
    private $help_tpl;
    private $exclude_from_search = false;
    private $menu_title;
    private $map_meta_cap = null,
            $label = null,
            $post_formats = array(),
            $show_in_nav_menus = true,
            $taxonomies = array('category','post_tag');

    public function set_show_in_nav_menus($show_in_nav_menus) {
        $this->show_in_nav_menus = $show_in_nav_menus;
        return $this;
    }

    public function set_taxonomies($taxonomies) {
        $this->taxonomies = $taxonomies;
        return $this;
    }

    /**
     *
     * @param type $post_formats
     * @return cwp_post_type 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'
     */
    public function set_post_formats($post_formats = array('gallery', 'image')) {
        $this->post_formats = $post_formats;
        return $this;
    }

    public function get_label() {
        return $this->label;
    }

    public function set_label($label) {
        $this->label = $label;
        return $this;
    }

    public function get_map_meta_cap() {
        return $this->map_meta_cap;
    }

    public function set_map_meta_cap($map_meta_cap) {
        $this->map_meta_cap = $map_meta_cap;
        return $this;
    }

    public function get_menu_title() {
        return $this->menu_title;
    }

    public function set_menu_title($menu_title) {
        $this->menu_title = $menu_title;
        return $this;
    }

    public function get_exclude_from_search() {
        return $this->exclude_from_search;
    }

    public function set_exclude_from_search($exclude_from_search) {
        $this->exclude_from_search = $exclude_from_search;
        return $this;
    }

    public function get_post_type_name() {
        return $this->post_type_name;
    }

    public function set_post_type_name($post_type_name) {
        $this->post_type_name = $post_type_name;
        return $this;
    }

    public function get_menu_icon() {
        return $this->menu_icon;
    }

    public function set_menu_icon($menu_icon) {
        $this->menu_icon = $menu_icon;
        return $this;
    }

    public function get_public() {
        return $this->public;
    }

    public function set_public($public) {
        $this->public = $public;
        return $this;
    }

    public function get_show_ui() {
        return $this->show_ui;
    }

    public function set_show_ui($show_ui) {
        $this->show_ui = $show_ui;
        return $this;
    }

    public function get_show_in_menu() {
        return $this->show_in_menu;
    }

    public function set_show_in_menu($show_in_menu) {
        $this->show_in_menu = $show_in_menu;
        return $this;
    }

    public function get_query_var() {
        return $this->query_var;
    }

    public function set_query_var($query_var) {
        $this->query_var = $query_var;
        return $this;
    }

    public function get_rewrite() {
        return $this->rewrite;
    }

    public function set_rewrite($rewrite) {
        $this->rewrite = $rewrite;
        return $this;
    }

    public function get_capability_type() {
        return $this->capability_type;
    }

    public function set_capability_type($capability_type) {
        $this->capability_type = $capability_type;
        return $this;
    }

    public function get_has_archive() {
        return $this->has_archive;
    }

    public function set_has_archive($has_archive) {
        $this->has_archive = $has_archive;
        return $this;
    }

    public function get_hierarchical() {
        return $this->hierarchical;
    }

    /**
     * Whether the post type is hierarchical. Allows Parent to be specified.
     * @param type $hieracrchical false
     */
    public function set_hierarchical($hieracrchical) {
        $this->hierarchical = $hieracrchical;
        return $this;
    }

    public function get_menu_postion() {
        return $this->menu_postion;
    }

    public function set_menu_postion($menu_postion) {
        $this->menu_postion = $menu_postion;
        return $this;
    }

    public function get_supports() {
        return $this->supports;
    }

    /**
     * 'title'
     * 'editor' (content)
     * 'author'
     * 'thumbnail' (featured image, current theme must also support post-thumbnails)
     * 'excerpt'
     * 'trackbacks'
     * 'custom-fields'
     * 'comments' (also will see comment count balloon on edit screen)
     * 'revisions' (will store revisions)
     * 'page-attributes' (menu order, hierarchical must be true to show Parent option)
     * 'post-formats' add post formats, see Post Formats
     * @param type $supports array
     */
    public function set_supports($supports = array()) {
        $this->supports = $supports;
        return $this;
    }

    public function get_publicly_queryable() {
        return $this->publicly_queryable;
    }

    public function set_publicly_queryable($publicly_queryable) {
        $this->publicly_queryable = $publicly_queryable;
        return $this;
    }

    public function get_help_tpl() {
        return $this->help_tpl;
    }

    public function set_help_tpl($help_tpl) {
        $this->help_tpl = $help_tpl;
        return $this;
    }

    /**
     *
     * 'labels' => $labels,
     * 'public' => true,
     * 'publicly_queryable' => true,
     * 'show_ui' => true,
     * 'show_in_menu' => true,
     * 'query_var' => true,
     * 'rewrite' => true,
     * 'capability_type' => 'post',
     * 'has_archive' => true,
     * 'hierarchical' => false,
     * 'menu_position' => null,
     * 'supports' => array('title','editor','author','thumbnail','excerpt','comments')
     * @param type $name post type name
     *
     */
    public function __construct($name = 'article') {
        //$this->post_type_name = "cwp_{$name}";
        $this->set_post_type_name($name);
        $this->set_menu_title(ucfirst($name));
        return $this;
    }


    public function category_tags_metabox(){
        add_action('init', array($this,'_category_tags_metabox'));
    }


    public function _category_tags_metabox() {
    register_taxonomy_for_object_type('category', 'cwp_'. $this->post_type_name);
    register_taxonomy_for_object_type('post_tag', 'cwp_'.$this->post_type_name);
    }

    /**
     * register you post type
     */
    public function register($use_capabilities = null) {
        /**
         * custom post type template
         * http://codex.wordpress.org/Function_Reference/register_post_type
         */
        $name = ($this->get_label() ? $this->get_label() : $this->get_menu_title());
        $rewrite = $this->get_rewrite() ? $this->get_rewrite() : $this->get_label();

        $labels = array(
            'name' => _x($name . 's', 'post type general name'),
            'singular_name' => _x($name, 'post type singular name'),
            'add_new' => _x('Add New', $name),
            'add_new_item' => __('Add New ' . $name),
            'edit_item' => __('Edit ' . $name),
            'new_item' => __('New ' . $name),
            'view_item' => __('View ' . $name),
            'search_items' => __('Search ' . $name),
            'not_found' => __('No ' . $name . ' found'),
            'not_found_in_trash' => __('No ' . $name . ' found in Trash'),
            'parent_item_colon' => '',
            'menu_name' => $this->get_menu_title()
        );

        if (isset($this->capabilities)):
            $capability_type = $this->post_type_name;
            //use the default by setting the capabilities using a boolean true;
            if(!is_array($this->capabilities)):
            //******************************************************************
            $caps[edit_post] = "edit_{$capability_type}";
            $caps[read_post] = "read_{$capability_type}";
            $caps[delete_post] = "delete_{$capability_type}";
            //******************************************************************
            $caps[edit_posts] = "edit_{$capability_type}s";
            $caps[edit_others_posts] = "manage_{$capability_type}s";
            $caps[publish_posts] = "edit_{$capability_type}s";
            $caps[read_private_posts] = "edit_{$capability_type}s";
            //******************************************************************
            $caps[delete_posts] = "edit_{$capability_type}s";
            $caps[delete_private_posts] = "edit_{$capability_type}s";
            $caps[delete_published_posts] = "edit_{$capability_type}s";
            $caps[delete_others_posts] = "manage_{$capability_type}s";
            $caps[edit_private_posts] = "edit_{$capability_type}s";
            $caps[edit_published_posts] = "edit_{$capability_type}s";
            $this->capabilities = $caps;
            endif;


            $args = array(
                'labels' => $labels,
                'public' => $this->get_public(),
                'publicly_queryable' => $this->publicly_queryable,
                'show_ui' => $this->get_show_ui(),
                'show_in_menu' => $this->get_show_in_menu(),
                'query_var' => $this->query_var,
                'rewrite' => $this->get_rewrite(),
                'capability_type' => $this->get_capability_type(),
                'capabilities' => $this->capabilities,
                'has_archive' => $this->get_has_archive(),
                'hierarchical' => $this->get_hierarchical(),
                'menu_position' => $this->get_menu_postion(),
                'show_in_menu' => $this->get_show_in_menu(),
                'menu_icon' => $this->get_menu_icon(),
                'show_in_nave_menus' => $this->show_in_nav_menus,
                'supports' => $this->get_supports(),
                'taxonomies' => $this->taxonomies,
                'meta_cap' => $this->map_meta_cap,

                    //'title','editor','author','thumbnail','excerpt','comments',trackbacks,custom-fields,post-formats,revisions,page-attributes
            );
        else:
            //no capabilities
            $args = array(
                'labels' => $labels,
                'public' => $this->get_public(),
                'publicly_queryable' => $this->publicly_queryable,
                'show_ui' => $this->get_show_ui(),
                'show_in_menu' => $this->get_show_in_menu(),
                'query_var' => $this->query_var,
                'rewrite' => $this->get_rewrite(),
                'capability_type' => $this->get_capability_type(),
                'has_archive' => $this->get_has_archive(),
                'hierarchical' => $this->get_hierarchical(),
                'menu_position' => $this->get_menu_postion(),
                'show_in_menu' => $this->get_show_in_menu(),
                'menu_icon' => $this->get_menu_icon(),
                'show_in_nave_menus' => $this->show_in_nav_menus,
                'supports' => $this->get_supports(),
                'taxonomies' => $this->taxonomies,
                'meta_cap' => $this->map_meta_cap
                    //'title','editor','author','thumbnail','excerpt','comments',trackbacks,custom-fields,post-formats,revisions,page-attributes
            );
        endif;


        //>>>>> change post type from Article
        register_post_type('cwp_' . $this->get_post_type_name(), $args);

        add_filter('post_updated_messages', array(&$this, 'updated_messages'));
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
    }



    public function set_administrator() {
        /* Get the administrator role. */
        $role =& get_role('administrator');

        /* If the administrator role exists, add required capabilities for the plugin. */
        if (!empty($role)) {

            $role->add_cap("manage_{$this->post_type_name}s");
            $role->add_cap("edit_{$this->post_type_name}s");
        }
    }

    /**
     * *************************POST FORMATS***********************************
     *
     */

    /**
     * sets custom post type and this post formats
     * @param type $formats - 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'
     */
    public function post_formats() {
        if (!empty($this->post_formats) AND is_array($this->post_formats)):
            $screen = get_current_screen();
            if ($screen->post_type == 'cwp_' . $this->get_post_type_name()):
                //remove_post_type_support( 'post', 'post-formats' );
                add_theme_support('post-formats', $this->post_formats);
            endif;
        endif;
        return $this;
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
        $name = ($this->get_label() ? $this->get_label() : $this->get_menu_title());
        $messages['cwp_' . $this->get_post_type_name()] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf(__($name . ' updated. <a href="%s">View Article</a>'), esc_url(get_permalink($post_ID))),
            2 => __($name . 'updated.'),
            3 => __($name . 'deleted.'),
            4 => __($name . ' updated.'),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf(__($name . ' restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__($name . ' published. <a href="%s">View Article</a>'), esc_url(get_permalink($post_ID))),
            7 => __($name . ' saved.'),
            8 => sprintf(__($name . ' submitted. <a target="_blank" href="%s">Preview Article</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__($name . ' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Article</a>'),
                    // translators: Publish box date format, see http://php.net/date
                    date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__($name . ' draft updated. <a target="_blank" href="%s">Preview Article</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );

        return $messages;
    }

    /**
     * ******************************HELP**************************************
     */
    //display contextual help for Articles
    //remove comments on contextual_hel action (//) to use
    //

    public function help_text_filter() {
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
    }

    public function help_text($contextual_help, $screen_id, $screen) {
        //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
        if ('cwp_' . $this->get_post_type_name() == $screen->id) {
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
        } elseif ('edit-cwp_' . $this->get_post_type_name() == $screen->id) {
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
';
        }
        return $contextual_help;
    }

}
