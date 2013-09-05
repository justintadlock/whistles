<?php

add_action( 'widgets_init', 'whistles_register_widgets' );;

function whistles_register_widgets() {

	require_once( WHISTLES_DIR . 'includes/class-tabs-widget.php' );
	register_widget( 'WHISTLES_WIDGET' );
}

?>