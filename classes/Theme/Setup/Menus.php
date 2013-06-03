<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menus
 *
 * @author studio
 */
class Theme_Setup_Menus {

    private $location = 'primary',
            $menu = 'primary';

    public function set_location($location) {
        $this->location = $location;
        return $this;
    }

    public function set_menu($menu) {
        $this->menu = $menu;
        return $this;
    }

    public function __construct() {

    }

    public static function factory() {

        return $factory = new Theme_Setup_Menus();
    }

    /**
     * Add pages links to the menu
     * @param array $pages array(About,Contact)
     */
    public function add_pages($pages = array('About', 'Contact')) {

        //register_nav_menu($this->location, __('Primary Menu'));
        //check to see if the primary menu has a location assigned
        if (!is_nav_menu($this->menu)) {
            //assign the menu and get the id
            $menu_id = wp_create_nav_menu(ucfirst($this->menu));
            // set our new MENU up at our theme's nav menu location
            $locations[$this->location] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);


            //Create a home menu item
            $menu_home = array(
                'menu-item-type' => 'custom',
                'menu-item-url' => get_site_url(),
                'menu-item-title' => 'Home',
                'menu-item-attr-title' => 'Home',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $menu_home);

            if (is_array($pages) AND !empty($pages)):
                //loop pages
                foreach ($pages as $_page):
                    //get the page
                    $page = get_page_by_title($_page);
                    //if page exist add to menu
                    if (isset($page->ID)):
                        $menu = array(
                            'menu-item-object-id' => $page->ID,
                            'menu-item-parent-id' => 0,
                            'menu-item-position' => 0,
                            'menu-item-object' => 'page',
                            'menu-item-type' => 'post_type',
                            'menu-item-status' => 'publish');
                        wp_update_nav_menu_item($menu_id, 0, $menu);
                    endif;
                endforeach;
            endif;

            //assign menu location
            //set_theme_mod('nav_menu_locations', array($this->location => $menu_id,));
//            $locations = get_theme_mod('nav_menu_locations');
//            $locations['nav_menu_locations'][$this->location] = $menu_id;
//            set_theme_mod('nav_menu_locations', $locations);
        }

        return $this;
    }

    public static function set_menu_location($menu_id = 'primary', $location = 'primary') {
        if (!has_nav_menu($menu_id) AND is_nav_menu($menu_id)) {
            $menu = wp_get_nav_menu_object($menu_id);
            $locations["{$location}"] = $menu->term_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }

}


