<?php

class WpApiDocCache {
	
	const transient_name = 'api-doc-transient';
	const transient_name_logged_in = 'api-doc-transient-logged-in';
	
	public static function hooks() {
		add_action( 'save_post', array( __CLASS__, 'reset_on_page_save' ), 10, 2 );
	}
	
	public static function reset_on_page_save( $post_ID, $post ) {
		if ( $post->post_type === 'page' ) {
			if ( $mother_page_ID = WpApiDoc::is_in_doc( $post ) ) {
				self::reset( $post_ID );
				self::reset( $mother_page_ID );
			}
		}
	}
	
	public static function start() {
		global $post;
		
		$force_flush = isset( $_GET['flush'] );
		
		if ( !$force_flush ) {
			$cache = get_transient( self::get_transient_name( $post->ID, current_user_can( 'edit_pages' ) ) );
			if ( $cache ) {
				$cache .= "\n<!-- Retrieved from WpApiDoc cache -->";
				echo $cache;
				exit();
			}
		}
		
		ob_start();
	}
	
	public static function end() {
		global $post;
		$cache = ob_get_contents();
		set_transient( self::get_transient_name( $post->ID, current_user_can( 'edit_pages' ) ), $cache );
		ob_end_clean();
		echo $cache;
	}
	
	public static function reset( $page_id ) {
		delete_transient( self::get_transient_name( $page_id ) );
		delete_transient( self::get_transient_name( $page_id, true ) );
	}
	
	protected static function get_transient_name( $page_id, $logged_in = false ) {
		return ( $logged_in ? self::transient_name_logged_in : self::transient_name ) .'_'. $page_id;
	}
	
}

WpApiDocCache::hooks();