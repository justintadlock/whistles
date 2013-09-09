<?php
/**
 * Whistles_And_Tabs class.  Extends the Whistles_And_Bells class to format the whistle posts into 
 * a group of tabs.
 *
 * @since  0.1.0
 * @access public
 */
class Whistles_And_Tabs extends Whistles_And_Bells {

	/**
	 * Custom markup for the ouput of tabs.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array   $whistles
	 * @return string
	 */
	public function set_markup( $whistles ) {

		/* Load custom JavaScript for tabs unless the current theme is handling it. */
		if ( !current_theme_supports( 'whistles', 'scripts' ) )
			wp_enqueue_script( 'whistles', WHISTLES_URI . 'js/whistles.js', array( 'jquery' ) );

		/* Set up an empty string to return. */
		$output = '';

		/* If we have whistles, let's roll! */
		if ( !empty( $whistles ) ) {

			/* Generate random ID. */
			$rand = mt_rand();

			/* Open tabs wrapper. */
			$output .= '<div class="whistles whistles-tabs">';

			/* Open tabs nav. */
			$output .= '<ul class="whistles-tabs-nav">';

			/* Loop through each whistle title and format it into a list item. */
			foreach ( $whistles as $whistle ) {

				$id = sanitize_html_class( 'whistle-' . $this->args['group'] . '-' . $whistle['id'] . '-' . $rand );

				$output .= '<li class="whistle-title"><a href="#' . $id . '">' . $whistle['title'] . '</a></li>';
			}

			/* Close tabs nav. */
			$output .= '</ul><!-- whistles-tabs-nav -->';

			/* Open tabs content wrapper. */
			$output .= '<div class="whistles-tabs-wrap">';

			/* Loop through each whistle and format its content into a tab content block. */
			foreach ( $whistles as $whistle ) {

				$id = sanitize_html_class( 'whistle-' . $this->args['group'] . '-' . $whistle['id'] . '-' . $rand );

				$output .= '<div id="' . $id . '" class="whistle-content">' . $whistle['content'] . '</div>';
			}

			/* Close tabs and tabs content wrappers. */
			$output .= '</div><!-- .whistles-tabs-wrap -->';
			$output .= '</div><!-- .whistles-tabs -->';
		}

		/* Return the formatted output. */
		return $output;
	}
}

?>