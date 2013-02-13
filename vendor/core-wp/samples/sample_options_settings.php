<?php

class XXX_options {

    private $options;

    public function __construct() {
        add_action('admin_init', 'options_init');
        add_action('admin_menu', 'options_menu');
    }

    // Init plugin options to white list our options
    public function options_init() {
        register_setting('XXX_options', 'XXX', array(&$this,'validate'));
    }

// Add menu page
    public function options_menu() {

        //add_media_page($page_title, $menu_title, $capability, $menu_slug, $function)
        //add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position)
        //add_options_page($page_title, $menu_title, $capability, $menu_slug, $function)
        //add_posts_page($page_title, $menu_title, $capability, $menu_slug, $function)
        //add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function)
        add_options_page('XXX Options', 'XXX Options', 'manage_options', 'XXX_options', array(&$this,'options'));
    }

// Draw the menu page itself
    public function options() {
        ?>
        <div class="wrap">
            <h2>Ozh's Sample Options</h2>
            <form method="post" action="options.php">
                <?php settings_fields('XXX_options'); ?>
                <?php $options = get_option('XXX'); ?>
                <table class="form-table">
                    <tr valign="top"><th scope="row">A Checkbox</th>
                        <td><input name="XXX_options[value1]" type="checkbox" value="1" <?php checked('1', $options['value1']); ?> /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Some text</th>
                        <td><input type="text" name="XXX_options[value2]" value="<?php echo $options['value2']; ?>" /></td>
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
    public function validate($input) {
        // Our first value is either 0 or 1
        $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

        // Say our second option must be safe text with no HTML tags
        $input['sometext'] = wp_filter_nohtml_kses($input['sometext']);

        return $input;
    }

}

