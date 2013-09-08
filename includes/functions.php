<?php
/**
 * Functions, filters, and actions for the plugin.
 */

/* Register shortcodes. */
add_action( 'init', 'whistles_register_shortcodes' );

/* Register widgets. */
add_action( 'widgets_init', 'whistles_register_widgets' );

/**
 * Registers the [whistles] shortcode.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function whistles_register_shortcodes() {
	add_shortcode( 'whistles', 'whistles_do_shortcode' );
}

/**
 * Regisers the "Whistles" widget.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function whistles_register_widgets() {

	require_once( WHISTLES_DIR . 'includes/class-whistles-widget.php' );

	register_widget( 'WHISTLES_WIDGET' );
}

/**
 * Wrapper function for outputting whistles.  You can call one of the classes directly, but it's best to use 
 * this function if needed within a theme template.
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function whistles_get_whistles( $args = array() ) {

	$allowed = apply_filters( 'whistles_allowed_types', array( 'tabs', 'toggle' ) );

	$type = $args['type'] = ( isset( $args['type'] ) && in_array( $args['type'], $allowed ) ) ? $args['type'] : 'tabs';

	$whistles_object = apply_filters( 'whistles_object', null, $args );

	unset( $args['type'] );

	if ( !is_object( $whistles_object ) )
		$whistles_object = $type === 'toggle' ? new Whistles_And_Toggles( $args ) : new Whistles_And_Tabs( $args );

	return $whistles_object->get_html();
}

/**
 * Shortcode function.  This is just a wrapper for whistles_get_whistles().
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function whistles_do_shortcode( $attr ) {
	return whistles_get_whistles( $attr );
}

?>