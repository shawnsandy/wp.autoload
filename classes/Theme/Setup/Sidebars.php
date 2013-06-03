<?php


/**
 * Description of Sidebars
 *
 * @author studio
 */

class Theme_Setup_Sidebars {

   private function __construct() {

    }

    /**
     *
     * @param type $name
     * @param type $widget_id
     * @param type $description
     * @param type $id
     * @param type $div
     * @param type $title
     *
     * <code>
     * //example
     * cwp::add_widget('Top Sidebar', 'top-sidebar', 'Top sidebar widget');
     * </code>
     */
    public function register($name, $widget_id, $description = "", $id = 'widgets', $div = "aside", $title = 'h3') {
        //$widget_id = preg_replace(" ", "-", $name);
        register_sidebar(array(
            'name' => ucfirst($name), $id,
            'id' => $name,
            'description' => $description,
            'before_widget' => '<' . $div . ' id="%1$s" class="widget %2$s">',
            'after_widget' => "</{$div}>",
            'before_title' => '<' . $title . ' class="widget-title">',
            'after_title' => '</' . $title . '>',
        ));
    }

}

