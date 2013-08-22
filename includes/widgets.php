<?php

add_action( 'widgets_init', 'taj_register_widgets' );;

function taj_register_widgets() {

	require_once( TAJ_DIR . 'includes/class-tabs-widget.php' );
	register_widget( 'TAJ_Widget_Tabs' );
}

?>