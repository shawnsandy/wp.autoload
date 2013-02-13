<?php

/**
 * The file userription. *
 * @package BJ
 * @since BJ 1.0
 */
class BJ_Contact_Widget extends WP_Widget {

    /**
     * Widget setup.
     */
    function BJ_Contact_Widget() {

        /* Widget settings. */
        $widget_ops = array('classname' => 'contact-widget',
            'description' => __('Display contact info of author profile on post or pages and site / theme contact on others', 'bj'));

        /* Widget control settings. */
        //$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );
        $control_ops = array(
            'width' => '100%',
            'height' => '100%',
            'id_base' => 'bj-contact-widget');

        /* Create the widget. */

        $this->WP_Widget('bj-contact-widget', __('Contact Box', 'bj'), $widget_ops, $control_ops);
    }

    /**
     * Now to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title']);
        //$show_user = $instance['user'];
        //$show_sex = isset( $instance['show_sex'] ) ? $instance['show_sex'] : false;

        /* Before widget (defined by themes). */
        echo $before_widget;
        echo "<div class=\"bj-contact-widget\" >";

        /* Display the widget title if one was input (before and after defined by themes). */
        if ($title)
            echo $before_title . $title . $after_title;
        if (is_single() or is_page()):
            BJ::contact_author();
        else :
            BJ::contact_org();
        endif;


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

        $defaults = array('title' => __('Contact Widget', 'bj'), 'user' => '',);
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'bj-contact-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
                   value="<?php echo $instance['title']; ?>" style="width:90%;" />
        </p>
        <?php
    }

    /*
     * Register the widget here in the
     * class requires autoloader
     */

    public static function register_widget() {
        add_action('widgets_init', array('BJ_Contact_Widget', 'register_contact_widget'));
    }

    public function register_contact_widget() {
        register_widget('BJ_Contact_Widget');
    }

}

