<?php
/**
 * Admin functions for the plugin.
 *
 * @package    Whistles
 * @subpackage Admin
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/whistles
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Set up the admin functionality. */
add_action( 'admin_menu', 'whistles_admin_menu' );

/* Fixes the parent file. */
add_filter( 'parent_file', 'whistles_parent_file' );

/* Adds a custom media button on the post editor. */
add_action( 'media_buttons', 'whistles_media_buttons', 11 );

/* Loads media button popup content in the footer. */
add_action( 'admin_footer-post-new.php', 'whistles_editor_shortcode_popup' );
add_action( 'admin_footer-post.php',     'whistles_editor_shortcode_popup' );

/**
 * Creates admin sub-menu items under the "Appearance" screen in the admin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function whistles_admin_menu() {

	/* Get the whistle post type object. */
	$post_type = get_post_type_object( 'whistle' );

	/* Add the whistle post type admin sub-menu. */
	add_theme_page( 
		$post_type->labels->name,
		$post_type->labels->menu_name,
		$post_type->cap->edit_posts,
		'edit.php?post_type=whistle'
	);

	/* Get the whistle group taxonomy object. */
	$taxonomy = get_taxonomy( 'whistle_group' );

	/* Add the whistle group sub-menu page. */
	add_theme_page(
		$taxonomy->labels->name,
		$taxonomy->labels->menu_name,
		$taxonomy->cap->manage_terms,
		'edit-tags.php?taxonomy=whistle_group&amp;post_type=whistle'
	);
}

/**
 * Corrects the parent menu item in the admin menu since we're displaying our admin screens in a custom area.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $parent_file
 * @global object  $current_screen
 * @return string
 */
function whistles_parent_file( $parent_file ) {
	global $current_screen, $self;

	/* Fix the parent file when viewing the Whistles or New Whistle screen in the admin. */
	if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'whistle' === $current_screen->post_type ) {
		$parent_file = 'themes.php';
	}

	/* Fix the parent and self file when viewing the Whistle Groups screen in the admin. */
	elseif ( 'whistle_group' === $current_screen->taxonomy ) {
		$parent_file = 'themes.php';
		$self        = 'edit-tags.php?taxonomy=whistle_group&amp;post_type=whistle';
	}

	return $parent_file;
}

/**
 * Displays a link to the Thickbox popup containing the shortcode config popup on the edit post screen.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $editor_id
 * @return void
 */
function whistles_media_buttons( $editor_id ) {
	global $post;

	if ( 'whistle' !== $post->post_type )
		echo '<a href="#TB_inline?width=200&amp;height=530&amp;inlineId=whistles-shortcode-popup" class="button-secondary thickbox" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Add Whistles' ) . '">' . __( 'Add Whistles' ) . '</a>';
}

