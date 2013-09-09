<?php
/**
 * Whistles_And_Accordions class.  Extends the Whistles_And_Bells class to format the whistle posts into 
 * a group of accordions.
 *
 * @package    Whistles
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/whistles
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
class Whistles_And_Accordions extends Whistles_And_Bells {

	/**
	 * Custom markup for the ouput of accordions.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array   $whistles
	 * @return string
	 */
	public function set_markup( $whistles ) {

		/* Load custom JavaScript for accordions unless the current theme is handling it. */
		if ( !current_theme_supports( 'whistles', 'scripts' ) )
			wp_enqueue_script( 'whistles' );

		/* Set up an empty string to return. */
		$output = '';

		/* If we have whistles, let's roll! */
		if ( !empty( $whistles ) ) {

			/* Open the accordion wrapper. */
			$output .= '<div class="whistles whistles-accordion">';

			/* Loop through each of the whistles and format the output. */
			foreach ( $whistles as $whistle ) {

				$output .= '<h3 class="whistle-title">' . $whistle['title'] . '</h3>';

				$output .= '<div class="whistle-content">' . $whistle['content'] . '</div>';
			}

			/* Close the accordion wrapper. */
			$output .= '</div>';
		}

		/* Return the formatted output. */
		return $output;
	}
}

?>