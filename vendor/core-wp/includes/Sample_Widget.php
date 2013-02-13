<?php

/**
 * Description of tpl_widget
 *
 * @author Studio365
 * @subpackage Core-wp
 * @package WordPress
 */


//TODO change class title Sample_Widget
class Sample_Widget extends WP_Widget {

    /**
     * Widget setup.
     */

    //TODO change widget name
    function Sample_Widget() {

        /* Widget settings. */
        $widget_ops = array('classname' => 'sample-widget', 'description' => __('Display...', 'sample-widget'));

        /* Widget control settings. */
        //$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );
        $control_ops = array('width' => '100%', 'height' => '100%', 'id_base' => 'sample-widget');

        /* Create the widget. */
        //TODO replace sample-widget with widget slug/name
        $this->WP_Widget('sample-widget', __('Recent-Post(thumbs)', 'sample-widget'), $widget_ops, $control_ops);

    }

    /**
     * Now to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title']);
        $show_desc = $instance['desc'];
        //$show_sex = isset( $instance['show_sex'] ) ? $instance['show_sex'] : false;

        /* Before widget (defined by themes). */
        echo $before_widget;
        echo "<div class=\"sample-widget\" >";

        /* Display the widget title if one was input (before and after defined by themes). */
        if ($title)
            echo $before_title . $title . $after_title;


        /* After widget (defined by themes). */
        echo "</div>";
        echo $after_widget;
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['desc'] = strip_tags($new_instance['desc']);
        //$instance['thumbs'] = strip_tags($new_instance['thumbs']);
        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance) {

        /* Set up some default widget settings. */
        //TODO change title Sample widget to widget name
        $defaults = array('title' => __('Sample Widget', 'bj'), 'desc' => '',);
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sample-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
                   value="<?php echo $instance['title']; ?>" style="width:90%;" />
        </p>

        <!-- Your Name: Text Input -->

        <p>
            <label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Show Title/desctiption:', 'sample-widget'); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" value="ON" <?php echo ($instance['desc'] == 'ON') ? 'checked="checked"' : ''; ?> />

        </p>



        <?php
    }

        /*
     * Register the widget here in the
     * class requires autoloader / include this file
     */

    public static function register_widget(){
        add_action('widgets_init', array('Sample_Widget','register_sample_widget'));

    }

    public function register_sample_widget(){
         register_widget('Sample_Widget');
    }

}

