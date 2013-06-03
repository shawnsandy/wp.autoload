<?php

/**
 * Description of Basejump_PluginCheck
 * Simple class to let themes add dependencies on plugins in ways they might find useful

  <code>
  $test = new Theme_Plugin_Dependency( 'simple-facebook-connect', 'http://ottopress.com/wordpress-plugins/simple-facebook-connect/' );
  if ( $test->check_active() )
  echo 'SFC is installed and activated!';
  else if ( $test->check() )
  echo 'SFC is installed, but not activated. <a href="'.$test->activate_link().'">Click here to activate the plugin.</a>';
  else if ( $install_link = $test->install_link() )
  echo 'SFC is not installed. <a href="'.$install_link.'">Click here to install the plugin.</a>';
  else
  echo 'SFC is not installed and could not be found in the Plugin Directory. Please install this plugin manually.';
 * </code>
 * @author ottopress
 * @link http://ottopress.com/2012/themeplugin-dependencies/ Original source
 * @package Basejump
 * @copyright (c) GPL,
 * @since ver 0.1
 */
class Basejump_Plugins_Dependency {

    // input information from the theme
    private $slug;
    private $uri;
    // installed plugins and uris of them
    private $plugins; // holds the list of plugins and their info
    private $uris; // holds just the URIs for quick and easy searching
    
    protected
            $active_text = 'SFC is installed and activated!',
            $not_active_text = 'SFC is installed, but not activated. Click here to install the plugin.',
            $not_installed_text = 'SFC is not installed. ',
            $not_found_text = 'SFC is not installed and could not be found in the Plugin Directory. Please install this plugin manually.';

    /**
     *
     * @var string holds the plugin file URL
     */
    private $plugin_file;

    /**
     *
     * @param type $plugin_slug
     * @param type $plugin_uri
     */
    function __construct($plugin_slug, $plugin_uri) {
        $this->slug = $plugin_slug;
        $this->uri = $plugin_uri;
        if (empty($this->plugins))
            $this->plugins = get_plugins();
        if (empty($this->uris))
            $this->uris = wp_list_pluck($this->plugins, 'PluginURI');
        $this->plugin_file = $this->get_plugin_file();
    }

    /**
     *
     * @param type $slug
     * @param type $uri
     * @return \Basejump_Plugins_Dependency
     */
    static function factory($slug, $uri) {
        $factory = new Basejump_Plugins_Dependency($slug, $uri);
        return $factory;
    }

    // return true if installed, false if not
    function check() {
        return in_array($this->uri, $this->uris);
    }

    // return true if installed and activated, false if not
    function check_active() {
        if ($this->plugin_file)
            return is_plugin_active($this->plugin_file);
        return false;
    }

    // gives a link to activate the plugin
    function activate_link() {
        if ($this->plugin_file)
            return wp_nonce_url(self_admin_url('plugins.php?action=activate&plugin=' . $plugin_file), 'activate-plugin_' . $plugin_file);
        return false;
    }

    // return a nonced installation link for the plugin. checks wordpress.org to make sure it's there first.
    function install_link() {
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

        $info = plugins_api('plugin_information', array('slug' => $this->slug));

        if (is_wp_error($info))
            return false; // plugin not available from wordpress.org

        return wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $this->slug), 'install-plugin_' . $this->slug);
    }

    // return array key of plugin if installed, false if not, private because this isn't needed for themes, generally
    private function get_plugin_file() {
        return array_search($this->uri, $this->uris);
    }

    public static function plugin_required($plugin_slug, $plugin_uri) {
        $plugin_test = new Basejump_Plugins_Dependency($plugin_slug, $plugin_uri);
        if ($plugin_test->check_active()) :
            echo $plugin_test->active_text;
        elseif ($plugin_test->check()) :
            echo ' <a href="' . $plugin_test->activate_link() . '">' . $plugin_test->not_active_text . '</a>';
        elseif ($install_link = $plugin_test->install_link()) :
            echo '<a href="' . $install_link . '">' . $plugin_test->not_installed_text . '</a>';
        else :
            echo $plugin_test->not_found_text;
        endif;
    }

}