/**
 * Shortcode config popup when the "Add Whistles" media button is clicked.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function whistles_editor_shortcode_popup() {

	$type = array( 
		'tabs'   => esc_attr__( 'Tabs',   'whistles' ), 
		'toggle' => esc_attr__( 'Toggle', 'whistles' ), 
	);

	$terms = get_terms( 'whistle_group' );

	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
		$all_terms = $terms;
		$default_term = array_shift( $all_terms );
		$default_term = $default_term->slug;
	} else {
		$default_term = '';
	}

	/* Create an array of order options. */
	$order = array(
		'ASC'  => esc_attr__( 'Ascending',  'whistles' ),
		'DESC' => esc_attr__( 'Descending', 'whistles' )
	);

	/* Create an array of orderby options. */
	$orderby = array( 
		'author' => esc_attr__( 'Author', 'whistles' ),
		'date'   => esc_attr__( 'Date',   'whistles' ),
		'ID'     => esc_attr__( 'ID',     'whistles' ),  
		'rand'   => esc_attr__( 'Random', 'whistles' ),
		'name'   => esc_attr__( 'Slug',   'whistles' ),
		'title'  => esc_attr__( 'Title',  'whistles' ),
	);

	?>
	<script>
		jQuery( document ).ready(

			function() {

				jQuery( '#whistles-submit' ).attr( 
					'value', 
					'<?php echo esc_js( __( 'Insert', 'whistles' ) ); ?> ' + jQuery( 'input:radio[name=whistles-type]:checked + label' ).text()
				);

				jQuery( 'input:radio[name=whistles-type]' ).change(
					function() {
						jQuery( '#whistles-submit' ).attr( 
							'value', 
							'<?php echo esc_js( __( 'Insert', 'whistles' ) ); ?> ' + jQuery( this ).next( 'label' ).text() 
						);
					}
				);
			}
		);

		function whistles_insert_shortcode(){
			var type    = jQuery( 'input:radio[name=whistles-type]:checked' ).val();
			var group   = jQuery( 'select#whistles-id-group option:selected' ).val();
			var order   = jQuery( 'select#whistles-id-order option:selected' ).val();
			var orderby = jQuery( 'select#whistles-id-orderby option:selected' ).val();
			var limit   = jQuery( 'input#whistles-id-limit' ).val();

			window.send_to_editor( 
				'[whistles type="' + type + '" group="' + group + '" order="' + order + '" orderby="' + orderby + '" limit="' + limit + '"]' 
			);
		}
	</script>

	<div id="whistles-shortcode-popup" style="display:none;">

		<div class="wrap">

		<?php if ( empty( $terms ) ) { ?>
			<p>
				<?php _e( 'You need at least one whistle group to display whistles.', 'whistles' ); ?> 
				<?php if ( current_user_can( 'manage_whistles' ) ) { ?>
					<a href="<?php echo admin_url( 'edit-tags.php?taxonomy=whistle_group&post_type=whistle' ); ?>"><?php _e( 'Whistle Groups &rarr;', 'whistles' ); ?></a>
				<?php } ?>
			</p>
			<p class="submitbox">
				<a class="button-secondary" href="#" onclick="tb_remove(); return false;"><?php _e( 'Cancel', 'whistles' ); ?></a>
			</p>
		<?php } else { ?>
			<p>
				<?php _e( 'Type', 'whistles' ); ?>
				<?php foreach ( $type as $option_value => $option_label ) { ?>
					<br />
					<input type="radio" name="whistles-type" id="<?php echo esc_attr( 'whistles-id-type-' . $option_value ); ?>" value="<?php echo esc_attr( $option_value ); ?>" <?php checked( 'tabs', $option_value ); ?> /> 
					<label for="<?php echo esc_attr( 'whistles-id-type-' . $option_value ); ?>"><?php echo esc_html( $option_label ); ?></label>
				<?php } ?>
			</p>

			<p>
				<label for="<?php echo esc_attr( 'whistles-id-group' ); ?>"><?php _e( 'Group', 'whistles' ); ?></label> 
				<br />
				<select class="widefat" id="<?php echo esc_attr( 'whistles-id-group' ); ?>" name="<?php echo esc_attr( 'whistles-name-group' ); ?>">
					<?php foreach ( $terms as $term ) { ?>
						<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $default_term, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( 'whistles-id-limit' ); ?>"><?php _e( 'Number of whistles to display', 'whistles' ); ?></label> 
				<input type="text" maxlength="3" size="3" class="code" id="<?php echo esc_attr( 'whistles-id-limit' ); ?>" name="<?php echo esc_attr( 'whistles-name-limit' ); ?>" value="-1" />
			</p>
			<p>
				<label for="<?php echo esc_attr( 'whistles-id-order' ); ?>"><?php _e( 'Order', 'whistles' ); ?></label> 
				<br />
				<select class="widefat" id="<?php echo esc_attr( 'whistles-id-order' ); ?>" name="<?php echo esc_attr( 'whistles-name-order' ); ?>">
					<?php foreach ( $order as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( 'DESC', $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( 'whistles-id-orderby' ); ?>"><?php _e( 'Order By', 'whistles' ); ?></label>
				<br />
				<select class="widefat" id="<?php echo esc_attr( 'whistles-id-orderby' ); ?>" name="<?php echo esc_attr( 'whistles-name-orderby' ); ?>">
					<?php foreach ( $orderby as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( 'date', $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p class="submitbox">
				<input type="submit" id="whistles-submit" value="<?php esc_attr_e( 'Insert Whistles', 'whistles' ); ?>" class="button-primary" onclick="whistles_insert_shortcode();" />
				<a class="button-secondary" href="#" onclick="tb_remove(); return false;"><?php _e( 'Cancel', 'whistles' ); ?></a>
			</p>
		<?php } ?>

		</div>
	</div>
<?php
}

?>