<?php

function whistles_get_whistles( $args = array() ) {

	$allowed = apply_filters( 'whistles_allowed_types', array( 'tabs', 'toggle' ) );

	$type = $args['type'] = ( isset( $args['type'] ) && in_array( $args['type'], $allowed ) ) ? $args['type'] : 'tabs';

	$whistles_object = apply_filters( 'whistles_object', null, $args );

	unset( $args['type'] );

	if ( !is_object( $whistles_object ) )
		$whistles_object = $type === 'toggle' ? new Whistles_And_Toggles( $args ) : new Whistles_And_Tabs( $args );

	return $whistles_object->get_html();
}

?>