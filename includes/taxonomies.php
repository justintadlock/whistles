<?php
/**
 * File for registering custom taxonomies.
 *
 * @package    TabsAndJazz
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/tabs-and-jazz
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register taxonomies on the 'init' hook. */
add_action( 'init', 'taj_register_taxonomies', 9 );

/**
 * Register taxonomies for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void.
 */
function taj_register_taxonomies() {

	/* Set up the arguments for the portfolio taxonomy. */
	$args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => 'tab_group',

		/* Only 2 caps are needed: 'manage_portfolio' and 'edit_portfolio_items'. */
		'capabilities' => array(
			'manage_terms' => 'manage_tabs',
			'edit_terms'   => 'manage_tabs',
			'delete_terms' => 'manage_tabs',
			'assign_terms' => 'edit_tabs',
		),

		/* The rewrite handles the URL structure. */
		'rewrite' => false,

		/* Labels used when displaying taxonomy and terms. */
		'labels' => array(
			'name'                       => __( 'Tab Groups',                           'tabs-and-jazz' ),
			'singular_name'              => __( 'Tab Group',                            'tabs-and-jazz' ),
			'menu_name'                  => __( 'Tab Groups',                           'tabs-and-jazz' ),
			'name_admin_bar'             => __( 'Tab Group',                            'tabs-and-jazz' ),
			'search_items'               => __( 'Search Tab Groups',                    'tabs-and-jazz' ),
			'popular_items'              => __( 'Popular Tab Groups',                   'tabs-and-jazz' ),
			'all_items'                  => __( 'All Tab Groups',                       'tabs-and-jazz' ),
			'edit_item'                  => __( 'Edit Tab Group',                       'tabs-and-jazz' ),
			'view_item'                  => __( 'View Tab Group',                       'tabs-and-jazz' ),
			'update_item'                => __( 'Update Tab Group',                     'tabs-and-jazz' ),
			'add_new_item'               => __( 'Add New Tab Group',                    'tabs-and-jazz' ),
			'new_item_name'              => __( 'New Tab Group Name',                   'tabs-and-jazz' ),
			'separate_items_with_commas' => __( 'Separate tab groups with commas',      'tabs-and-jazz' ),
			'add_or_remove_items'        => __( 'Add or remove tab groups',             'tabs-and-jazz' ),
			'choose_from_most_used'      => __( 'Choose from the most used tab groups', 'tabs-and-jazz' ),
		)
	);

	/* Register the 'portfolio' taxonomy. */
	register_taxonomy( 'tab_group', array( 'tab' ), $args );
}

?>