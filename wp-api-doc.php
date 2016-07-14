<?php
/*
  Plugin Name: WP API Doc
  Description: Build "API reference" oriented documentation from WordPress page trees
  Version: 0.1
 */

if ( !class_exists( 'WpApiDoc' ) ) {

	require_once(dirname( __FILE__ ) . '/lib/metabox.php');
	require_once(dirname( __FILE__ ) . '/lib/cache.php');
	require_once(dirname( __FILE__ ) . '/lib/options-panel.php');

	class WpApiDoc {

		public static function hooks() {
			add_filter( 'template_include', array( __CLASS__, 'template_include' ) );
			add_action( 'template_redirect', array( __CLASS__, 'template_redirect' ) );
		}

		public static function template_include( $template ) {
			foreach( WpApiDocOptions::getRootPageIds() as $page_id ) {
				if ( is_page( $page_id ) ) {
					$plugin_path = plugin_dir_path( __FILE__ );
					$template = $plugin_path . '/templates/api-doc.php';
					break;
				}
			}
			return $template;
		}

		public static function template_redirect() {
			global $post;
			if ( !is_page() || in_array( $post->ID, WpApiDocOptions::getRootPageIds() ) ) {
				return;
			}

			$page_id = self::is_in_doc( $post );
			if( !empty( $page_id ) ) {
				wp_redirect( get_permalink( $page_id ) . '#' . self::get_dom_id( $post ), 301 );
				exit();
			}
		}

		public static function get_doc() {
			$post = get_post();
			$page_id = self::is_in_doc( $post );

			$doc = new stdClass();
			$doc->intro = get_page( $page_id );
			$doc->headings = apm_get_subpages( $page_id );
			foreach ( $doc->headings as $k => $heading ) {
				$doc->headings[$k]->items = apm_get_subpages( $heading->ID );
				foreach ( $doc->headings[$k]->items as $i => $sub_item ) {
					$doc->headings[$k]->items[$i]->items = apm_get_subpages( $sub_item->ID );
					foreach ( $doc->headings[$k]->items[$i]->items as $j => $sub_sub_item ) {
						$doc->headings[$k]->items[$i]->items[$j]->items = apm_get_subpages( $sub_sub_item->ID );
					}
				}
			}
			return $doc;
		}

		public static function get_content( $page ) {
			$content = '';
			if ( $page = get_post( $page ) ) {
				global $post;
				$post = $page;
				setup_postdata( $post );
				
				$page = apply_filters( 'wp_api_doc_page_before_get_content', $page );
				
				do_action( 'wp_api_doc_before_get_content', $page );
				
				$content = apply_filters( 'the_content', $page->post_content );
				$content = str_replace( ']]>', ']]&gt;', $content );
				$content = self::filter_content_links( $content );
				
				wp_reset_postdata();
			}
			
			$content = apply_filters( 'wp_api_doc_get_content', $content );
			
			return $content;
		}

		public static function get_dom_id( $page ) {
			$dom_id = '';
			if ( $page = get_post( $page ) ) {
				$dom_id = $page->ID . '-' . $page->post_name;
			}
			return $dom_id;
		}

		public static function get_title( $page ) {
			$title = '';
			if ( $page = get_post( $page ) ) {
				$title = get_the_title( $page );
			}
			return $title;
		}

		public static function get_title_with_edit_link( $page, $clickable = true ) {
			$title = '';
			if ( $page = get_post( $page ) ) {
				$title = get_the_title( $page );

				if( $clickable ) {
					$title = '<a href="#' . self::get_dom_id( $page ) . '">' . $title . '</a>';
				}

				if ( $edit_link = self::get_edit_link( $page ) ) {
					$title .= ' ' . $edit_link;
				}
			}
			return $title;
		}

		public static function get_edit_link( $page ) {
			$edit_link = '';
			if ( $page = get_post( $page ) ) {
				if ( current_user_can( 'edit_pages' ) ) {
					$edit_link .= '<a class="edit" href="' . get_edit_post_link( $page->ID ) . '">' . __( 'edit' ) . '</a>';
				}
			}
			return $edit_link;
		}

		public static function get_usage( $page ) {
			return wp_api_doc_metabox::get_page_usage( $page );
		}

		public static function get_arguments( $page ) {
			return wp_api_doc_metabox::get_page_arguments( $page );
		}

		public static function get_return( $page ) {
			return wp_api_doc_metabox::get_page_return( $page );
		}

		private static function filter_content_links( $content ) {
			if ( preg_match_all( '/<a .*?(href="(.*?)").*?>/', $content, $matches, PREG_SET_ORDER ) ) {
				foreach ( $matches as $match ) {
					if ( $post_id = url_to_postid( $match[2] ) ) {
						if ( $root_page_id = self::is_in_doc( $post_id ) ) {
							$content = str_replace( $match[1], 'href="'. get_permalink( $root_page_id ) .'#' . self::get_dom_id( $post_id ) . '"', $content );
						}
					}
				}
			}
			return $content;
		}

		private static function is_in_doc( $page ) {
			$in_doc = false;
			
			if ( is_numeric( $page ) ) {
				$page = get_post( $page );
			}
			
			if ( $page ) {
				$root_page_ids = WpApiDocOptions::getRootPageIds();

				$in_doc = array_search( $page->ID, $root_page_ids );

				while ( $page->post_parent ) {
					$page = get_page( $page->post_parent );
					$in_doc = array_search( $page->ID, $root_page_ids );
					if ( $in_doc !== false ) {
						break;
					}
				}
			}
			
			return $in_doc !== false ? $root_page_ids[$in_doc] : $in_doc;
		}

	}

	WpApiDoc::hooks();
}
