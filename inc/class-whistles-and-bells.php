<?php
/**
 * Base class for creating displaying sets of whistles (post type) on the front end.  This class isn't meant 
 * to be used directly.  You should extend it was a sub-class.  Your sub-class must overwrite the format() 
 * method.
 */

class Whistles_And_Bells {

	/**
	 * Arguments passed in for getting whistles.	
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    array
	 */
	public $args = array();

	/**
	 * Whistle posts found from the query and formatted into an array.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    array
	 */
	public $whistles = array();

	/**
	 * Formatted output of the set of whistles.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $markup = '';

	/**
	 * Constructor method.  Sets up everything.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $args = array() ) {

		/* Use same default filters as 'the_content' with a little more flexibility. */
		add_filter( 'whistle_content', 'wptexturize',       5 );
		add_filter( 'whistle_content', 'convert_smilies',   10 );
		add_filter( 'whistle_content', 'convert_chars',     15 );
		add_filter( 'whistle_content', 'wpautop',           20 );
		add_filter( 'whistle_content', 'shortcode_unautop', 25 );

		/* Set up the default arguments. */
		$defaults = array(
			'group'   => '',         // 'whistle_group' term slug or term ID.
			'limit'   => -1,         // Display specific number of whistles from group.
			'order'   => 'DESC',
			'orderby' => 'post_date',
		);

		$this->args = wp_parse_args( $args, $defaults );

		/* Set up the whistles. */
		$this->set_whistles();

		/* If there are any whistles, set the HTML them. */
		if ( !empty( $this->whistles ) )
			$this->markup = $this->set_markup( $this->whistles );
	}

	/**
	 * Method for grabbing the array of whistles queried.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return array
	 */
	public function get_whistles() {
		return $this->whistles;
	}

	/**
	 * Runs a posts query to grab the whistles by the given group (required).  If whistles are found, sets 
	 * them up in an array of "array( 'id' => $post_id, 'title' => $post_title, 'content' => $post_content )".
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function set_whistles() {

		/* If no group was given, don't set any whistles. */
		if ( empty( $this->args['group'] ) )
			return;

		/* Query the whistles by whistle group. */
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

		while ( $loop->have_posts() ) {

			$loop->the_post();

			$this->whistles[] = array(
				'id'      => get_the_ID(),
				'title'   => get_the_title(),
				'content' => apply_filters( 'whistle_content', get_post_field( 'post_content', get_the_ID() ) )
			);
		}

		/* Reset the original post data. */
		wp_reset_postdata();
	}

	/**
	 * Return the HTML markup for display.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return string
	 */
	public function get_markup() {
		return $this->markup;
	}

	/**
	 * Sets the HTML markup for display.  Expects the $whistles property to be passed in.
	 *
	 * Important!  This method must be overwritten in a sub-class.  Your sub-class should return an 
	 * HTML-formatted string of the $whistles array.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $whistles
	 * @return string
	 */
	public function set_markup( $whistles ) {
		wp_die( sprintf( __( 'The %s method must be overwritten in a sub-class.', 'whistles' ), '<code>' . __METHOD__ . '</code>' ) );
	}
}

?>