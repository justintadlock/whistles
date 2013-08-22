<?php
/**
 * Admin functions for the plugin.
 *
 * @package    TabsAndJazz
 * @subpackage Admin
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/tabs-and-jazz
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Set up the admin functionality. */
add_action( 'admin_menu', 'taj_admin_menu' );

/* Fixes the parent file. */
add_filter( 'parent_file', 'taj_parent_file' );

add_action( 'media_buttons', 'my_media_buttons', 11 );

add_action( 'admin_footer', 'taj_editor_shortcode_popup' );

/**
 * Creates admin sub-menu items under the "Appearance" screen in the admin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function taj_admin_menu() {

	/* Get the tab post type object. */
	$post_type = get_post_type_object( 'tab' );

	/* Add the tab post type admin sub-menu. */
	add_theme_page( 
		$post_type->labels->name,
		$post_type->labels->menu_name,
		$post_type->cap->edit_posts,
		'edit.php?post_type=tab'
	);

	/* Get the tab group taxonomy object. */
	$taxonomy = get_taxonomy( 'tab_group' );

	/* Add the tab group sub-menu page. */
	add_theme_page(
		$taxonomy->labels->name,
		$taxonomy->labels->menu_name,
		$taxonomy->cap->manage_terms,
		'edit-tags.php?taxonomy=tab_group&post_type=tab'
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
function taj_parent_file( $parent_file = '' ) {
	global $current_screen;

	if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'tab' === $current_screen->post_type )
		$parent_file = 'themes.php';

	elseif ( 'tab_group' === $current_screen->taxonomy )
		$parent_file = 'themes.php';

	return $parent_file;
}

/* @todo - only add on the post new/edit page in the admin. */
function my_media_buttons( $editor_id ) {
	echo '<a href="#TB_inline?width=200&height=530&inlineId=taj-shortcode-popup" class="button-secondary thickbox" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Add Tab' ) . '">' . __( 'Add Tab' ) . '</a>';
}

/* @todo - only add on the post new/edit page in the admin. */
function taj_editor_shortcode_popup() {

	$type = array( 
		'tabs'   => esc_attr__( 'Tabs',   'tabs-and-jazz' ), 
		'toggle' => esc_attr__( 'Toggle', 'tabs-and-jazz' ), 
	);

	$terms = get_terms( 'tab_group' );

	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
		$all_terms = $terms;
		$default_term = array_shift( $all_terms );
		$default_term = $default_term->slug;
	} else {
		$default_term = '';
	}

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
	<script>
		function taj_insert_shortcode(){
			var type    = jQuery( 'input:radio[name=taj-type]:checked' ).val();
			var group   = jQuery( 'select#taj-id-group option:selected' ).val();
			var order   = jQuery( 'select#taj-id-order option:selected' ).val();
			var orderby = jQuery( 'select#taj-id-orderby option:selected' ).val();
			var limit   = jQuery( 'input#taj-id-limit' ).val();

			window.send_to_editor( 
				'[tabs type="' + type + '" group="' + group + '" order="' + order + '" orderby="' + orderby + '" limit="' + limit + '"]' 
			);
		}
	</script>

	<div id="taj-shortcode-popup" style="display:none;">

		<div class="wrap">
			<p>
				<?php _e( 'Type', 'jazz-and-tabs' ); ?>
				<?php foreach ( $type as $option_value => $option_label ) { ?>
					<br />
					<input type="radio" name="taj-type" id="<?php echo esc_attr( 'taj-id-type-' . $option_value ); ?>" value="<?php echo esc_attr( $option_value ); ?>" <?php checked( 'tabs', $option_value ); ?> /> 
					<label for="<?php echo esc_attr( 'taj-id-type-' . $option_value ); ?>"><?php echo esc_html( $option_label ); ?></label>
				<?php } ?>
			</p>

			<p>
				<label for="<?php echo esc_attr( 'taj-id-group' ); ?>"><?php _e( 'Group', 'tabs-and-jazz' ); ?></label> 
				<br />
				<select class="widefat" id="<?php echo esc_attr( 'taj-id-group' ); ?>" name="<?php echo esc_attr( 'taj-name-group' ); ?>">
					<?php foreach ( $terms as $term ) { ?>
						<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $default_term, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( 'taj-id-limit' ); ?>"><?php _e( 'Number of tabs to display', 'tabs-and-jazz' ); ?></label> 
				<input type="text" maxlength="3" size="3" class="code" id="<?php echo esc_attr( 'taj-id-limit' ); ?>" name="<?php echo esc_attr( 'taj-name-limit' ); ?>" value="-1" />
			</p>
			<p>
				<label for="<?php echo esc_attr( 'taj-id-order' ); ?>"><?php _e( 'Order', 'tabs-and-jazz' ); ?></label> 
				<br />
				<select class="widefat" id="<?php echo esc_attr( 'taj-id-order' ); ?>" name="<?php echo esc_attr( 'taj-name-order' ); ?>">
					<?php foreach ( $order as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( 'DESC', $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( 'taj-id-orderby' ); ?>"><?php _e( 'Order By', 'tabs-and-jazz' ); ?></label>
				<br />
				<select class="widefat" id="<?php echo esc_attr( 'taj-id-orderby' ); ?>" name="<?php echo esc_attr( 'taj-name-orderby' ); ?>">
					<?php foreach ( $orderby as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( 'date', $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p class="submitbox">
				<input type="submit" value="<?php esc_attr_e( 'Insert Tabs', 'tabs-and-jazz' ); ?>" class="button-primary" onclick="taj_insert_shortcode();" />
				<a class="button-secondary" href="#" onclick="tb_remove(); return false;"><?php _e( 'Cancel', 'tabs-and-jazz' ); ?></a>
			</p>
		</div>
	</div>
<?php
}

?>