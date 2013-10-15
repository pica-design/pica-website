<?php
	/*********************************
	SHORTCODES
	*********************************/	
	add_shortcode('employee-bios', 'employee_bio_shortcode');
	function employee_bio_shortcode () {
		global $post;

		if (count($post->attachments) > 1) :
			$html_str  = "<div class='clear'></div>"; 
			$html_str .= "<div class='about-employee-profiles'>\n";
			foreach ($post->attachments as $attachment) :
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

?>