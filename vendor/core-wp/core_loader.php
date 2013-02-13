<?php

/**
 * Loads core.wp classes
 * @package Wordpress
 * @subpackage core.wp
 */
spl_autoload_register('_core_autoLoader');

function _core_autoLoader($class) {

    if (file_exists(STYLESHEETPATH . '/core-wp/modules/' . $class . '.php'))
        require_once STYLESHEETPATH . '/core-wp/modules/' . $class . '.php';


    if (file_exists(TEMPLATEPATH . '/core-wp/modules/' . $class . '.php'))
        require_once TEMPLATEPATH . '/core-wp/modules/' . $class . '.php';


    if (file_exists(WP_PLUGIN_DIR . '/core-wp/modules/' . $class . '.php'))
        require_once WP_PLUGIN_DIR . '/core-wp/modules/' . $class . '.php';

    if (file_exists(WP_PLUGIN_DIR . '/core-wp/includes/' . $class . '.php'))
        require_once WP_PLUGIN_DIR . '/core-wp/includes/' . $class . '.php';
    if (file_exists(STYLESHEETPATH . '/core-wp/modules/core_' . $class . '.php'))
        require_once STYLESHEETPATH . '/core-wp/modules/core_' . $class . '.php';


    if (file_exists(TEMPLATEPATH . '/core-wp/modules/core_' . $class . '.php'))
        require_once TEMPLATEPATH . '/core-wp/modules/core_' . $class . '.php';


    if (file_exists(WP_PLUGIN_DIR . '/core-wp/modules/core_' . $class . '.php'))
        require_once WP_PLUGIN_DIR . '/core-wp/modules/core_' . $class . '.php';

    if (file_exists(WP_PLUGIN_DIR . '/core-wp/includes/core_' . $class . '.php'))
        require_once WP_PLUGIN_DIR . '/core-wp/includes/core_' . $class . '.php';
}

