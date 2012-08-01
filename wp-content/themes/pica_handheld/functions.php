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
	
	/* Pica Theme Setup Action */
	add_action( 'init', 'pica_theme_setup' );
		
		//Adding thumbnail images into Posts
		add_theme_support( 'post-thumbnails', array('post', 'page', 'pica_work', 'pica_brandnew'));
		//Set our post thumbnail image dimensions
		set_post_thumbnail_size( 360, 244, true ); // Normal post thumbnails
		//Add our extra-large image size for media uploads
		add_image_size( 'homepage', 1250, 500, true ); 
		add_image_size( 'blogroll', 355, 125, true);
		add_image_size( 'portfolio', 1130, 650, true);
		
		function custom_excerpt_length( $length ) {
			//echo is_home();
			return 15;
		}
		add_filter( 'excerpt_length', 'custom_excerpt_length', 30 );
		
		function new_excerpt_more($more) {
			return '...';
		}
		add_filter('excerpt_more', 'new_excerpt_more');
		
		add_shortcode('employee-bios', 'employee_bio_shortcode');
		function employee_bio_shortcode () {
			global $post;
			$gallery = new Post_Gallery($post->ID);
			if (count($gallery->attachments) > 1) :
				$html_str  = "<div class='clear'></div>"; 
				$html_str .= "<div class='about-employee-profiles'>\n";
				foreach ($gallery->attachments as $attachment) :
					$html_str .= "<div class='employee-profile'>\n";
					$html_str .= "<img src='$attachment->guid' alt='$attachment->post_title' class='employee-photo' />\n";
					$html_str .= "<strong>$attachment->post_title</strong>\n";
					$html_str .= "<br />\n";
					$html_str .= "<small>{$attachment->meta_data['_wp_attachment_image_alt'][0]}</small>\n";
					$html_str .= "<br /><br />\n";
					$html_str .= $attachment->post_content;
					$html_str .= "</div>\n";                           
				endforeach ;
				$html_str .= "</div>\n";
				$html_str .= "<div class='clear'></div>"; 
				return $html_str ;
			 endif ;
		}
		
		function pica_theme_setup() {
			// This theme styles the visual editor with editor-style.css to match the theme style.
			add_editor_style('styles/global-styles.css');	
			// This theme uses wp_nav_menu() in one location.
			register_nav_menu( 'primary', __( 'Primary Menu', 'pica' ) );
			//Create the 'Work' post type
			register_post_type( 'pica_work',
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
					'hierarchical' => true,
					'supports' => array('title','editor','thumbnail','gallery'),
					'rewrite' => array('slug' => 'work', 'with_front' => false)
				)	
			);
						
			//Create the 'Type' taxonomy for the 'Work' post type
			register_taxonomy('pica_work_type', 'pica_work',
				array(
					'hierarchical' => true,
					'label' => 'Work Categories',	// the human-readable taxonomy name
					'query_var' => true,	// enable taxonomy-specific querying
					'rewrite' => array( 'slug' => 'work-categories', 'with_front' => false),	// pretty permalinks for your taxonomy?
				)
			);
			
			//Create a new column 'Type' on the admin 'Work' page to display the types of each work item
			add_filter('manage_edit-pica_work_columns', 'manage_pica_work_admin_columns');
			//Populate the contents of the new columns we just created
			add_action('manage_pica_work_posts_custom_column', 'manage_pica_work_admin_columns_content');
			//Tell WordPress those new columns can be sortable within the admin
			add_filter('manage_edit-pica_work_sortable_columns', 'pica_work_type_column_register_sortable' );
			
			//Create the 'Work' post type
			register_post_type( 'pica_brandnew',
				array(
					'labels' => array(
						'name' => __( 'Brandnew' ),
						'singular_name' => __( 'Brandnew Item' ),
						'add_new_item' => 'Add New Brandnew Item',
						'edit_item' => 'Edit Brandnew Items',
						'new_item' => 'New Brandnew Item',
						'search_items' => 'Search Brandnew Items',
						'not_found' => 'No Brandnew Items found',
						'not_found_in_trash' => 'No Brandnew Items found in trash',
				   ),
					'public' => true,
					'hierarchical' => true,
					'supports' => array('title','editor','thumbnail','gallery'),
					'rewrite' => array('slug' => 'brandnew', 'with_front' => false)
				)	
			);
						
			//Create the 'Type' taxonomy for the 'Work' post type
			register_taxonomy('pica_brandnew_type', 'pica_brandnew',
				array(
					'hierarchical' => true,
					'label' => 'Brandnew Categories',	// the human-readable taxonomy name
					'query_var' => true,	// enable taxonomy-specific querying
					'rewrite' => array( 'slug' => 'brandnew-categories', 'with_front' => false),	// pretty permalinks for your taxonomy?
				)
			);
			
			//Create a new column 'Type' on the admin 'Work' page to display the types of each work item
			add_filter('manage_edit-pica_brandnew_columns', 'manage_pica_brandnew_admin_columns');
			//Populate the contents of the new columns we just created
			add_action('manage_pica_brandnew_posts_custom_column', 'manage_pica_brandnew_admin_columns_content');
			//Tell WordPress those new columns can be sortable within the admin
			add_filter('manage_edit-pica_brandnew_sortable_columns', 'pica_brandnew_type_column_register_sortable' );
		}
		
		//The following function is triggered when the admin views the list of 'Location' posts 
		//We want to tap in and add a column for the location ID and a column for the location region taxonomy term
		function manage_pica_work_admin_columns ($columns) {
			$new_columns['cb'] = '<input type="checkbox" />';
			$new_columns['title'] = _x('Work Name', 'column name');
			$new_columns['pica_work_short_name'] = __('Short Name');			
			$new_columns['pica_work_type'] = __('Type');
			$new_columns['author'] = __('Author');
			$new_columns['date'] = _x('Date', 'column name');
			return $new_columns;
		}
		// Register the new 'Location' columns as sortable
		function pica_work_type_column_register_sortable( $columns ) {
			$columns['pica_work_type'] = 'pica_work_type';
			$columns['pica_work_short_name'] = 'pica_work_short_name';
			return $columns;
		}
		//Create the contents of our new 'Location' columns
		function manage_pica_work_admin_columns_content ($column) {
			global $post;
			switch ($column) :
				case 'pica_work_type':
					$terms = get_the_terms( $post->ID, 'pica_work_type');
					if ($terms) :
						$count = 0;
						foreach ($terms as $term) :
							echo '<a href="'.get_bloginfo('url').'/wp-admin/edit-tags.php?action=edit&taxonomy=pica_work_type&post_type=pica_work&tag_ID='.$term->term_id.'">'.$term->name.'</a>';
							if ($count != (count($terms) - 1)) :
								echo ", ";
							endif;
							$count++;
						endforeach;
					endif;
				break;
				case 'pica_work_short_name':
					echo get_post_meta($post->ID, '_work_short_name', true);
				break;
			endswitch;
		}
		
		function pica_work_cpt_taxonomy_filters() {
			global $typenow;
		 
			// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
			$taxonomies = array('pica_work_type');
		 
			// must set this to the post type you want the filter(s) displayed on
			if( $typenow == 'pica_work' ){
		 
				foreach ($taxonomies as $tax_slug) {
					$tax_obj = get_taxonomy($tax_slug);
					$tax_name = $tax_obj->labels->name;
					$terms = get_terms($tax_slug);
					if(count($terms) > 0) {
						echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
						echo "<option value=''>Show All $tax_name</option>";
						foreach ($terms as $term) { 
						
							//ERROR - unless ?pica_work_type is set in the url already the following throws an error, TBF
						
							echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
						}
						echo "</select>";
					}
				}
			}
		}
		add_action( 'restrict_manage_posts', 'pica_work_cpt_taxonomy_filters' );
		
		
		//The following function is triggered when the admin views the list of 'Location' posts 
		//We want to tap in and add a column for the location ID and a column for the location region taxonomy term
		function manage_pica_brandnew_admin_columns ($columns) {
			$new_columns['cb'] = '<input type="checkbox" />';
			$new_columns['title'] = _x('Brandnew Work Name', 'column name');
			$new_columns['pica_brandnew_type'] = __('Type');
			$new_columns['author'] = __('Author');
			$new_columns['date'] = _x('Date', 'column name');
			return $new_columns;
		}
		// Register the new 'Location' columns as sortable
		function pica_brandnew_type_column_register_sortable( $columns ) {
			$columns['pica_work_type'] = 'pica_work_type';
			return $columns;
		}
		//Create the contents of our new 'Location' columns
		function manage_pica_brandnew_admin_columns_content ($column) {
			global $post;
			switch ($column) :
				case 'pica_brandnew_type':
					$terms = get_the_terms( $post->ID, 'pica_brandnew_type');
					if ($terms) :
						$count = 0;
						foreach ($terms as $term) :
							echo '<a href="'.get_bloginfo('url').'/wp-admin/edit-tags.php?action=edit&taxonomy=pica_brandnew_type&post_type=pica_brandnew&tag_ID='.$term->term_id.'">'.$term->name.'</a>';
							if ($count != (count($terms) - 1)) :
								echo ", ";
							endif;
							$count++;
						endforeach;
					endif;
				break;
			endswitch;
		}
		
		function pica_brandnew_cpt_taxonomy_filters() {
			global $typenow;
		 
			// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
			$taxonomies = array('pica_brandnew_type');
		 
			// must set this to the post type you want the filter(s) displayed on
			if( $typenow == 'pica_brandnew' ){
		 
				foreach ($taxonomies as $tax_slug) {
					$tax_obj = get_taxonomy($tax_slug);
					$tax_name = $tax_obj->labels->name;
					$terms = get_terms($tax_slug);
					if(count($terms) > 0) {
						echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
						echo "<option value=''>Show All $tax_name</option>";
						foreach ($terms as $term) { 
							echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
						}
						echo "</select>";
					}
				}
			}
		}
		add_action( 'restrict_manage_posts', 'pica_brandnew_cpt_taxonomy_filters' );
		
	
	//Display a custom meta box on the cpt 'Portfolio' posts 
	if (is_admin()) {
		add_action ('load-post.php', 'add_pica_meta_boxes');
	}
		//Add a nextgen gallery selection meta box to pages
		function add_pica_meta_boxes () {
			return new pica_meta_boxes ();
		}
			//Class controller for adding a ngg gallery selection meta box to pages
			class pica_meta_boxes {
				//Initilize our meta box class
				public function __construct () {
					add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
					add_action('save_post', array(&$this, 'save_meta_box_data'));
				}
				//Add the meta box
				public function add_meta_boxes () {
					add_meta_box(
						'Text Color',
						__( 'Text Color'),
						array( &$this, 'render_work_text_color_choice'),
						'pica_work',
						'side',
						'default'
					);
					add_meta_box(
						'Background Color',
						__( 'Background Color'),
						array( &$this, 'render_work_bg_color_choice'),
						'pica_work',
						'side',
						'default'
					);
					add_meta_box(
						'Work Short Name',
						__( 'Work Short Name'),
						array( &$this, 'render_work_short_name'),
						'pica_work',
						'side',
						'default'
					);
					add_meta_box(
						'Testimonial',
						__( 'Testimonial'),
						array( &$this, 'render_work_testimonial'),
						'pica_work',
						'normal',
						'default'
					);
					add_meta_box(
						'Allow Comments',
						__( 'Allow Comments'),
						array( &$this, 'render_comments'),
						'post',
						'side',
						'default'
					);
				}
				//render the meta box output
				public function render_work_text_color_choice () {
					global $post;
					?>
                    <input name="work_text_color" value="<?php echo get_post_meta($post->ID, 'work_text_color', true) ?>" />
                    <?php
				}
				public function render_work_bg_color_choice () {
					global $post;
					?>
                    <input name="work_bg_color" value="<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>" />
                    <?php
				}
				public function render_work_short_name () {
					global $post;
					?>
                    <input name="work_short_name" value="<?php echo get_post_meta($post->ID, '_work_short_name', true) ?>" />
                    <?php
				}
				public function render_work_testimonial () {
					global $post;
					?>
                    	<textarea name="work_testimonial">
                        	<?php echo trim(get_post_meta($post->ID, '_work_testimonial', true)) ?>
                        </textarea>
                    <?php
				}
				
				public function render_comments () {
					global $post;
					if (get_post_meta($post->ID, '_post_allow_comments', true) == 1) :
						$checked = "checked='checked'";
					else :
						$checked = "";
					endif;
					?>
                    	Yes:
                    	<input type="checkbox" name="post_allow_comments" value="1" <?php echo $checked ?> />
                    <?php
				}
				
				//Store the meta box data
				public function save_meta_box_data ($post_id) {
					global $post;
					
					//print_r($_POST);
					
					//Ensure we're only saving meta data for the published post and not a revision
					if ($post->ID == $post_id) :
						//Save the meta data
						if (isset($_POST['work_text_color'])) :
							update_post_meta($post_id, 'work_text_color', $_POST['work_text_color']);
						endif;
						if (isset($_POST['work_bg_color'])) :
							update_post_meta($post_id, 'work_bg_color', $_POST['work_bg_color']);						
						endif;
						if (isset($_POST['work_short_name'])) :
							update_post_meta($post_id, '_work_short_name', $_POST['work_short_name']);
						endif;
						if (isset($_POST['work_testimonial'])) :
							update_post_meta($post_id, '_work_testimonial', trim($_POST['work_testimonial']));
						endif;
						
						if (isset($_POST['post_allow_comments'])) :
							$post_allow_comments = $_POST['post_allow_comments'];
						else :
							$post_allow_comments = 0;						
						endif ;
						update_post_meta($post_id, '_post_allow_comments', $post_allow_comments);
						
					endif;
				}
			}//END pica_meta_boxes class
	
	
	
	
	
	/***********************************************************
		
		WORDPRESS GALLERY CUSTOMIZATIONS
		
	***********************************************************/
	
	//Add any custom image sizes that will be needed for the website
	//These dimensions are based on the website design the image sizes it calls for
	
	/* Adding custom attachment fields */
	add_filter("attachment_fields_to_edit", "post_attachment_new_fields", null, 2);
	/* Save custom attachment fields on update */
	add_filter("attachment_fields_to_save", "update_post_attachment_new_fields", null , 2);
	
	/* Adding custom attachment fields */
	function post_attachment_new_fields ($form_fields, $post) {
		$form_fields["attachment-copyright"] = array(
			"label" => __("Copyright"),
			"input" => "text", // this is default if "input" is omitted
			"value" => get_post_meta($post->ID, "_attachment-copyright", true),
			"helps" => __("Set your copyright information."),
		);
		$form_fields["attachment-exclude-from-gallery"] = array(
			"label" => __("Exclude"),
			"input" => "html",
			"html"  => "<input type='checkbox' name='attachments[$post->ID][attachment-exclude-from-gallery]' " . checked( get_post_meta($post->ID, "_attachment-exclude-from-gallery", true), 'on', 0 ) . " /> &nbsp;" . __("Don't show this attachment in the gallery.")
		);
		$form_fields["attachment-exlink"] = array(
			"label" => __("External Link"),
			"input" => "text", // this is default if "input" is omitted
			"value" => get_post_meta($post->ID, "_attachment-exlink", true),
			"helps" => __("Post link to external website."),
		);
	   return $form_fields;
	}
	
	/* Save custom attachment fields */ 
	function update_post_attachment_new_fields ($post, $attachment) {
		if (isset($attachment['attachment-copyright'])) : 
			update_post_meta($post['ID'], '_attachment-copyright', $attachment['attachment-copyright']);
		endif;
		if (isset($attachment['attachment-exclude-from-gallery'])) : 
			update_post_meta($post['ID'], '_attachment-exclude-from-gallery', $attachment['attachment-exclude-from-gallery']);
		else :
			update_post_meta($post['ID'], '_attachment-exclude-from-gallery', 'off');
		endif;
		if (isset($attachment['attachment-exlink'])) : 
			update_post_meta($post['ID'], '_attachment-exlink', $attachment['attachment-exlink']);
		endif;
		return $post;
	}
	
	//The Post Gallery class issues objects containing an post's attachment 'gallery' and returns an array of that data
	class Post_Gallery {
		public function __construct ($post_id) {
			//Make the current post global - !!!! This should be passed in, or at least the option to do so !!!!
			if (empty($post_id)) : global $post; $post_id = $post->ID ; endif;
			
			$this->attachments = new WP_Query( 
				array (
					'post_parent' => $post_id, 
					'post_status' => 'inherit', 
					'post_type' => 'attachment',
					'order' => 'ASC', 
					'orderby' => 'menu_order',
					'posts_per_page' => -1,
					'meta_query' => array(
						array(				
							'key' => '_attachment-exclude-from-gallery',
							'value' => 'off',
							'compare' => '='
						)
					)
				), ARRAY_A
			);
			wp_reset_postdata();
			wp_reset_query();

			//Make the attachments object a little cleaner by only using the data we want, the posts.
			//This also ensures our ->attachments variable holds and array (so we can easily display a random attachment on the website homepage
			$this->attachments = $this->attachments->posts;
			
			////Merge some additional attachment data into our main object
			foreach ($this->attachments as &$attachment) :
				//Grab the attachment's meta data
				$attachment->meta_data = get_post_custom($attachment->ID);
				//Some of our meta data needs to be unserialized for use to user it
				$attachment->meta_data['_wp_attachment_metadata'] = @unserialize($attachment->meta_data['_wp_attachment_metadata'][0]);
			endforeach;
			
			//Remove the array indecies (they do not help us)
			$this->attachments = array_values($this->attachments);
		}//End __construct
	}
?>