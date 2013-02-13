<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * ******************************plugin activations*****************************
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
if(file_exists(dirname( __FILE__ ) . '/tgm-plugin-activation/class-tgm-plugin-activation.php')){


require_once dirname( __FILE__ ) . '/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'cwp_theme_plugins' );

}

function cwp_theme_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */

    if(file_exists(dirname( __FILE__ ) . '/includes/tgm-plugin-activation/theme-plugins.php')):

            include_once dirname( __FILE__ ) . '/includes/tgm-plugin-activation/theme-plugins.php';
    else :
        $plugins = array(
		/** This is an example of how to include a plugin pre-packaged with a theme */
		array(
			'name'     => 'TGM Example Plugin', // The plugin name
			'slug'     => 'tgm-example-plugin', // The plugin slug (typically the folder name)
			'source'   => get_stylesheet_directory() . '/includes/tgm-plugin-activation/plugins/tgm-example-plugin.zip', // The plugin source
			'required' => true // If false, the plugin is only 'recommended' instead of required
		),
		/** This is an example of how to include a plugin from the WordPress Plugin Repository */
		array(
			'name' => 'BuddyPress',
			'slug' => 'buddypress',
			'required' => false
		),
            array(
			'name' => 'WordPress SEO by Yoast',
			'slug' => 'wordpress-seo',
			'required' => false
		),
		array(
			'name' => 'Google Analytics for WordPress',
			'slug' => 'google-analytics-for-wordpress',
			'required' => false
		),
            array(
			'name' => 'Jetpack by WordPress.com',
			'slug' => 'jetpack',
			'required' => false
		),
	);
    endif;


	/** Change this to your theme text domain, used for internationalising strings */
	$theme_text_domain = 'basejump';

	/**
	 * Array of configuration settings. Uncomment and amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * uncomment the strings and domain.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
        /* 'domain'       => $theme_text_domain,         // Text domain - likely want to be the same as your theme. */
        /* 'default_path' => '',                         // Default absolute path to pre-packaged plugins */
        'menu' => 'install-required-plugins', // Menu slug */
        'notices' => true, // Show admin notices or not */
        'strings' => array(
        'page_title' => __('Install Required Plugins', $theme_text_domain), // */
        'menu_title' => __('Install Plugins', $theme_text_domain), // */
         'instructions_install' => __('The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain), // %1$s = plugin name */
         'instructions_install_recommended' => __('The %1$s plugin is recommended for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain), // %1$s = plugin name, %2$s = plugins page URL */
          'instructions_activate' => __('The %1$s plugin is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain), // %1$s = plugin name, %2$s = plugins page URL */
          'button' => __('Install %s Now', $theme_text_domain), // %1$s = plugin name */
          'installing' => __('Installing Plugin: %s', $theme_text_domain), // %1$s = plugin name */
          'oops' => __( 'Something went wrong with the plugin API.', $theme_text_domain ), // */
        'notice_can_install_required'  => __( 'This theme requires the following plugins: %1$s.', $theme_text_domain ), // %1$s = plugin names */
        'notice_can_install_recommended' => __( 'This theme recommends the following plugins: %1$s.', $theme_text_domain ), // %1$s = plugin names */
       'notice_cannot_install'=> __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ), // %1$s = plugin name */
        'notice_can_activate_required' => __( 'The following required plugins are currently inactive: %1$s.', $theme_text_domain ), // %1$s = plugin names */
        'notice_can_activate_recommended' => __( 'The following recommended plugins are currently inactive: %1$s.', $theme_text_domain ), // %1$s = plugin names */
        'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ), // %1$s = plugin name */
        'return' => __( 'Return to Required Plugins Installer', $theme_text_domain ), // */
        'plugin_activated' => __( 'Plugin activated successfully.', $theme_text_domain ) // */
        )
	);

	tgmpa( $plugins, $config );

}


