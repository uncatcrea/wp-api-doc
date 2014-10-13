<?php

class wp_api_doc_metabox {

	public static function hooks() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'save_post', array( __CLASS__, 'save_post' ) );
	}

	public static function admin_menu() {

		add_meta_box( 
				'wpad_additionnal_data_metabox', 
				__( 'API Doc' ), 
				array( __CLASS__, 'meta_box_content' ), 
				'page',
				'normal', 'high'
		);
	}

	public static function meta_box_content( $post, $current_metabox ) {
		$current_usage = self::get_page_usage( $post );
		$current_arguments = self::get_page_arguments( $post );
		$current_return = self::get_page_return( $post );
		?>
		<table class="wpad_metabox">
			<tr>
				<td><label><?php _e( 'Usage' ) ?></label> : </td>
				<td><input type="text" name="wpad_usage" value="<?php echo $current_usage ?>"/></td>
			</tr>
			<tr>
				<td><label><?php _e( 'Arguments' ) ?></label> :</td>
				<td>
					<?php
						wp_editor(
								$current_arguments, 'wpad_arguments_id', array(
							'textarea_name' => 'wpad_arguments',
							'tinymce' => array(
								'toolbar1' => 'bold, charmap, bullist, undo, redo, link, unlink',
								'toolbar2' => '',
							),
							"media_buttons" => false,
							"textarea_rows" => 5,
							'editor_class' => 'wpad_editor',
							'quicktags' => true,
							'wpautop' => false,
								)
						);
					?>
				</td>
			</tr>
			<tr>
				<td><label><?php _e( 'Return' ) ?></label> :</td>
				<td>
					<?php
					wp_editor(
							$current_return, 'wpad_return', array(
						'textarea_name' => 'wpad_return',
						'tinymce' => array(
							'toolbar1' => 'bold, charmap, bullist, undo, redo, link, unlink',
							'toolbar2' => '',
						),
						"media_buttons" => false,
						"textarea_rows" => 5,
						'editor_class' => 'wpad_editor',
						'quicktags' => true,
						'wpautop' => false,
							)
					);
					?>
				</td>
			</tr>
		</table>

		<?php wp_nonce_field( 'wpad_metabox_save', 'wpad_metabox_save_nonce' ) ?>

		<style>
			table.wpad_metabox{ width:100% }
			table.wpad_metabox td:first-child{ width:100px; text-align: right; padding-right:10px }
			input[name=wpad_usage]{ width:100% }
		</style>
		
		<?php
	}

	public static function save_post( $post_id ) {

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times

		if ( !wp_verify_nonce( $_POST['wpad_metabox_save_nonce'], 'wpad_metabox_save' ) ) {
			return $post_id;
		}

		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;


		// Check permissions and post type
		if ( 'page' != $_POST['post_type'] || !current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		// Handle the case where we are dealing with a revision
		if ( $parent_post_id = wp_is_post_revision( $post_id ) ) {
			$post_id = $parent_post_id;
		}

		// OK, we're authenticated: we need to find and save the data

		if ( isset( $_POST['wpad_usage'] ) ) {
			self::set_post_usage( $post_id, $_POST['wpad_usage'] );
		}

		if ( isset( $_POST['wpad_arguments'] ) ) {
			self::set_post_arguments( $post_id, $_POST['wpad_arguments'] );
		}

		if ( isset( $_POST['wpad_return'] ) ) {
			self::set_post_return( $post_id, $_POST['wpad_return'] );
		}
	}

	public static function get_page_usage( $post_id ) {
		if ( is_object( $post_id ) ) {
			$post_id = $post_id->ID;
		}
		$usage = get_post_meta( $post_id, '_wpad_usage', true );
		$usage = trim( $usage );
		return !empty( $usage ) ? $usage : '';
	}

	protected static function set_post_usage( $post_id, $usage ) {
		$usage = trim( $usage );
		add_post_meta( $post_id, '_wpad_usage', $usage, true ) or update_post_meta( $post_id, '_wpad_usage', $usage );
	}

	protected static function set_post_arguments( $post_id, $arguments ) {
		$arguments = trim( $arguments );
		add_post_meta( $post_id, '_wpad_arguments', $arguments, true ) or update_post_meta( $post_id, '_wpad_arguments', $arguments );
	}

	public static function get_page_arguments( $post_id ) {
		if ( is_object( $post_id ) ) {
			$post_id = $post_id->ID;
		}
		$arguments = get_post_meta( $post_id, '_wpad_arguments', true );
		$arguments = trim( $arguments );
		return !empty( $arguments ) ? $arguments : '';
	}

	protected static function set_post_return( $post_id, $return ) {
		$return = trim( $return );
		add_post_meta( $post_id, '_wpad_return', $return, true ) or update_post_meta( $post_id, '_wpad_return', $return );
	}

	public static function get_page_return( $post_id ) {
		if ( is_object( $post_id ) ) {
			$post_id = $post_id->ID;
		}
		$return = get_post_meta( $post_id, '_wpad_return', true );
		$return = trim( $return );
		return !empty( $return ) ? $return : '';
	}

}

wp_api_doc_metabox::hooks();
