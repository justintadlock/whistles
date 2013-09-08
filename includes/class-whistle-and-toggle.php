<?php

class Whistles_And_Toggles extends Whistles_And_Bells {

	public function format() {
		wp_enqueue_script( 'whistles', WHISTLES_URI . 'js/whistles.js', array( 'jquery' ) );

		$output = '';

		if ( !empty( $this->whistles ) ) {

			$output .= '<div class="whistles whistles-toggle">';

			foreach ( $this->whistles as $whistle ) {

				$output .= '<h3 class="whistle-title">' . $whistle['title'] . '</h3>';

				$output .= '<div class="whistle-content">' . $whistle['content'] . '</div>';
			}

			$output .= '</div>';
		}

		return $output;
	}
}

?>