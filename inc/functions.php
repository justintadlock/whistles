<?php
/**
 * Functions, filters, and actions for the plugin.
 *
 * @package    Whistles
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/whistles
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register shortcodes. */
add_action( 'init', 'whistles_register_shortcodes' );

/* Register widgets. */
add_action( 'widgets_init', 'whistles_register_widgets' );

/**
 * Function for returning the allowed whistle types for display.
 *
 * @since  0.1.0
 * @access public
 * @return array
 */
function whistles_get_allowed_types() {

	$allowed_types = array(
		'tabs'      => __( 'Tabs',      'whistles' ),
		'toggle'    => __( 'Toggle',    'whistles' ),
		'accordion' => __( 'Accordion', 'whistles' )
	);

	return apply_filters( 'whistles_allowed_types', $allowed_types );
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

	/* Allow types other than 'tabs' or 'toggle'. */
	$allowed = array_keys( whistles_get_allowed_types() );

	/* Clean up the type and allow typos of 'tabs' and 'toggle'. */
	$args['type'] = sanitize_key( strtolower( $args['type'] ) );

	if ( 'tab' === $args['type'] )
		$args['type'] = 'tabs';

	elseif ( 'toggles' === $args['type'] )
		$args['type'] = 'toggle';

	/* ================================== */

	/* Only allow a 'type' from the $allowed_types array. */
	$type = $args['type'] = ( isset( $args['type'] ) && in_array( $args['type'], $allowed ) ) ? $args['type'] : 'tabs';

	/**
	 * Developers can overwrite the whistles object at this point.  This is basically to bypass the 
	 * plugin's classes and use your own.  You must return an object, not a class name.  This object 
	 * must also have a method named "get_markup()" for returning the HTML markup.  It's best to simply 
	 * extend Whistles_And_Bells and follow the structure outlined in that class.
	 */
	$whistles_object = apply_filters( 'whistles_object', null, $args );

	/* If no object was returned, use one of the plugin's defaults. */
	if ( !is_object( $whistles_object ) ) {

		/* Accordion. */
		if ( 'accordion' === $type )
			$whistles_object = new Whistles_And_Accordions( $args );

		/* Toggle. */
		elseif ( 'toggle' === $type )
			$whistles_object = new Whistles_And_Toggles( $args );

		/* Tabs. */
		else
			$whistles_object = new Whistles_And_Tabs( $args );
	}

	/* Return the HTML markup. */
	return $whistles_object->get_markup();
}

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

	require_once( WHISTLES_DIR . 'inc/class-whistles-widget.php' );

	register_widget( 'WHISTLES_WIDGET' );
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