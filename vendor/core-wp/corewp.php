<?php

/*
Plugin Name: CoreWP
Plugin URI: http://crafetdandpressed.com
Description: A toolkit for rapid Wordpress theme / plugin / app development.
Version: 0.1.1 Beta
Author: Shawn Sandy
Author URI: http://shawnsandy.com
License: GPL2
*/

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : shawnsandy04@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Define plugin directories
 */

define('CWP_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));
define('CWP_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));


require_once CWP_PATH .'/cwp.php';

class corewp {

    public function __construct() {
       // $this->admin_menu();
       add_action('admin_menu', array(&$this,'admin_menu'));
    }



    public function admin_menu() {
       //add_options_page('CoreWP', 'Core WP', 'manage_options', 'core-wp', array(&$this,'menu'));
       $menu = add_options_page('Core.Wp', 'Core.WP', 'manage_options', 'core-wp', array(&$this,'menu'));
    }

    public function menu(){
        echo '<div class="wrap">';
        echo '<h2>Core.WP</h2>';
        echo '</div>';
    }


    /**
     * Runs on plugin activation
     */
    public function activation(){

    }

}

/**
 ****************Custom functions *************************************************
 */



//if(file_exists(CWP_PATH.'/scb-framework/scb-load.php'))
//    include_once CWP_PATH.'/scb-framework/scb-load.php';

/**
 * register plugin's activation hook
 * @since 1.0
 */
register_activation_hook(__FILE__, array('corewp', 'activation'));