<?php

/**
 * Description of tpl_widget
 *
 * @author Studio365
 * @subpackage Core-wp
 * @package WordPress
 */


class Tpl_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Tpl_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tpl-widget',
                    'description' => __('Quickly (re)use theme custom php files/scripts in your widgets, place php files in theme/includes/widgets. please use wisely!', 'tpl-widget') );

		/* Widget control settings. */
		//$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );
		$control_ops = array( 'width' => '100%', 'height' => '100%', 'id_base' => 'tpl-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tpl-widget', __('PHP.Custom Widgets', 'tpl-widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$slug = $instance['slug'];
		$name = $instance['name'];
		//$show_sex = isset( $instance['show_sex'] ) ? $instance['show_sex'] : false;

		/* Before widget (defined by themes). */
		echo $before_widget;

                /* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

               if($name):
                  //echo "slug ".$slug." name: ".$name;
                  //cwp_layout::tpl_part($slug, $name);
                  get_template_part('includes/widgets/'.$slug, $name);
                   else:
                   echo "ERROR: Tpl not defined";
               endif;
		//

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		//$instance['name'] = strip_tags( $new_instance['name'] );

		/* No need to strip tags for sex and show_sex. */
		$instance['slug'] = strip_tags($new_instance['slug']);
		$instance['name'] = strip_tags($new_instance['name']);

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Elements-Widgets', 'tpl-widget'), 'name' => __('sample'),'slug' => __('elements'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

                <!-- ############## -->
		<p>
			<label for="<?php echo $this->get_field_id( 'slug' ); ?>"><?php _e('template Slug:', 'tpl-widget'); ?></label>
			<input id="<?php echo $this->get_field_id( 'slug' ); ?>" name="<?php echo $this->get_field_name( 'slug' ); ?>" value="<?php echo $instance['slug']; ?>" style="width:100%;" />
		</p>

		<!-- ############## -->
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Template Name:', 'tpl-widget'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>





	<?php

	}

}

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tpl_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tpl_load_widgets() {
	register_widget( 'Tpl_Widget' );
}
