<?php

/*
Plugin Name: WP.Autoload
Plugin URI: http://craftedandpressed.com
Description: A simple php autoload manager for wordpress, built with PHP-Autoload-Manager http://bashar.alfallouji.com/PHP-Autoload-Manager/. AL-Manager allows you to easily extend the power of WordPress using Object Oriented PHP; classes and libraries.
Author: Shawn Sandy
Author URI: http://shawnsandy.com
Version: 1.1.2
*/

/*
 * Include al_manager class
 */
include_once dirname(__FILE__) .'/al_manager.php' ;

/*
 * Include al_manager class
 */
include_once dirname(__FILE__) .'/wp-autoload.php' ;

/**
 * instaniate the al_manger class
 */
al_manager::instance()->autoload();
wp_autoload::factory()->load();


//run al_manager on init;

add_action('plugins_loaded', 'alm_init');

function alm_init(){

    $almmanager = al_manager::instance()->autoload();
    $almmanager->add_folders_filter();
    $almmanager->del_folders_filter();
    $almmanager->clean_options();
    wp_autoload::factory()->load();
}

/**
 * done that is it nothing more here
 */