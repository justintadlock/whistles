<?php

add_action( 'init', 'taj_register_shortcodes' );

function taj_register_shortcodes() {
	add_shortcode( 'tabs', 'taj_tabs_shortcode' );
}

function taj_tabs_shortcode( $attr ) {
	return taj_get_tabs( $attr );
}

?>