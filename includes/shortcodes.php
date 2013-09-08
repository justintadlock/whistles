<?php

add_action( 'init', 'whistles_register_shortcodes' );

function whistles_register_shortcodes() {
	add_shortcode( 'whistles', 'whistles_tabs_shortcode' );
}

function whistles_tabs_shortcode( $attr ) {
	return whistles_get_whistles( $attr );
}

?>