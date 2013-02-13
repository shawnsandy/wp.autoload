<?php

function dpb() {
	echo '<pre>';
	debug_print_backtrace();
	echo '</pre>';
}

// Example: add_filter( 'posts_request', '__debug_filter' );
function __debug_filter( $val ) {
	debug( func_get_args() );
	return $val;
}

// See the list of callbacks attached to a certain filter
function debug_filters( $tag = false ) {
	global $wp_filter;

	if ( $tag ) {
		$hook[ $tag ] = $wp_filter[ $tag ];

		if ( !is_array( $hook[ $tag ] ) ) {
			trigger_error("Nothing found for '$tag' hook", E_USER_NOTICE);
			return;
		}
	}
	else {
		$hook = $wp_filter;
		ksort( $hook );
	}

	echo '<pre>';
	foreach ( $hook as $tag => $priority ) {
		echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
		ksort( $priority );
		foreach ( $priority as $priority => $function ) {
			echo $priority;
			foreach( $function as $name => $properties )
				echo "\t$name<br>\n";
		}
	}
	echo '</pre>';
}

// See the arguments that are passed to a certain filter
function log_filter( $tag ) {
	add_filter( $tag, '_log_filter_helper', 10, 10 );
}

function _log_filter_helper( $out ) {
	$args = func_get_args();
	debug( $args );

	return $out;
}

class scbDebug {
	private $args;

	function __construct($args) {
		$this->args = $args;

		register_shutdown_function(array($this, '_delayed'));
	}

	function _delayed() {
		if ( !current_user_can('administrator') )
			return;

		$this->raw($this->args);
	}

	static function raw($args) {
		echo defined('DOING_AJAX') ? "\n" : "<pre>";

		foreach ( $args as $arg )
			if ( is_array($arg) || is_object($arg) )
				print_r($arg);
			else
				var_dump($arg);

		echo defined('DOING_AJAX') ? "\n" : "</pre>";
	}

	static function info() {
		self::raw(scbLoad4::get_info());
	}
}


// Integrate with FirePHP
function fb_debug() {
	$args = func_get_args();

	if ( class_exists('FirePHP') ) {
		$firephp = FirePHP::getInstance(true);
		$firephp->group('debug');
		foreach ( $args as $arg )
			$firephp->log($arg);
		$firephp->groupEnd();

		return;
	}

	new scbDebug($args);
}

function debug() {
	$args = func_get_args();

	scbDebug::raw($args);
}

// Debug, only if current user is an administrator
function debug_a() {
	if ( !current_user_can('administrator') )
		return;

	$args = func_get_args();

	scbDebug::raw($args);
}

// Debug last executed SQL query
function debug_lq() {
	global $wpdb;

	debug($wpdb->last_query);
}

// Debug WP_Query is_* flags
function debug_qf( $wp_query = null ) {
	if ( !$wp_query )
		$wp_query = $GLOBALS['wp_query'];

	$flags = array();
	foreach ( get_object_vars( $wp_query ) as $key => $val ) {
		if ( 0 === strpos( $key, 'is_' ) && $val )
			$flags[] = substr( $key, 3 );
	}

	debug( implode( ' ', $flags ) );
}

// Debug cron entries
function debug_cron() {
	add_action('admin_footer', '_debug_cron');
}

function _debug_cron() {
	debug(get_option('cron'));
}

// Debug timestamps
function debug_ts() {
	$args = func_get_args();

	foreach ( $args as $arg )
		debug( date( 'Y-m-d H:i', $arg ) );
}

