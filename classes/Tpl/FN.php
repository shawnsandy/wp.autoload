<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tags
 *
 * @author studio
 */
class Tpl_FN {

    public function __construct() {

    }

    /**
     * Register siderbars (widgets) - a wrapper for the register sidebar function
     * For those who hate repeating arrays, call me lazzzzzzz but i do....
     *
     * @param string $sidebar_id side bar id (side-id)
     * @param string $sidebar_name The name displayed on the sidebar
     * @param string $sidebar_description The side bar desciription
     * @param init $sidebar_number use register_siderbars() instead, 2, registers 2 sidebars side_id-1, sidebar_id-2...
     * @link http://codex.wordpress.org/Function_Reference/register_sidebars register siderbars docs
     */
    public static function sidebars($sidebar_id, $sidebar_name, $sidebar_description = '', $sidebar_number = 0) {

        if (is_int($sidebar_number) && $sidebar_number > 1):
            $sidebars = array(
                'name' => sprintf($sidebar_name . ' d%', $i),
                'id' => $sidebar_id . '-' . $i,
                'description' => $sidebar_description,
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => "</div>",
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            );
            register_sidebars($sidebar_number, $sidebars);
        else:
            $sidebars = array(
                'name' => ucfirst($sidebar_name),
                'id' => $sidebar_id,
                'description' => $sidebar_description,
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => "</div>",
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            );
            register_sidebar($sidebars);
        endif;
    }

    public static function get_template_part($slug, $name) {

        $template_names = $slug . '-' . $name . '.php';

        if (empty(locate_template($template_names))) {
            get_template_part($slug, $name);
            return true;
        } else {
            return false;
        }
    }

}

