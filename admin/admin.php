<?php
/**
 * Admin functions for the plugin.
 *
 * @package    TabsAndJazz
 * @subpackage Admin
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/tabs-and-jazz
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Set up the admin functionality. */
add_action( 'admin_menu', 'taj_admin_menu' );

/* Fixes the parent file. */
add_filter( 'parent_file', 'taj_parent_file' );

/**
 * Creates admin sub-menu items under the "Appearance" screen in the admin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function taj_admin_menu() {

	/* Get the tab post type object. */
	$post_type = get_post_type_object( 'tab' );

	/* Add the tab post type admin sub-menu. */
	add_theme_page( 
		$post_type->labels->name,
		$post_type->labels->menu_name,
		$post_type->cap->edit_posts,
		'edit.php?post_type=tab'
	);

	/* Get the tab group taxonomy object. */
	$taxonomy = get_taxonomy( 'tab_group' );

	/* Add the tab group sub-menu page. */
	add_theme_page(
		$taxonomy->labels->name,
		$taxonomy->labels->menu_name,
		$taxonomy->cap->manage_terms,
		'edit-tags.php?taxonomy=tab_group&post_type=tab'
	);
}

/**
 * Corrects the parent menu item in the admin menu since we're displaying our admin screens in a custom area.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $parent_file
 * @global object  $current_screen
 * @return string
 */
function taj_parent_file( $parent_file = '' ) {
	global $current_screen;

	if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'tab' === $current_screen->post_type )
		$parent_file = 'themes.php';

	elseif ( 'tab_group' === $current_screen->taxonomy )
		$parent_file = 'themes.php';

	return $parent_file;
}

?>