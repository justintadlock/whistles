<?php

class Tabs_Bells_Whistles {

	public $args = array();

	public $tabs = array();

	public $html = '';

	public function __construct( $args = array() ) {

		$defaults = array(
			'group'   => '', // 'tab_group' term slug or term ID.
			'limit'   => -1, // Display specific number of tabs from group. Defaults to show all.
			'type'    => 'tab',
			'active'  => 1,
			'order'   => 'DESC',
			'orderby' => 'post_date',
		);

		$this->args = wp_parse_args( $args, $defaults );

		$this->set_tabs();
		$this->format_tabs();
	}

	public function get_tabs() {
		return $this->html;
	}

	public function set_tabs() {

		if ( empty( $this->args['group'] ) )
			return '';

		$loop = new WP_Query(
			array(
				'post_type'      => 'tab',
				'posts_per_page' => $this->args['limit'],
				'order'          => $this->args['order'],
				'orderby'        => $this->args['orderby'],
				'tax_query'      => array(
					array(
						'taxonomy' => 'tab_group',
						'field'    => is_int( $this->args['group'] ) ? 'id' : 'slug',
						'terms'    => array( $this->args['group'] )
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

		$this->tabs = $tabs;
	}

	public function format_tabs() {

		if ( 'tabs' == $this->args['type'] )
			$this->format_default_tabs();

		elseif ( 'toggle' == $this->args['type'] )
			$this->format_toggle_tabs();
	}

	public function format_default_tabs() {

		$output = '';

		if ( !empty( $this->tabs ) ) {

			$output .= '<div class="taj-tabs">';

			$output .= '<ul class="taj-tabs-nav">';

			$i = 1;

			foreach ( $this->tabs as $tab ) {

				$id = sanitize_html_class( 'tab-' . $this->args['group'] . '-' . $tab['id'] );

				$output .= '<li class="taj-title"><a href="#' . $id . '">' . $tab['title'] . '</a></li>';
			}

			$output .= '</ul>';

			$output .= '<div class="taj-tabs-wrap">';

			foreach ( $this->tabs as $tab ) {

				$id = sanitize_html_class( 'tab-' . $this->args['group'] . '-' . $tab['id'] );

				$output .= '<div id="' . $id . '" class="taj-content">' . $tab['content'] . '</div>';
			}

			$output .= '</div>';
		}

		$this->html = $output;
	}

	public function format_toggle_tabs() {

		$output = '';

		if ( !empty( $this->tabs ) ) {

			$output .= '<div class="taj-toggle">';

			foreach ( $this->tabs as $tab ) {

				$output .= '<h3 class="taj-title">' . $tab['title'] . '</h3>';

				$output .= '<div class="taj-content">' . $tab['content'] . '</div>';
			}

			$output .= '</div>';
		}

		$this->html = $output;
	}
}

?>