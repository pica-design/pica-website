<?php

	/*********************************************************
	WORDPRESS CORE MODIFICATIONS
	*********************************************************/
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
	add_filter( 'excerpt_length', 'excerpt_length', 140 );	
	add_filter('excerpt_more', 'excerpt_more');
	function disable_stuff( $data ) { return false; }
	function excerpt_length( $length ) { return 140; }
	function excerpt_more($more) { return '...'; }
	
	
	
	
	/*********************************************************
	THEME SETUP
	*********************************************************/
	
	/* Pica Theme Setup Action */
	add_action( 'init', 'pica_theme_setup' );
	
	function pica_theme_setup() {
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style('styles/global-styles.css');	
		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', __( 'Primary Menu', 'pica' ) );
		
		/*********************************************************
		WORK CPT
		*********************************************************/
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
		//Allow taxonomy sorting for the pica work cpt
		add_action( 'restrict_manage_posts', 'pica_work_cpt_taxonomy_filters' );
		
		//We want to tap in and add a column for the location ID and a column for the location region taxonomy term
		function manage_pica_work_admin_columns ($columns) {
			$new_columns['cb'] = '<input type="checkbox" />';
			$new_columns['title'] = _x('Work Name', 'column name');
			$new_columns['pica_work_short_name'] = __('Short Name');			
			$new_columns['pica_work_type'] = __('Type');
			$new_columns['author'] = __('Author');
			$new_columns['date'] = _x('Date', 'column name');
			return $new_columns;
		}//end function manage_pica_work_admin_columns
		
		// Register the new 'Location' columns as sortable
		function pica_work_type_column_register_sortable( $columns ) {
			$columns['pica_work_type'] = 'pica_work_type';
			$columns['pica_work_short_name'] = 'pica_work_short_name';
			return $columns;
		}//end function pica_work_type_column_register_sortable
		
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
		}//end function manage_pica_work_admin_columns_content
		
		function pica_work_cpt_taxonomy_filters() {
			global $typenow;
			// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
			$taxonomies = array('pica_work_type');
			// must set this to the post type you want the filter(s) displayed on
			if($typenow == 'pica_work') :
				foreach ($taxonomies as $tax_slug) :
					$tax_obj = get_taxonomy($tax_slug);
					$tax_name = $tax_obj->labels->name;
					$terms = get_terms($tax_slug);
					if(count($terms) > 0) :
						echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
						echo "<option value=''>Show All $tax_name</option>";
						foreach ($terms as $term) :
							echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
						endforeach;
						echo "</select>";
					endif;
				endforeach;
			endif;
		}//end function pica_work_cpt_taxonomy_filters
		
		/*********************************************************
		BRANDNEW CPT
		*********************************************************/
		register_post_type( 'pica_brandnew',
			array(
				'labels' => array(
					'name' => __( 'Brand New' ),
					'singular_name' => __( 'Brand New Item' ),
					'add_new_item' => 'Add New Brand New Item',
					'edit_item' => 'Edit Brand New Items',
					'new_item' => 'New Brand New Item',
					'search_items' => 'Search Brand New Items',
					'not_found' => 'No Brand New Items found',
					'not_found_in_trash' => 'No Brand New Items found in trash',
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
				'label' => 'Brand New Categories',	// the human-readable taxonomy name
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
		//Allow taxonomy sorting for the pica brandnew cpt
		add_action( 'restrict_manage_posts', 'pica_brandnew_cpt_taxonomy_filters' );
		
		//The following function is triggered when the admin views the list of 'Location' posts 
		//We want to tap in and add a column for the location ID and a column for the location region taxonomy term
		function manage_pica_brandnew_admin_columns ($columns) {
			$new_columns['cb'] = '<input type="checkbox" />';
			$new_columns['title'] = _x('Brandnew Work Name', 'column name');
			$new_columns['pica_brandnew_type'] = __('Type');
			$new_columns['author'] = __('Author');
			$new_columns['date'] = _x('Date', 'column name');
			return $new_columns;
		}//end function manage_pica_brandnew_admin_columns
		
		// Register the new 'Location' columns as sortable
		function pica_brandnew_type_column_register_sortable( $columns ) {
			$columns['pica_work_type'] = 'pica_work_type';
			return $columns;
		}//end function pica_brandnew_type_column_register_sortable
		
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
		}//end function manage_pica_brandnew_admin_columns_content
		
		function pica_brandnew_cpt_taxonomy_filters() {
			global $typenow;
			// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
			$taxonomies = array('pica_brandnew_type');
			// must set this to the post type you want the filter(s) displayed on
			if($typenow == 'pica_brandnew') :
				foreach ($taxonomies as $tax_slug) :
					$tax_obj = get_taxonomy($tax_slug);
					$tax_name = $tax_obj->labels->name;
					$terms = get_terms($tax_slug);
					if(count($terms) > 0) :
						echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
						echo "<option value=''>Show All $tax_name</option>";
						foreach ($terms as $term) :
							echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
						endforeach;
						echo "</select>";
					endif;
				endforeach;
			endif;
		}//end function pica_brandnew_cpt_taxonomy_filters
	}//end function pica_theme_setup
		
	
	/*********************************
	META BOXES
	*********************************/	
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
	
	
	
	/*********************************
	SHORTCODES
	*********************************/	
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

	
	/*********************************
	USER ADDITIONS
	*********************************/	
	//We're going to add our new 'title' field directly before the password fields
		//This isn't really the best method - but it's the only one to get our field adjecent to the user bio
	add_filter('show_password_fields', 'add_user_title', 10,1);
	add_action( 'personal_options_update', 'save_additional_user_fields' );
	add_action( 'edit_user_profile_update', 'save_additional_user_fields' );
	
	function add_user_title () {
		global $user_id;
		?>
        <tr>
        	<th><label for="user-title">Title</label></th>
        	<td>
            	
                <input type="text" name="user-title" id="user-title" value="<?php echo esc_attr( get_the_author_meta( 'user-title', $user_id ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your title.</span>
                        
            </td>
        </tr>
        <?php
		
		//If we don't return true the user password fields will no display
		return true;
	}	
	
	//Save the user meta data (including our new 'title' field)
	function save_additional_user_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		update_usermeta( $user_id, 'user-title', $_POST['user-title'] );
	}
	
	
	
	/************************************
	WORDPRESS GALLERY & IMAGE CUSTOMIZATIONS	
	************************************/
	
	//Add any custom image sizes that will be needed for the website
	//These dimensions are based on the website design the image sizes it calls for
	
	//Adding thumbnail images into Posts
	add_theme_support( 'post-thumbnails', array('post', 'page', 'pica_work', 'pica_brandnew'));
	//Set our post thumbnail image dimensions
	set_post_thumbnail_size( 360, 244, true ); // Normal post thumbnails
	//Add our extra-large image size for media uploads
	add_image_size( 'homepage', 1250, 500, true ); 
	add_image_size( 'blogroll', 355, 125, true);
	add_image_size( 'portfolio', 1130, 650, true);
	
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
			
			
			//print_r($this->attachments);
			

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
	
	//Define our twitter tweet-fetching class
	class Twitter {
		public function __construct () {
			$this->search = 0;
		}
		public function perform_search ( $query = null, $count = 5 ) {
			$url = "http://search.twitter.com/search.json?q=" . urlencode( $query ) . "&lang=en&rpp=$count&include_entities=true";
			$curl = curl_init();
			curl_setopt( $curl, CURLOPT_URL, $url );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $curl, CURLOPT_HTTPHEADER, array("Expect:")); 
			$result = curl_exec( $curl );
			curl_close( $curl );
			
			//Keep a copy of the converted json feed
			$this->search = json_decode( $result );
			
			if(!empty($this->search->results)) :
			
				//Replace raw tweet text with some links and flourishes
				foreach ($this->search->results as &$tweet) :
					
					//Twitter stores shortened URLs in the tweet text, but we want to show the original url
					if (isset($tweet->entities)) :
						if (isset($tweet->entities->urls)) :
							if (is_array($tweet->entities->urls)) :
								foreach ($tweet->entities->urls as $tweeted_urls) :
									$tweet->text = str_replace($tweeted_urls->url, $tweeted_urls->expanded_url, $tweet->text);
								endforeach;
							endif;
						endif;
					endif;
					if (isset($tweet->entities)) :
						if (isset($tweet->entities->media)) :
							if (is_array($tweet->entities->media)) :
								foreach ($tweet->entities->media as $tweeted_media) :
									$tweet->text = str_replace($tweeted_media->url, $tweeted_media->display_url, $tweet->text);
								endforeach;
							endif;
						endif;
					endif;
				
					//Replace plain text URL's with working html anchors
					$tweet->text = htmlEscapeAndLinkUrls($tweet->text);
					
					//Replace @username with @<a href="twitter profile url">username</a>
					$tweet->text = preg_replace('/@(\w+)/', " <span class='at-symbol'>@</span><a href='http://twitter.com/$1' target='_blank'>$1</a>", $tweet->text);
					
					//Replace hashtags with link to said tag
					$tweet->text = preg_replace('/#([a-z_0-9]+)/i', "<a href='http://www.twitter.com/search/$0' target='_blank'>$0</a>", $tweet->text);
					
					//Replace <3 with the ascii heart symbol
					$tweet->text = preg_replace('/(&lt;)+[3]/i', "<span class='heart'>&#x2665;</span>", $tweet->text);
				endforeach;
			endif;
		}
	}
	
	


	/**
	 *  UrlLinker - facilitates turning plain text URLs into HTML links.
	 *
	 *  Author: Søren Løvborg
	 *
	 *  To the extent possible under law, Søren Løvborg has waived all copyright
	 *  and related or neighboring rights to UrlLinker.
	 *  http://creativecommons.org/publicdomain/zero/1.0/
	 */
	
	/*
	 *  Regular expression bits used by htmlEscapeAndLinkUrls() to match URLs.
	 */
	$rexProtocol  = '(https?://)?';
	$rexDomain    = '(?:[-a-zA-Z0-9]{1,63}\.)+[a-zA-Z][-a-zA-Z0-9]{1,62}';
	$rexIp        = '(?:[1-9][0-9]{0,2}\.|0\.){3}(?:[1-9][0-9]{0,2}|0)';
	$rexPort      = '(:[0-9]{1,5})?';
	$rexPath      = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
	$rexQuery     = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
	$rexFragment  = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
	$rexUsername  = '[^]\\\\\x00-\x20\"(),:-<>[\x7f-\xff]{1,64}';
	$rexPassword  = $rexUsername; // allow the same characters as in the username
	$rexUrl       = "$rexProtocol(?:($rexUsername)(:$rexPassword)?@)?($rexDomain|$rexIp)($rexPort$rexPath$rexQuery$rexFragment)";
	$rexUrlLinker = "{\\b$rexUrl(?=[?.!,;:\"]?(\s|$))}";
	
	/**
	 *  $validTlds is an associative array mapping valid TLDs to the value true.
	 *  Since the set of valid TLDs is not static, this array should be updated
	 *  from time to time.
	 *
	 *  List source:  http://data.iana.org/TLD/tlds-alpha-by-domain.txt
	 *  Last updated: 2011-10-09
	 */
	$validTlds = array_fill_keys(explode(" ", ".ac .ad .ae .aero .af .ag .ai .al .am .an .ao .aq .ar .arpa .as .asia .at .au .aw .ax .az .ba .bb .bd .be .bf .bg .bh .bi .biz .bj .bm .bn .bo .br .bs .bt .bv .bw .by .bz .ca .cat .cc .cd .cf .cg .ch .ci .ck .cl .cm .cn .co .com .coop .cr .cu .cv .cx .cy .cz .de .dj .dk .dm .do .dz .ec .edu .ee .eg .er .es .et .eu .fi .fj .fk .fm .fo .fr .ga .gb .gd .ge .gf .gg .gh .gi .gl .gm .gn .gov .gp .gq .gr .gs .gt .gu .gw .gy .hk .hm .hn .hr .ht .hu .id .ie .il .im .in .info .int .io .iq .ir .is .it .je .jm .jo .jobs .jp .ke .kg .kh .ki .km .kn .kp .kr .kw .ky .kz .la .lb .lc .li .lk .lr .ls .lt .lu .lv .ly .ma .mc .md .me .mg .mh .mil .mk .ml .mm .mn .mo .mobi .mp .mq .mr .ms .mt .mu .museum .mv .mw .mx .my .mz .na .name .nc .ne .net .nf .ng .ni .nl .no .np .nr .nu .nz .om .org .pa .pe .pf .pg .ph .pk .pl .pm .pn .pr .pro .ps .pt .pw .py .qa .re .ro .rs .ru .rw .sa .sb .sc .sd .se .sg .sh .si .sj .sk .sl .sm .sn .so .sr .st .su .sv .sy .sz .tc .td .tel .tf .tg .th .tj .tk .tl .tm .tn .to .tp .tr .travel .tt .tv .tw .tz .ua .ug .uk .us .uy .uz .va .vc .ve .vg .vi .vn .vu .wf .ws .xn--0zwm56d .xn--11b5bs3a9aj6g .xn--3e0b707e .xn--45brj9c .xn--80akhbyknj4f .xn--90a3ac .xn--9t4b11yi5a .xn--clchc0ea0b2g2a9gcd .xn--deba0ad .xn--fiqs8s .xn--fiqz9s .xn--fpcrj9c3d .xn--fzc2c9e2c .xn--g6w251d .xn--gecrj9c .xn--h2brj9c .xn--hgbk6aj7f53bba .xn--hlcj6aya9esc7a .xn--j6w193g .xn--jxalpdlp .xn--kgbechtv .xn--kprw13d .xn--kpry57d .xn--lgbbat1ad8j .xn--mgbaam7a8h .xn--mgbayh7gpa .xn--mgbbh1a71e .xn--mgbc0a9azcg .xn--mgberp4a5d4ar .xn--o3cw4h .xn--ogbpf8fl .xn--p1ai .xn--pgbs0dh .xn--s9brj9c .xn--wgbh1c .xn--wgbl6a .xn--xkc2al3hye2a .xn--xkc2dl3a5ee0h .xn--yfro4i67o .xn--ygbi2ammx .xn--zckzah .xxx .ye .yt .za .zm .zw"), true);
	
	/**
	 *  Transforms plain text into valid HTML, escaping special characters and
	 *  turning URLs into links.
	 */
	function htmlEscapeAndLinkUrls($text)
	{
		global $rexUrlLinker, $validTlds;
	
		$html = '';
	
		$position = 0;
		while (preg_match($rexUrlLinker, $text, $match, PREG_OFFSET_CAPTURE, $position))
		{
			list($url, $urlPosition) = $match[0];
	
			// Add the text leading up to the URL.
			$html .= htmlspecialchars(substr($text, $position, $urlPosition - $position));
	
			$protocol    = $match[1][0];
			$username    = $match[2][0];
			$password    = $match[3][0];
			$domain      = $match[4][0];
			$afterDomain = $match[5][0]; // everything following the domain
			$port        = $match[6][0];
			$path        = $match[7][0];
	
			// Check that the TLD is valid or that $domain is an IP address.
			$tld = strtolower(strrchr($domain, '.'));
			if (preg_match('{^\.[0-9]{1,3}$}', $tld) || isset($validTlds[$tld]))
			{
				// Do not permit implicit protocol if a password is specified, as
				// this causes too many errors (e.g. "my email:foo@example.org").
				if (!$protocol && $password)
				{
					$html .= htmlspecialchars($username);
					
					// Continue text parsing at the ':' following the "username".
					$position = $urlPosition + strlen($username);
					continue;
				}
				
				if (!$protocol && $username && !$password && !$afterDomain)
				{
					// Looks like an email address.
					$completeUrl = "mailto:$url";
					$linkText = $url;
				}
				else
				{
					// Prepend http:// if no protocol specified
					$completeUrl = $protocol ? $url : "http://$url";
					$linkText = "$domain$port$path";
				}
				
				$linkHtml = '<a href="' . htmlspecialchars($completeUrl) . '" target="_blank">'
					. htmlspecialchars($linkText)
					. '</a>';
	
				// Cheap e-mail obfuscation to trick the dumbest mail harvesters.
				$linkHtml = str_replace('@', '&#64;', $linkHtml);
				
				// Add the hyperlink.
				$html .= $linkHtml;
			}
			else
			{
				// Not a valid URL.
				$html .= htmlspecialchars($url);
			}
	
			// Continue text parsing from after the URL.
			$position = $urlPosition + strlen($url);
		}
	
		// Add the remainder of the text.
		$html .= htmlspecialchars(substr($text, $position));
		return $html;
	}
	
	
	
	/*
		Template for comments and pingbacks.
	*/
	function pica_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' : ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div id="comment-<?php comment_ID(); ?>">
                        <div class="comment-author">
                            <div class="comment-author-left-column">
								<?php echo get_avatar( $comment, 48 ); ?>
                            </div>
                            
    						<div class="comment-author-right-column">                        
	                            <strong><a href="<?php echo comment_author_url() ?>" target="_blank" title="Website of <?php echo get_comment_author() ?>"><?php echo get_comment_author() ?></a></strong>
                            </div>
                            
                            
                            <br />
							<?php echo get_comment_date() ?>
							<br />
							<?php echo get_comment_time() ?>
                            
                            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">#</a>
                        </div><!-- .comment-author .vcard -->
                        
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'pica' ); ?></em>
                            <br />
                        <?php endif; ?>
                
                        
                        <div class="comment-body"><?php comment_text(); ?></div>
                
                    </div><!-- #comment-##  -->
                <!--</li>-->
		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
            <li class="post pingback">
                <p><?php _e( 'Pingback:', 'pica' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'pica' ), ' ' ); ?></p>
            <!--</li>-->
		
		<?php
			break;
		endswitch;
		
	}//End function pica_comment
	
	
?>