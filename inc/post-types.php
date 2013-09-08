<?php
/**
 * File for registering custom post types.
 *
 * @package    Whistles
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/whistles
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom post types on the 'init' hook. */
add_action( 'init', 'whistles_register_post_types' );

/**
 * Registers post types needed by the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function whistles_register_post_types() {

	/* Set up the arguments for the portfolio item post type. */
	$args = array(
		'description'         => '',
		'public'              => true,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'exclude_from_search' => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'has_archive'         => false,
		'query_var'           => 'whistle',
		'capability_type'     => 'whistle',
		'map_meta_cap'        => true,

		/* Only 3 caps are needed: 'manage_whistles', 'create_whistles', and 'edit_whistles'. */
		'capabilities' => array(

			// meta caps (don't assign these to roles)
			'edit_post'              => 'edit_whistle',
			'read_post'              => 'read_whistle',
			'delete_post'            => 'delete_whistle',

			// primitive/meta caps
			'create_posts'           => 'create_whistles',

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => 'edit_whistles',
			'edit_others_posts'      => 'manage_whistles',
			'publish_posts'          => 'manage_whistles',
			'read_private_posts'     => 'read',

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => 'manage_whistles',
			'delete_private_posts'   => 'manage_whistles',
			'delete_published_posts' => 'manage_whistles',
			'delete_others_posts'    => 'manage_whistles',
			'edit_private_posts'     => 'edit_whistles',
			'edit_published_posts'   => 'edit_whistles'
		),

		/* The rewrite handles the URL structure. */
		'rewrite' => false,

		/* What features the post type supports. */
		'supports' => array(
			'title',
			'editor',
		),

		/* Labels used when displaying the posts. */
		'labels' => array(
			'name'               => __( 'Whistles',                   'whistles' ),
			'singular_name'      => __( 'Whistle',                    'whistles' ),
			'menu_name'          => __( 'Whistles',                   'whistles' ),
			'name_admin_bar'     => __( 'Whistle',                    'whistles' ),
			'add_new'            => __( 'Add New',                    'whistles' ),
			'add_new_item'       => __( 'Add New Whistle',            'whistles' ),
			'edit_item'          => __( 'Edit Whistle',               'whistles' ),
			'new_item'           => __( 'New Whistle',                'whistles' ),
			'view_item'          => __( 'View Whistle',               'whistles' ),
			'search_items'       => __( 'Search Whistles',            'whistles' ),
			'not_found'          => __( 'No whistles found',          'whistles' ),
			'not_found_in_trash' => __( 'No whistles found in trash', 'whistles' ),
			'all_items'          => __( 'Whistles',                   'whistles' ),
		)
	);

	/* Register the portfolio item post type. */
	register_post_type( 'whistle', $args );
}

?>