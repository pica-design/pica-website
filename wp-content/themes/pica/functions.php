<?php

	/* Wordpress Hook / Function Overrides */	
	add_action( 'init', 'pica_theme_setup' );
		
		//Adding thumbnail images into Posts
		add_theme_support( 'post-thumbnails', array( 'portfolio'));
			set_post_thumbnail_size( 360, 244, true ); // Normal post thumbnails
				
				
	function pica_theme_setup() {
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();		
				
		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', __( 'Primary Menu', 'pica' ) );
		
		//Custom post types
		//creates PORTFOLIO post type
		register_post_type( 'portfolio',
			array(
				'labels' => array(
					'name' => __( 'Portfolio' ),
					'singular_name' => __( 'Portfolio' )
				),
			'public' => true,
			'supports' => array('title','editor','thumbnail')
			//'has_archive' => true
			)	
		);
		register_taxonomy('type', 'portfolio',
			array(
				'hierarchical' => true,
				'label' => 'Portfolio Categories',	// the human-readable taxonomy name
				'query_var' => true,	// enable taxonomy-specific querying
				'rewrite' => array( 'slug' => 'portfolio-categories'),	// pretty permalinks for your taxonomy?
			)
		);
	}
	
	
	//Display a custom meta box on the cpt 'Portfolio' posts 
	if (is_admin()) {
		add_action ('load-post.php', 'add_page_meta_gallery_selection');
	}
		//Add a nextgen gallery selection meta box to pages
		function add_page_meta_gallery_selection () {
			return new gallery_selection ();
		}
			//Class controller for adding a ngg gallery selection meta box to pages
			class gallery_selection {
				//Initilize our meta box class
				public function __construct () {
					add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
					add_action('save_post', array(&$this, 'save_meta_box_data'));
				}
				//Add the meta box
				public function add_meta_boxes () {
					add_meta_box(
						'Gallery Picker',
						__( 'Attach a Gallery'),
						array( &$this, 'render_gallery_meta_box_content'),
						'portfolio',
						'side',
						'default'
					);
				}
				//Render the contents of our meta box
				public function render_gallery_meta_box_content () {
					global $post;
					//Define the meta box output
					$galleries = $wpdb->get_results("SELECT * FROM wp_ngg_gallery");
					$selectedGallery = get_post_meta($post->ID, 'gallery', true);
					
					?><select name="gallery"><option value=""></option><?php
					foreach ($galleries as $key => $gallery) :
						if ($gallery->gid == $selectedGallery) : $active = "selected='selected'"; 
						else : $active = ""; endif ;
						?><option value="<?php echo $gallery->gid ?>" <?php echo $active ?>><?php echo $gallery->title ?></option><?php
					endforeach;
					?>
						</select>
						<div style="margin-top: 8px ;">
							<a href="<?php bloginfo('url') ?>/wp-admin/admin.php?page=nggallery-add-gallery">
								Create new gallery
							</a>
						</div>
					<?php
				}
				
				//Store the meta box data
				public function save_meta_box_data ($post_id) {
					global $post;
					//Ensure we're only saving meta data for the published post and not a revision
					if ($post->ID == $post_id) :
						//Save the meta data
						update_post_meta($post_id, 'gallery', $_POST['gallery']);
					endif;
				}
			}	
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