<?php

class Whistles_And_Bells {

	public $args = array();

	public $whistles = array();

	public $html = '';

	public function __construct( $args = array() ) {

		$defaults = array(
			'group'   => '', // 'whistle_group' term slug or term ID.
			'limit'   => -1, // Display specific number of whistles from group. Defaults to show all.
			'type'    => 'tabs',
			'active'  => 1,
			'order'   => 'DESC',
			'orderby' => 'post_date',
		);

		$this->args = wp_parse_args( $args, $defaults );

		$this->set_whistles();
		$this->format_whistles();
	}

	public function get_whistles() {
		return $this->html;
	}

	public function set_whistles() {

		if ( empty( $this->args['group'] ) )
			return '';

		$loop = new WP_Query(
			array(
				'post_type'      => 'whistle',
				'posts_per_page' => $this->args['limit'],
				'order'          => $this->args['order'],
				'orderby'        => $this->args['orderby'],
				'tax_query'      => array(
					array(
						'taxonomy' => 'whistle_group',
						'field'    => is_int( $this->args['group'] ) ? 'id' : 'slug',
						'terms'    => array( $this->args['group'] )
					)
				),
			)
		);

		$whistles = array();

		if ( $loop->have_posts() ) {

			while ( $loop->have_posts() ) {

				$loop->the_post();

				$whistles[] = array(
					'id'      => get_the_ID(),
					'title'   => get_the_title(),
					'content' => apply_filters( 'the_content', get_post_field( 'post_content', get_the_ID() ) )
				);
			}
		}

		wp_reset_postdata();

		$this->whistles = $whistles;
	}

	public function format_whistles() {

		if ( 'tabs' == $this->args['type'] )
			$this->format_tabs();

		elseif ( 'toggle' == $this->args['type'] )
			$this->format_toggle();
	}

	public function format_tabs() {

		$output = '';

		if ( !empty( $this->whistles ) ) {

			$output .= '<div class="whistles-tabs">';

			$output .= '<ul class="whistles-tabs-nav">';

			$i = 1;

			foreach ( $this->whistles as $whistle ) {

				$id = sanitize_html_class( 'whistle-' . $this->args['group'] . '-' . $whistle['id'] );

				$output .= '<li class="whistles-title"><a href="#' . $id . '">' . $whistle['title'] . '</a></li>';
			}

			$output .= '</ul>';

			$output .= '<div class="whistles-tabs-wrap">';

			foreach ( $this->whistles as $whistle ) {

				$id = sanitize_html_class( 'whistle-' . $this->args['group'] . '-' . $whistle['id'] );

				$output .= '<div id="' . $id . '" class="whistle-content">' . $whistle['content'] . '</div>';
			}

			$output .= '</div>';
		}

		$this->html = $output;
	}

	public function format_toggle() {

		$output = '';

		if ( !empty( $this->whistles ) ) {

			$output .= '<div class="whistles-toggle">';

			foreach ( $this->whistles as $whistle ) {

				$output .= '<h3 class="whistle-title">' . $whistle['title'] . '</h3>';

				$output .= '<div class="whistle-content">' . $whistle['content'] . '</div>';
			}

			$output .= '</div>';
		}

		$this->html = $output;
	}
}

?>