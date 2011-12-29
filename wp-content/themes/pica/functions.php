<?php

	/* Wordpress Hook / Function Overrides */

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Masthead Navigation', 'FreeLandInMaine' ),
		'secondary' => __( 'Footer Navigation', 'FreeLandInMaine' ),
	) );
	
	/*-----------------------------------
	
		PRE: Expects an INT representing the ID of the gallery you wish to select
		POST: Returns a Multi-Dimensional Array containing all information about the gallery in question
				+ Includes all gallery sort order
				+ Includes all gallery images
	*/
	function getGallery ($gallery_id) {
		global $wpdb;
		global $table_prefix; 
		$gallery_res = $wpdb->get_results("SELECT * FROM " . $table_prefix . "ngg_gallery WHERE gid = $gallery_id", ARRAY_A);
		$gallery = $gallery_res[0];
		$images = $wpdb->get_results("SELECT * FROM " . $table_prefix . "ngg_pictures WHERE galleryid = $gallery_id", ARRAY_A);	
		$key = 0;
		foreach ($images as $image) {
			//Make sure the image has not been excluded in NextGen
			//Also make sure that the image is not the preview image (preview images are not added to the actual gallery - thats for albums only)
			if ($image['exclude'] == 0 /*&& $gallery['previewpic'] != $image['pid']*/) {
				$gallery['images'][] = $image;
				//unserialize meta_date
				$meta_data = unserialize($image['meta_data']);
				$gallery['images'][count($gallery['images']) - 1]['meta_data'] = $meta_data;
				$key++;
			} else {
				$gallery_thumb = $image['filename'];
			}
		}
		//If there is a previewpic set in ngg we want to set our gallery thumbnail to that image
		//else we want to set the gallery thumbnail to the first image in the gallery
		if ($gallery['previewpic'] != 0) {
			$gallery['thumbnail'] = $gallery_thumb;
		} else {
			$gallery['thumbnail'] = $gallery['images'][0]['filename'];
		}
		$gallery['image_count'] = $key;
		$gallery['page_link'] = get_permalink($gallery['pageid']);
		//sort images by ['sortorder'] DESC
		$tmp = Array();
		foreach($gallery['images'] as &$aSingleArray) {    
			$tmp[] = &$aSingleArray["sortorder"];
		}
		array_multisort($tmp, $gallery['images']);
		return $gallery;
	} //END getGallery()//
?>