<?php
/**
 * File for registering custom taxonomies.
 *
 * @package    Whistles
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/whistles
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register taxonomies on the 'init' hook. */
add_action( 'init', 'whistles_register_taxonomies' );

/**
 * Register taxonomies for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void.
 */
function whistles_register_taxonomies() {

	/* Set up the arguments for the portfolio taxonomy. */
	$args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => 'whistle_group',

		/* Only 2 caps are needed: 'manage_portfolio' and 'edit_portfolio_items'. */
		'capabilities' => array(
			'manage_terms' => 'manage_whistles',
			'edit_terms'   => 'manage_whistles',
			'delete_terms' => 'manage_whistles',
			'assign_terms' => 'edit_whistles',
		),

		/* The rewrite handles the URL structure. */
		'rewrite' => false,

		/* Labels used when displaying taxonomy and terms. */
		'labels' => array(
			'name'                       => __( 'Whistle Groups',                           'whistles' ),
			'singular_name'              => __( 'Whistle Group',                            'whistles' ),
			'menu_name'                  => __( 'Whistle Groups',                           'whistles' ),
			'name_admin_bar'             => __( 'Whistle Group',                            'whistles' ),
			'search_items'               => __( 'Search Whistle Groups',                    'whistles' ),
			'popular_items'              => __( 'Popular Whistle Groups',                   'whistles' ),
			'all_items'                  => __( 'All Whistle Groups',                       'whistles' ),
			'edit_item'                  => __( 'Edit Whistle Group',                       'whistles' ),
			'view_item'                  => __( 'View Whistle Group',                       'whistles' ),
			'update_item'                => __( 'Update Whistle Group',                     'whistles' ),
			'add_new_item'               => __( 'Add New Whistle Group',                    'whistles' ),
			'new_item_name'              => __( 'New Whistle Group Name',                   'whistles' ),
			'separate_items_with_commas' => __( 'Separate whistle groups with commas',      'whistles' ),
			'add_or_remove_items'        => __( 'Add or remove whistle groups',             'whistles' ),
			'choose_from_most_used'      => __( 'Choose from the most used whistle groups', 'whistles' ),
		)
	);

	/* Register the 'portfolio' taxonomy. */
	register_taxonomy( 'whistle_group', array( 'whistle' ), $args );
}

?>