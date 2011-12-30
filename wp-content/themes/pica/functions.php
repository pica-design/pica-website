<?php

	/* Wordpress Hook / Function Overrides */
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Display relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'rel_canonical'); //Remove the wp canonical url
	add_filter( 'next_post_rel_link', 'disable_stuff' );
	function disable_stuff( $data ) { return false; }
	
	function my_init_method() {
		if (!is_admin()) {
			add_action('wp_print_styles', 'remove_ngg_style');
		}
	}    
	add_action('init', 'my_init_method');
	
	function remove_ngg_style () { wp_dequeue_style('NextGEN'); }
	define('NGG_SKIP_LOAD_SCRIPTS', true);
	
	/*
	add_action('wp_head', 'show_template');
	function show_template() {
		global $template;
		print_r($template);
	}
	*/
	 
	
	/* Pica Theme Setup Action */
	add_action( 'init', 'pica_theme_setup' );
		
		//Adding thumbnail images into Posts
		add_theme_support( 'post-thumbnails', array( 'work'));
			set_post_thumbnail_size( 360, 244, true ); // Normal post thumbnails
			
		function pica_theme_setup() {
			// This theme styles the visual editor with editor-style.css to match the theme style.
			add_editor_style();		
					
			// This theme uses wp_nav_menu() in one location.
			register_nav_menu( 'primary', __( 'Primary Menu', 'pica' ) );
			
			//Custom post types
			//creates PORTFOLIO post type
			register_post_type( 'work',
				array(
					'labels' => array(
						'name' => __( 'Work' ),
						'singular_name' => __( 'Work Item' ),
						'add_new_item' => 'Add New Work Item',
						'edit_item' => 'Edit Work Items',
						'new_item' => 'New Work Item',
						'search_items' => 'Search Work Items',
						'not_found' => 'No Work Items found',
						'not_found_in_trash' => 'No Work Items found in trash',
				   ),
					'public' => true,
					'supports' => array('title','editor','thumbnail')//,
					//'has_archive' => true,
					//'rewrite' => array('slug', 'work-item')
				)	
			);
			register_taxonomy('type', 'work',
				array(
					'hierarchical' => true,
					'label' => 'Work Categories',	// the human-readable taxonomy name
					'query_var' => true,	// enable taxonomy-specific querying
					'rewrite' => array( 'slug' => 'work-categories'),	// pretty permalinks for your taxonomy?
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
						'work',
						'side',
						'default'
					);
					add_meta_box(
						'Gallery Picker',
						__( 'Attach a Gallery'),
						array( &$this, 'render_gallery_meta_box_content'),
						'page',
						'side',
						'default'
					);
				}
				//Render the contents of our meta box
				public function render_gallery_meta_box_content () {
					global $post, $wpdb;
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
			}//END gallery_selection class
	
	
	/*-----------------------------------
		GET A NEXTGEN IMAGE GALLERY IN ARRAY FORMAT
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
		$gallery_thumb = "";
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