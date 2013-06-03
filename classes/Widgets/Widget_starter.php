<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostsAdvanced
 *
 * @author studio
 */
class Widgets_AdvancedPost extends WP_Widget {

    protected $var;

    //$widget_id, $widget_name, $widget_description, $width = 300
    public function __construct() {

        /**
         * Setup your widget here
         */
        $widget_id = 'advanced-posts';
        $widget_name = 'Posts widgets';
        $widget_description = 'Displays your posts';
        $width = 300;
        $widget_options = array('classname' => $widget_id . '-widget', 'description' => $widget_description);
        $control_options = array('width' => $width, 'height' => 350, 'id_base' => $widget_id);

        parent::__construct(
                $widget_id, // Base ID
                $widget_name, // Name
                $widget_options, // widget Options
                $control_options// Args
        );
    }

    public function form($instance) {
        // outputs the options form on admin

    }

    public function update($new_instance, $old_instance) {
        // processes widget options to be saved
    }

    public function widget($args, $instance) {
        // outputs the content of the widget
    }

    public static function register_widget() {
        add_action('widgets_init', array(__CLASS__, 'the_widget'));

    }

    public function the_widget() {
        register_widget(__CLASS__);
    }

}

