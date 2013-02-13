<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cwp_themes
 *
 * @author Studio365
 */
class cwp_theme_shop {

    //put your code here

    public function __construct() {
        $this->post_types();
    }

    public function post_types() {
        $type = new cwp_post_type('theme');
        $type->set_publicly_queryable(true)
                ->set_capability_type('post')
                ->set_public(true)
                ->set_menu_title("Theme Catalog")
                ->set_menu_postion(3)
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'theme'))
                ->set_supports(array('title', 'excerpt', 'thumbnail', 'editor','page-attributes'))
                ->set_label("Theme")
                ->set_menu_icon(get_template_directory_uri() . '/library/menu-images/graphic-design.png')
                ->register();

        $theme_cats = new cwp_taxonomy('theme_category', 'Theme Categories');
        $theme_cats->set_post_types('cwp_theme')
                ->set_singular_name('Category')
                ->register();

        $design_tags = new cwp_taxonomy('design', 'Design Tags');
        $design_tags->set_post_types('cwp_theme')
                ->set_singular_name('Design Tag')
                ->set_show_in_nav_menus(false)
                ->tags();

        $modules_tags = new cwp_taxonomy('module', 'Module Tags');
        $modules_tags->set_post_types('cwp_theme')
                ->set_singular_name('Module Tag')
                ->set_show_in_nav_menus(false)
                ->tags();

        $plugin_tags = new cwp_taxonomy('plugin', 'Plugin Tags');
        $plugin_tags->set_post_types('cwp_theme')
                ->set_singular_name('Plugin Tag')
                ->set_show_in_nav_menus(false)
                ->tags();
    }

}
