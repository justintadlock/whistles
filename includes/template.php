<?php

function taj_get_tabs( $args = array() ) {

	$defaults = array(
		'group' => '', // 'tab_group' term slug or term ID.
		'limit' => -1, // Display specific number of tabs from group. Defaults to show all.
		'type'  => 'tab',
	);

	$args = wp_parse_args( $args, $defaults );

	if ( empty( $args['group'] ) )
		return '';

	$loop = new WP_Query(
		array(
			'post_type'      => 'tab',
			'posts_per_page' => $args['limit'],
			'tax_query'      => array(
				array(
					'taxonomy' => 'tab_group',
					'field'    => is_int( $args['group'] ) ? 'id' : 'slug',
					'terms'    => array( $args['group'] )
				)
			),
		)
	);

	$tabs = array();

	if ( $loop->have_posts() ) {

		while ( $loop->have_posts() ) {

			$loop->the_post();

			$tabs[] = array(
				'id'      => get_the_ID(),
				'title'   => get_the_title(),
				'content' => apply_filters( 'the_content', get_post_field( 'post_content', get_the_ID() ) )
			);
		}
	}

	wp_reset_postdata();

	if ( !empty( $tabs ) ) {

		echo '<ul class="nav nav-tabs">';

		foreach ( $tabs as $tab ) {

			$id = sanitize_html_class( 'tab-' . $args['group'] . '-' . $tab['id'] );

			echo '<li><a href="#' . $id . '">' . $tab['title'] . '</a></li>';
		}

		echo '</ul>';

		echo '<div class="tab-content">';

		foreach ( $tabs as $tab ) {

			$id = sanitize_html_class( 'tab-' . $args['group'] . '-' . $tab['id'] );

			echo '<div id="' . $id . '" class="tab-pane">';

			echo $tab['content'];

			echo '</div>';
		}

		echo '</div>';
	}
}

?>