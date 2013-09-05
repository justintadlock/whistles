<?php

add_action( 'init', 'whistles_register_shortcodes' );

function whistles_register_shortcodes() {
	add_shortcode( 'whistles', 'whistles_tabs_shortcode' );
}

function whistles_tabs_shortcode( $attr ) {
	$tabs = new Whistles_And_Bells( $attr );
	return $tabs->get_whistles();
}

?>