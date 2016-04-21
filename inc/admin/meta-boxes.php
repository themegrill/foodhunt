<?php
/**
 * This fucntion is responsible for rendering metaboxes in single post area
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */

 add_action( 'add_meta_boxes', 'foodhunt_add_custom_box' );
/**
 * Add Meta Boxes.
 */
function foodhunt_add_custom_box() {
	// Adding layout meta box for Page
	add_meta_box( 'page-layout', esc_html__( 'Select Layout', 'foodhunt' ), 'foodhunt_layout_call', 'page', 'side' );
	// Adding layout meta box for Post
	add_meta_box( 'post-layout', esc_html__( 'Select Layout', 'foodhunt' ), 'foodhunt_layout_call', 'post', 'side' );
	//Adding designation meta box
	add_meta_box( 'team-designation', esc_html__( 'Our Team Designation', 'foodhunt' ), 'foodhunt_designation_call', 'page', 'side'	);
}

/****************************************************************************************/

global $foodhunt_page_layout, $foodhunt_metabox_field_designation;
$foodhunt_page_layout = array(
							'default-layout' 	=> array(
														'id'			=> 'foodhunt_page_layout',
														'value' 		=> 'default_layout',
														'label' 		=> esc_html__( 'Default Layout', 'foodhunt' )
														),
							'right-sidebar' 	=> array(
														'id'			=> 'foodhunt_page_layout',
														'value' 		=> 'right-sidebar',
														'label' 		=> esc_html__( 'Right Sidebar', 'foodhunt' )
														),
							'left-sidebar' 	=> array(
														'id'			=> 'foodhunt_page_layout',
														'value' 		=> 'left-sidebar',
														'label' 		=> esc_html__( 'Left Sidebar', 'foodhunt' )
														),
							'no-sidebar-full-width' => array(
															'id'			=> 'foodhunt_page_layout',
															'value' 		=> 'no-sidebar-full-width',
															'label' 		=> esc_html__( 'No Sidebar Full Width', 'foodhunt' )
															),
							'no-sidebar-content-centered' => array(
															'id'			=> 'foodhunt_page_layout',
															'value' 		=> 'no-sidebar-content-centered',
															'label' 		=> esc_html__( 'No Sidebar Content Centered', 'foodhunt' )
															)
						);

$foodhunt_metabox_field_designation = array(
	array(
		'id'			=> 'foodhunt_designation',
		'label' 		=> esc_html__( 'team designation', 'foodhunt' )
	)
);


/****************************************************************************************/

function foodhunt_layout_call() {
	global $foodhunt_page_layout;
	foodhunt_meta_form( $foodhunt_page_layout );
}

function foodhunt_designation_call() {
	global $foodhunt_metabox_field_designation;
	foodhunt_meta_form( $foodhunt_metabox_field_designation );
}

/**
 * Displays metabox to for select layout option
 */
function foodhunt_meta_form( $foodhunt_metabox_field ) {
	global $post;

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'custom_meta_box_nonce' );

	foreach ( $foodhunt_metabox_field as $field ) {
		$layout_meta = get_post_meta( $post->ID, $field['id'], true );
		switch( $field['id'] ) {

			// Layout
			case 'foodhunt_page_layout':
				if( empty( $layout_meta ) ) { $layout_meta = 'default_layout'; } ?>

				<input class="post-format" type="radio" name="<?php echo esc_attr($field['id']); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( $field['value'], $layout_meta ); ?>/>
				<label class="post-format-icon"><?php echo esc_html( $field['label'] ); ?></label><br/>
			<?php

			break;

			// Team Designation
			case 'foodhunt_designation':
				echo esc_html__( 'Designation field for Team Member', 'foodhunt' ) . '<br>';
				echo '<input type="text" name="'.$field['id'].'" value="'.esc_attr($layout_meta).'"/><br>';

			break;
		}
	}
}

/****************************************************************************************/

add_action('save_post', 'foodhunt_save_custom_meta');
/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function foodhunt_save_custom_meta( $post_id ) {
	global $foodhunt_page_layout, $post, $foodhunt_metabox_field_designation, $post;;

	// Verify the nonce before proceeding.
   if( !isset( $_POST[ 'custom_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'custom_meta_box_nonce' ], basename( __FILE__ ) ) )
      return;

	// Stop WP from clearing custom fields on autosave
   if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
      return;

	if( 'page' == $_POST['post_type'] ) {
      if( !current_user_can( 'edit_page', $post_id ) )
         return $post_id;
   }
   elseif( !current_user_can( 'edit_post', $post_id ) ) {
      return $post_id;
   }

   foreach( $foodhunt_page_layout as $field ) {
		//Execute this saving function
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = sanitize_key( $_POST[$field['id']] );
		if( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	} // end foreach

	if ( 'page' == $_POST['post_type'] ) {
		// loop through fields and save the data
		foreach( $foodhunt_metabox_field_designation as $field ) {
			$old = get_post_meta( $post_id, $field['id'], true );
			$new = sanitize_key( $_POST[$field['id']] );
			if( $new && $new != $old ) {
				update_post_meta( $post_id,$field['id'],$new );
			} elseif( '' == $new && $old ) {
				delete_post_meta( $post_id, $field['id'], $old );
			}
		} // end foreach
	}
}
