<?php

class Whistles_And_Tabs extends Whistles_And_Bells {

	public function format() {

		if ( !current_theme_supports( 'whistles', 'scripts' ) )
			wp_enqueue_script( 'whistles', WHISTLES_URI . 'js/whistles.js', array( 'jquery' ) );

		$output = '';

		if ( !empty( $this->whistles ) ) {

			$output .= '<div class="whistles whistles-tabs">';

			$output .= '<ul class="whistles-tabs-nav">';

			$i = 1;

			foreach ( $this->whistles as $whistle ) {

				$id = sanitize_html_class( 'whistle-' . $this->args['group'] . '-' . $whistle['id'] );

				$output .= '<li class="whistle-title"><a href="#' . $id . '">' . $whistle['title'] . '</a></li>';
			}

			$output .= '</ul>';

			$output .= '<div class="whistles-tabs-wrap">';

			foreach ( $this->whistles as $whistle ) {

				$id = sanitize_html_class( 'whistle-' . $this->args['group'] . '-' . $whistle['id'] );

				$output .= '<div id="' . $id . '" class="whistle-content">' . $whistle['content'] . '</div>';
			}

			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
}

?>