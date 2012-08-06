<?php
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
?>