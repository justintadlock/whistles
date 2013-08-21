<?php
/**
 * File for registering custom post types.
 *
 * @package    TabsAndJazz
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/tabs-and-jazz
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom post types on the 'init' hook. */
add_action( 'init', 'taj_register_post_types' );

/**
 * Registers post types needed by the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function taj_register_post_types() {

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
		'query_var'           => 'tab',
		'capability_type'     => 'tab',
		'map_meta_cap'        => true,

		/* Only 3 caps are needed: 'manage_tabs', 'create_tabs', and 'edit_tabs'. */
		'capabilities' => array(

			// meta caps (don't assign these to roles)
			'edit_post'              => 'edit_tab',
			'read_post'              => 'read_tab',
			'delete_post'            => 'delete_tab',

			// primitive/meta caps
			'create_posts'           => 'create_tabs',

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => 'edit_tabs',
			'edit_others_posts'      => 'manage_tabs',
			'publish_posts'          => 'manage_tabs',
			'read_private_posts'     => 'read',

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => 'manage_tabs',
			'delete_private_posts'   => 'manage_tabs',
			'delete_published_posts' => 'manage_tabs',
			'delete_others_posts'    => 'manage_tabs',
			'edit_private_posts'     => 'edit_tabs',
			'edit_published_posts'   => 'edit_tabs'
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
			'name'               => __( 'Tabs',                   'tabs-and-jazz' ),
			'singular_name'      => __( 'Tab',                    'tabs-and-jazz' ),
			'menu_name'          => __( 'Tabs',                   'tabs-and-jazz' ),
			'name_admin_bar'     => __( 'Tabs',                   'tabs-and-jazz' ),
			'add_new'            => __( 'Add New',                'tabs-and-jazz' ),
			'add_new_item'       => __( 'Add New Tab',            'tabs-and-jazz' ),
			'edit_item'          => __( 'Edit Tab',               'tabs-and-jazz' ),
			'new_item'           => __( 'New Tab',                'tabs-and-jazz' ),
			'view_item'          => __( 'View Tab',               'tabs-and-jazz' ),
			'search_items'       => __( 'Search Tabs',            'tabs-and-jazz' ),
			'not_found'          => __( 'No tabs found',          'tabs-and-jazz' ),
			'not_found_in_trash' => __( 'No tabs found in trash', 'tabs-and-jazz' ),
			'all_items'          => __( 'Tabs',                   'tabs-and-jazz' ),
		)
	);

	/* Register the portfolio item post type. */
	register_post_type( 'tab', $args );
}

?>