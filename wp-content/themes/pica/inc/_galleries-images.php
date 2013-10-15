<?php
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
	add_image_size( 'homepage', 2560, 500, true );
	add_image_size( 'brandnew_callout', 329, 266, true);
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
		public function __construct ($post_id, $orderby = 'menu_order', $order = 'ASC') {
			//Make the current post global - !!!! This should be passed in, or at least the option to do so !!!!
			if (empty($post_id)) : global $post; $post_id = $post->ID ; endif;
			
			$this->attachments = new WP_Query( 
				array (
					'post_parent' => $post_id, 
					'post_status' => 'inherit', 
					'post_type' => 'attachment',
					'order' => $order, 
					'orderby' => $orderby,
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

			//Make the attachments object a little cleaner by only using the data we want, the posts.
			//This also ensures our ->attachments variable holds and array (so we can easily display a random attachment on the website homepage
			$this->attachments = $this->attachments->posts;

			////Merge some additional attachment data into our main object
			foreach ($this->attachments as &$attachment) :
				//By doing both str_replace's below we can change the url when the website is running on the live server or local dev
				//Remove www. if we're running on the live website
				$attachment->guid = str_replace('www.', '', $attachment->guid);
				//Add the images. subdomain before the domain
				$attachment->guid = str_replace('http://', 'http://images.', $attachment->guid);

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