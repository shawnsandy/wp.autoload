<?php
/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */

//add_action('widgets_init', create_function('', 'return register_widget("Newsletter_Signup_Widget");'));

class XXX extends WP_Widget
{
    // Register the widget
    function Newsletter_Signup_Widget() {
        // Set some widget options
        $widget_options = array( 'description' => 'Allow users to signup to your newsletter easily', 'classname' => 'XXX-signup' );
        // Set some control options (width, height etc)
        $control_options = array( 'width' => 300 );
        // Actually create the widget (widget id, widget name, options...)
        $this->WP_Widget( 'newsletter-signup-widget', 'Newsletter Signup', $widget_options, $control_options );
    }

    // Output the content of the widget
    function widget($args, $instance) {
        extract( $args ); // Don't worry about this

        // Get our variables
        $title = apply_filters( 'widget_title', $instance['title'] );
        $text = $instance['text'];
        $code = $instance['code'];

        // This is defined when you register a sidebar
        echo $before_widget;

        // If our title isn't empty then show it
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        // If our description isn't empty then show it
        if ( $text ) {
            echo '<p>'. $text .'</p>';
        }

        // If we have some code then output it
        if ( $code ) {
            echo $code;
        }

        // This is defined when you register a sidebar
        echo $after_widget;
    }

    // Output the admin options form
    function form($instance) {
        // These are our default values
        $defaults = array( 'title' => 'Example', 'text' => 'Subscribe to our newsletter using the form below.', 'code' => '' );
        // This overwrites any default values with saved values
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
                <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Description:'); ?></label>
                <input id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $instance['text']; ?>" type="text" class="widefat" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('code'); ?>"><?php _e('Code:'); ?></label>
                <textarea id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" rows="10" class="widefat"><?php echo $instance['code']; ?></textarea>
            </p>
        <?php
    }

    // Processes the admin options form when saved
    function update($new_instance, $old_instance) {
        // Get the old values
        $instance = $old_instance;

        // Update with any new values (and sanitise input)
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['text'] = strip_tags( $new_instance['text'] );
        $instance['code'] = $new_instance['code'];

        return $instance;
    }

}
