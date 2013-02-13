<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function contact_form_init() {
	if ( function_exists( 'akismet_http_post' ) ) {
		add_filter( 'contact_form_is_spam', 'contact_form_is_spam_akismet', 10 );
		add_action( 'contact_form_akismet', 'contact_form_akismet_submit', 10, 2 );
	}
	if ( !has_filter( 'widget_text', 'do_shortcode' ) )
		add_filter( 'widget_text', 'contact_form_widget_shortcode_hack', 5 );

	// custom post type we'll use to keep copies of the feedback items
	register_post_type( 'feedback', array(
		'labels'	=> array(
			'name'			=> __( 'Feedbacks' ),
			'singular_name'	=> __( 'Feedback' ),
			'search_items'	=> __( 'Search Feedback' ),
			'not_found'		=> __( 'No feedback found' ),
			'not_found_in_trash'	=> __( 'No feedback found' )
		),
		'menu_icon'		=> GRUNION_PLUGIN_URL . '/images/grunion-menu.png',
		'show_ui'		=> TRUE,
		'public'		=> FALSE,
		'rewrite'		=> FALSE,
		'query_var'		=> FALSE,
		'capability_type'	=> 'page'
	) );

	register_post_status( 'spam', array(
		'label'			=> 'Spam',
		'public'		=> FALSE,
		'exclude_from_search'	=> TRUE,
		'show_in_admin_all_list'=> FALSE,
		'label_count' => _n_noop( 'Spam <span class="count">(%s)</span>', 'Spam <span class="count">(%s)</span>' ),
		'protected'		=> TRUE,
		'_builtin'		=> FALSE
	) );

	/* Can be dequeued by placing the following in wp-content/themes/yourtheme/functions.php
	 *
	 * 	function remove_grunion_style() {
	 *		wp_dequeue_style('grunion.css');
	 *	}
	 *	add_action('wp_print_styles', 'remove_grunion_style');
	 */

	wp_register_style('grunion.css', GRUNION_PLUGIN_URL . 'css/grunion.css');
}

add_action( 'media_buttons', 'grunion_media_button', 999 );
function grunion_media_button( ) {
	global $post_ID, $temp_ID;
	$iframe_post_id = (int) (0 == $post_ID ? $temp_ID : $post_ID);
	$title = esc_attr( __( 'Add a custom form' ) );
	$plugin_url = esc_url( GRUNION_PLUGIN_URL );
	$site_url = admin_url( "/admin-ajax.php?post_id=$iframe_post_id&amp;grunion=form-builder&amp;action=grunion_form_builder&amp;TB_iframe=true&amp;width=768" );

	echo '<a href="' . $site_url . '&id=add_form" class="thickbox" title="' . $title . '"><img src="' . $plugin_url . '/images/grunion-form.png" alt="' . $title . '" width="13" height="12" /></a>';
}
