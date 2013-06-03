<?php


/**
 * Description of Pages
 *
 * @author studio
 */
class Theme_Setup_Pages extends Theme_Setup {

      public function __construct() {
        parent::__construct();
        //$this->set_post_type('page');
    }

    public static function factory() {
        return $factory = new Theme_Setup_Pages();
    }

    /**
     * Create default pages for your theme uses post titles
     * Add page templates to theme directory to find the template dir and custom page template will be set automatically follow naming convetions
     * Page name convetions (all lowercase / spaces converted to ' - ' ) @example Contact Us (Page Title) > contact-us.php (template name)
     * @param aray $title_array - array('Home Page', 'About', 'Contact')
     */
    public function setup($title_array = array('Home Page', 'About', 'Contact')) {

        //$theme_page = $this->theme_page();
        // @source roots theme framework (modified)
        // on theme activation make sure there's a Home page
        // create it if there isn't and set the Home page menu order to -1
        // set WordPress to have the front page display the Home page as a static page
        $default_pages = $title_array;
        $existing_pages = get_pages();
        $temp = array();

        foreach ($existing_pages as $page) {
            $temp[] = $page->post_title;
        }

        $pages_to_create = array_diff($default_pages, $temp);

        foreach ($pages_to_create as $new_page_title) {

            // create post object
            $add_default_pages = array(
                'post_title' => $new_page_title,
                'post_content' => $this->get_post_content(),
                'post_status' => $this->get_post_status(),
                'post_type' => $this->get_post_type(),
                    //'post_parent' => $theme_page
            );

            // insert the post into the database
            $result = wp_insert_post($add_default_pages);
        }

// set the theme default home page if home page is set
        $home_page = $this->get_home_page();
        if (isset($home_page) and is_array($home_page)):
            $home = get_page_by_title($home_page);
            if (is_page($home->ID)):
                update_option('show_on_front', 'page');
                update_option('page_on_front', $home->ID);

                $home_menu_order = array(
                    'ID' => $home->ID,
                    'menu_order' => -1
                );
                wp_update_post($home_menu_order);
            endif;
        endif;

        $this->get_page_templates($title_array);
        return $this;
    }

    /**
     * Add Theme page Parent and return the ID
     * @return type
     */
    public function theme_page($parent_title = 'Theme Pages') {
        $themepage = get_page_by_title($parent_title);

        if (isset($themepage->ID)):
            $theme_page = $themepage->ID;
        else:

            $theme_page_array = array(
                'post_title' => "Theme Pages",
                'post_content' => "Theme pages parent page",
                'post_status' => "publish",
                'post_type' => $this->get_post_type()
            );
            $theme_page = wp_insert_post($theme_page_array);

        endif;

        return $theme_page;
    }

    /**
     * Attaches a template to a (home page) page
     * Add page templates to theme directory to find the template dir and custom page template will be set automatically follow naming convetions
     * Page name convetions (all lowercase / spaces converted to ' - ' ) @example Contact Us (Page Title) > contact-us.php (template name)
     * @param type $title_array
     */
    public function get_page_templates($title_array = array('Home Page')) {

        foreach ($title_array as $titles):

            $title = get_page_by_title($titles);

            if (isset($title->ID)):
                //$tpl = strtolower(sanitize_title_with_dashes($titles));
                $tpl = $title->post_name;
                $tpl_file = $tpl . ".php";
                //find page templates and set update the page templates
                if (file_exists(get_template_directory() . '/' . $tpl_file)):
                    update_post_meta($title->ID, '_wp_page_template', $tpl_file);
                endif;
            endif;

        endforeach;
    }

    /**
     * resets the home page options
     */
    public static function reset_default_homepage() {
        update_option('show_on_front', 'posts');
        update_option('page_on_front', '0');
    }

}

