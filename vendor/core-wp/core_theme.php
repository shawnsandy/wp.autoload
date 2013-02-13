<?php

/**
 * CORE.WP Theme Config
 * @package Wordpress
 * @subpackage core-wp
 * @uses include this file into your active theme path, please place in your child theme if / when in use not in both...
 *
 */



define('CWP_PATH', get_stylesheet() . '/core-wp');
define('CWP_URL', get_template_directory_uri() . '/core-wp' );

define('CM_PATH',  CWP_PATH . '/modules');
define('CM_URL', CWP_URL .'/modules');

require_once CWP_PATH .'/core_loader.php';

?>
