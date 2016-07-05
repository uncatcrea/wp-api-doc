<?php

class WpApiDocOptions {
	
	const option_id = 'wp_api_doc_options';
	
	public static function hooks() {
		 add_action( 'admin_menu', array( __CLASS__, 'add_options_panel' ) );
	}
	
	public static function add_options_panel() {
		add_options_page(
			'WP API Doc', 
			'WP API Doc', 
			'manage_options', 
			'wp-api-doc-options-panel', 
			array( __CLASS__, 'options_panel' )
		);
	}
	
	public static function options_panel() {
		$result = self::handle_posted_settings();
        $options = self::get_options();
        ?>
        <div>
         
            <h1>Doc's root pages</h1>
             
            <?php if ( !empty( $result['message'] ) ): ?>
                <div class="<?php echo $result['type']; ?>" ><p><?php echo $result['message']; ?></p></div>
            <?php endif ?>
				
			<div>
				<form method="post" action="<?php echo add_query_arg(array()) ?>">

					<label for="root-pages">Root pages (comma separated IDs):</label>
					<input type="text" name="root_pages" id="root-pages" value="<?php echo esc_attr( implode( ',', $options['root_pages'] ) ); ?>">

					<?php wp_nonce_field( 'wp-api-doc-save' ) ?>

					<br><br>
					<input type="submit" name="submit_form" class="button button-primary" value="Save" />

				</form>
			</div>	
		<?php
	}
	
	protected static function handle_posted_settings() {
		$result = array(
            'message' => '',
            'type' => 'updated'
        );
 
        if( isset( $_POST['submit_form'] ) && check_admin_referer( 'wp-api-doc-save' ) ) {
            $options = self::get_options();
 
			if( isset( $_POST['root_pages'] ) ) {
				$root_pages = array();
				$ids = explode( ',', $_POST['root_pages'] );
				foreach ( $ids as $id ) {
					if ( is_numeric( $id ) ) {
						$root_pages[] = (int)$id;
					}
				}
				$options['root_pages'] = $root_pages;
            }
			
            self::save_options( $options );
 
            $result['message'] = "Options saved";
        }
 
        return $result;
	}
	
	public static function getRootPageIds() {
		$options = self::get_options();
		return $options['root_pages'];
	}
	
	protected static function save_options( $options ){
        if ( get_option( self::option_id ) !== false ) {
            update_option( self::option_id, $options );
        } else {
            add_option( self::option_id, $options, '', 'no' );
        }
    }
     
    protected static function get_options(){
        $options = get_option( self::option_id );
        $options = wp_parse_args(
            $options,
            array( 'root_pages' => array() ) 
        );
        return $options;
    }
}

WpApiDocOptions::hooks();