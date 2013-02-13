<?php

define( 'SCB_LOAD_MU', true );

foreach ( array(
	'scbUtil', 'scbOptions', 'scbForms', 'scbTable',
	'scbWidget', 'scbAdminPage', 'scbBoxesPage',
	'scbCron', 'scbHooks',
) as $className ) {
	include dirname( __FILE__ ) . '/scb/' . substr( $className, 3 ) . '.php';
}

function scb_init( $callback ) {
	call_user_func( $callback );
}

