<?php
/*
Plugin Name: Ozh' Sample Options
Plugin URI: http://planetozh.com/
Description: Shows how to use WP 2.8's register_setting() API
Author: Ozh
Author URI: http://planetozh.com/
*/

add_action('admin_init', 'ozh_sampleoptions_init' );
add_action('admin_menu', 'ozh_sampleoptions_add_page');

// Init plugin options to white list our options
function ozh_sampleoptions_init(){
	register_setting( 'ozh_sampleoptions_options', 'ozh_sample', 'ozh_sampleoptions_validate' );
}

// Add menu page
function ozh_sampleoptions_add_page() {
	add_options_page('Ozh\'s Sample Options', 'Sample Options', 'manage_options', 'ozh_sampleoptions', 'ozh_sampleoptions_do_page');
}

// Draw the menu page itself
function ozh_sampleoptions_do_page() {
	?>
	<div class="wrap">
		<h2>Ozh's Sample Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('ozh_sampleoptions_options'); ?>
			<?php $options = get_option('ozh_sample'); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row">A Checkbox</th>
					<td><input name="ozh_sample[option1]" type="checkbox" value="1" <?php checked('1', $options['option1']); ?> /></td>
				</tr>
				<tr valign="top"><th scope="row">Some text</th>
					<td><input type="text" name="ozh_sample[sometext]" value="<?php echo $options['sometext']; ?>" /></td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function ozh_sampleoptions_validate($input) {
	// Our first value is either 0 or 1
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our second option must be safe text with no HTML tags
	$input['sometext'] =  wp_filter_nohtml_kses($input['sometext']);

	return $input;
}
