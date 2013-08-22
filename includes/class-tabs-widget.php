<?php

/**
 * Tabs widget class
 *
 * @since 0.1.0
 */
class TAJ_Widget_Tabs extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.2.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname'   => 'taj',
			'description' => esc_html__( 'Bells and whistles.', 'tabs-and-jazz' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width'  => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'taj',                         // $this->id_base
			__( 'Tabs', 'tabs-and-jazz' ), // $this->name
			$widget_options,               // $this->widget_options
			$control_options               // $this->control_options
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* Set the $args for wp_get_archives() to the $instance array. */
		$args = $instance;

		/* Overwrite the $echo argument and set it to false. */
		$args['echo'] = false;

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* Arguments for the tab set. */
		$args = array(
			'group'   => $instance['group'],
			'limit'   => $instance['limit'],
			'type'    => $instance['type'],
			'order'   => $instance['order'],
			'orderby' => $instance['orderby']
		);

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;


		$tabs = new Tabs_Bells_Whistles( $args );
		echo $tabs->get_tabs();

		/* Close the theme's widget wrapper. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $new_instance;

		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['group']   = strip_tags( $new_instance['group'] );
		$instance['type']    = strip_tags( $new_instance['type'] );
		$instance['order']   = strip_tags( $new_instance['order'] );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );

		$instance['limit'] = ( 0 >= $new_instance['limit'] ) ? -1 : absint( $new_instance['limit'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		$terms = get_terms( 'tab_group' );

		if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			$all_terms = $terms;
			$default_term = array_shift( $all_terms );
			$default_term = $default_term->slug;
		} else {
			$default_term = '';
		}

		/* Set up the default form values. */
		$defaults = array(
			'title'   => '',
			'group'   => $default_term,
			'limit'   => -1,
			'type'    => 'tab',
			'order'   => 'DESC',
			'orderby' => 'date',
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/* Create an array of archive types. */
		$type = array( 
			'tabs'   => esc_attr__( 'Tabs',   'tabs-and-jazz' ), 
			'toggle' => esc_attr__( 'Toggle', 'tabs-and-jazz' ), 
		);

		/* Create an array of order options. */
		$order = array(
			'ASC'  => esc_attr__( 'Ascending', 'tabs-and-jazz' ),
			'DESC' => esc_attr__( 'Descending', 'tabs-and-jazz' )
		);

		/* Create an array of orderby options. */
		$orderby = array( 
			'author' => esc_attr__( 'Author', 'tabs-and-jazz' ),
			'date'   => esc_attr__( 'Date', 'tabs-and-jazz' ),
			'ID'     => esc_attr__( 'ID', 'tabs-and-jazz' ),  
			'rand'   => esc_attr__( 'Random', 'tabs-and-jazz' ),
			'name'   => esc_attr__( 'Slug', 'tabs-and-jazz' ),
			'title'  => esc_attr__( 'Title', 'tabs-and-jazz' ),
		);
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tabs-and-jazz' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><code>type</code></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
				<?php foreach ( $type as $option_value => $option_label ) { ?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['type'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'group' ); ?>"><code>group</code></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'group' ); ?>" name="<?php echo $this->get_field_name( 'group' ); ?>">
				<?php foreach ( $terms as $term ) { ?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $instance['group'], $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><code>limit</code></label>
			<input type="text" class="code" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><code>order</code></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
				<?php foreach ( $order as $option_value => $option_label ) { ?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['order'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><code>orderby</code></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
				<?php foreach ( $orderby as $option_value => $option_label ) { ?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['orderby'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
				<?php } ?>
			</select>
		</p>
	<?php
	}
}

?>