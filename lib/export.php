<?php
require_once( __DIR__ .'/../../../../wp-load.php');

$doc_mother_page_id = 193;

$mother_page = get_post( $doc_mother_page_id );

$doc_page_ids = array( array( $mother_page->ID, $mother_page->post_title ) );

$pages = apm_get_subpages( $doc_mother_page_id );
foreach ( $pages as $k => $page ) {
	$doc_page_ids[] = array( $page->ID, $page->post_title );
	$sub_pages = apm_get_subpages( $page->ID );
	foreach ( $sub_pages as $i => $sub_page ) {
		$doc_page_ids[] = array( $sub_page->ID, $sub_page->post_title );
		$sub_sub_pages = apm_get_subpages( $sub_page->ID );
		foreach ( $sub_sub_pages as $j => $sub_sub_page ) {
			$doc_page_ids[] = array( $sub_sub_page->ID, $sub_sub_page->post_title );
			$sub_sub_sub_pages = apm_get_subpages( $sub_sub_page->ID );
			foreach ( $sub_sub_sub_pages as $k => $sub_sub_sub_page ) {
				$doc_page_ids[] = array( $sub_sub_sub_page->ID, $sub_sub_sub_page->post_title );
			}
		}
	}
}

//print_r($doc_page_ids);

echo implode(',', wp_list_pluck( $doc_page_ids, 0 ) );
