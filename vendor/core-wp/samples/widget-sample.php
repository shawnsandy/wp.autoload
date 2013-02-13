<?php
/**
 * Example Widget Class
 */

/**
 * setup
 * rename / change xxx to sample_widget
 *
 */
class xxx_widget extends WP_Widget {


    /** constructor -- name this the same as the class above */
    function xxx_widget() {
        // Set some widget options
        $widget_options = array( 'message' => 'Widget description', 'classname' => 'XXX-signup' );
        // Set some control options (width, height etc)
        $control_options = array( 'xxx_width' => 300 );
        // Actually create the widget (widget id, widget name, options...)
        parent::WP_Widget(false, $name = 'XXX Widget', $widget_options, $control_options);
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        extract( $args );

        $title 		= apply_filters('widget_title', $instance['title']);
        $message 	= $instance['message'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
								<li><?php echo $message; ?></li>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['message'] = strip_tags($new_instance['message']);
        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {

        // These are our default values
        $defaults = array( 'title' => 'Example', 'message' => 'Subscribe to our newsletter using the form below.', 'code' => '' );
        // This overwrites any default values with saved values
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title 		= esc_attr($instance['title']);
        $message	= esc_attr($instance['message']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple Message'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo $message; ?>" />
        </p>
        <?php
    }


} // end class example_widget
add_action('widgets_init', create_function('', 'return register_widget("xxx_widget");'));
?>