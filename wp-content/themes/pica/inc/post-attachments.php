<?php

	//http://wordpress.stackexchange.com/questions/22753/earliest-hook-to-reliably-get-post-posts

	/***********************************************************
		
		WORDPRESS GALLERY CUSTOMIZATIONS
		
	***********************************************************/

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
	add_filter("attachment_fields_to_edit", array('Post_Attachments', 'edit_attachment_fields'), 10, 2);
	//Save our custom attachment fields in the post editor
	add_filter("attachment_fields_to_save", array('Post_Attachments', 'save_attachment_fields'), 10, 2);
	//Save our custom attachment fields in the compat overlay editor (in post editing)
	add_action('edit_attachment', array('Post_Attachments', 'ajax_save_attachment_fields'));
	//Append the attachments to $post
	add_action('the_post', array('Post_Attachments', 'add_attachments_to_post'));

	//Maybe we can tap into something like pre_get_posts to indicate the post attachment arguments
	//OR we just return the attachments and progmatically apply arguments? Ew..

	//The Post Gallery class issues objects containing a post's attachment 'gallery' and returns an array of that data
	class Post_Attachments {
		public static function add_attachments_to_post ($post) {
			//Load in any post attachments we'll need (images, documents, ..)
            $post->attachments = Post_Attachments::fetch($post->ID, 'rand', 'ASC');

            return array($post);
		}

		/* Adding custom attachment fields */
		static function edit_attachment_fields ($form_fields, $post) {
			$form_fields["attachment-copyright"] = array(
				"label" => __("Copyright"),
				"input" => "text", // this is default if "input" is omitted
				"value" => get_post_meta($post->ID, "_attachment-copyright", true),
				"helps" => __("Set your copyright information.")
			);
			$form_fields["attachment-exclude-from-gallery"] = array(
				"label" => __("Exclude"),
				"input" => "html",
				"html"  => "<div style='height:10px;'>&nbsp;</div><input type='checkbox' name='attachments[" . $post->ID . "][attachment-exclude-from-gallery]' " . checked( get_post_meta($post->ID, "_attachment-exclude-from-gallery", true), 'on', 0 ) . " /> <br />" . __("<em>Don't show this attachment in the gallery.</em>")
			);
		   return $form_fields;
		}//edit_attachment_fields

		//Save attachment fields in the attachment post editor
		static function save_attachment_fields ($post, $attachment) {
			update_post_meta($post['ID'], '_attachment-copyright', $post['attachments'][$post['ID']]['attachment-copyright']);
			if (isset($post['attachments'][$post['ID']]['attachment-exclude-from-gallery'])) : 
				update_post_meta($post['ID'], '_attachment-exclude-from-gallery', $post['attachments'][$post['ID']]['attachment-exclude-from-gallery']);
			else :
				delete_post_meta($post['ID'], '_attachment-exclude-from-gallery');
			endif;
			return $post;
		}//update_post_attachment_new_fields

		//Save attachment fields in the overlay compat editor
		function ajax_save_attachment_fields () {
			$post_id = $_POST['id'];
			update_post_meta($post_id, '_attachment-copyright', $_POST['attachments'][$post_id]['attachment-copyright']);
			if (isset($_POST['attachments'][$post_id]['attachment-exclude-from-gallery'])) : 
				update_post_meta($post_id, '_attachment-exclude-from-gallery', $_POST['attachments'][$post_id]['attachment-exclude-from-gallery']);
			else :
				delete_post_meta($post_id, '_attachment-exclude-from-gallery');
			endif;
			clean_post_cache($post_id);
		}

		/* Fetch Post attachments */
		public static function fetch ($post_id, $orderby = 'menu_order', $order = 'ASC') {
			global $post, $cdn;

			//Select the attachments requested
			$attachments = new WP_Query( 
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
							'compare' => 'NOT EXISTS'
						)
					)
				), ARRAY_A
			);
			//Make the attachments object a little cleaner by only using the data we want, the posts.
			//This also ensures our ->attachments variable holds and array (so we can easily display a random attachment on the website homepage
			$attachments = $attachments->posts;
			////Merge some additional attachment data into our main object
			foreach ($attachments as &$attachment) :
				//By doing both str_replace's below we can change the url when the website is running on the live server or local dev
				
				//Remove www. if we're running on the live website
				$attachment->guid = str_replace('www.', '', $attachment->guid);
				//Remove the ht protocol 
				$attachment->guid = str_replace('http://', '', $attachment->guid);
				//Replace the site url with the protocolless cdn url
				$attachment->guid = str_replace($cdn->site_url, $cdn->images_url, $attachment->guid);

				//Grab the attachment's meta data
				$attachment->meta_data = get_post_custom($attachment->ID);
				//Some of our meta data needs to be unserialized for use to user it
				$attachment->meta_data['_wp_attachment_metadata'] = @unserialize($attachment->meta_data['_wp_attachment_metadata'][0]);
			endforeach;

			//Remove the array indecies (they do not help us)
			return array_values($attachments);
		}//fetch	
	}//Post_Attachments
?>