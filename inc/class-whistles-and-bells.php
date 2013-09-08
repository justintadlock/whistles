<?php

class Whistles_And_Bells {

	public $args = array();

	public $whistles = array();

	public $html = '';

	public function __construct( $args = array() ) {

		$defaults = array(
			'group'   => '', // 'whistle_group' term slug or term ID.
			'limit'   => -1, // Display specific number of whistles from group. Defaults to show all.
		//	'type'    => 'tabs',
			'active'  => 1,
			'order'   => 'DESC',
			'orderby' => 'post_date',
		);

		$this->args = wp_parse_args( $args, $defaults );

		$this->set_whistles();

		if ( !empty( $this->whistles ) ) {

			$this->html = $this->format();

			add_action( 'wp_footer', array( $this, 'print_scripts' ) );
		}
	}

	public function get_html() {
		return $this->html;
	}

	public function get_whistles() {
		return $this->whistles;
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

	/** Must be overriden in a sub-class. */
	public function format() {
	}
}

?>