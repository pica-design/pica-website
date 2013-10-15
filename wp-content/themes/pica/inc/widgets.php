<?php
	/******************************************************
	DISPLAY SIMILAR POSTS WIDGET - Display posts similar to the current post type being viewed 
	******************************************************/
	class Similar_Posts_Widget extends WP_Widget {
		//Widget constructor	
		function __construct() {
			$widget_ops = array('classname' => 'similar_posts_widget', 'description' => 'Display posts similar to the current post type being viewed' );
			$this->WP_Widget('similar_psots_widget', 'Similar Posts', $widget_ops);
		}
		//Widget output
		function widget($args, $instance) {
			global $post, $wp_query; 
			
			//Grab the stored widget event start
			extract($args, EXTR_SKIP);
			$post_count = empty($instance['post_count']) ? 3 : apply_filters('widget_post_count', $instance['post_count']);
			
			?>
            <div class="widget similar-blog-posts">
            	<?php
					$old_query = $wp_query;
					$random_post_args = array(
						'posts_per_page' 	=> $post_count,
						'orderby' 			=> 'rand',
						'post_type' 		=> 'post',
						'post__not_in' 		=> array($post->ID)
					);
					$random_posts = new WP_Query($random_post_args);

					//print_r($random_posts->posts);

					while($random_posts->have_posts()) : $random_posts->the_post() ;
							//Try to grab the page 'post thumbnail' if there is one
							$featured_post_thumbnail_id = get_post_thumbnail_id($post->ID);
							
							//If a post thumbnail was found anywhere in the vertical page tree go ahead and show it
							if ($featured_post_thumbnail_id) :
								$featured_post_thumbnail_source = wp_get_attachment_image_src($featured_post_thumbnail_id,'blogroll', true);
								?>
                                	<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
                                        <img class="row" src="<?php echo $featured_post_thumbnail_source[0] ?>" alt="<?php echo $post->post_title ?> Banner Image" />
                                        <h3><?php the_title() ?></h3>
                                    </a>
									<br />
								<?php
							endif;		
					endwhile;
					
					wp_reset_query();
					$wp_query = $old_query;
				?>
            </div>
            <?php
		}
		//Save widget options	
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance = $old_instance;
			$instance['post_count'] = strip_tags($new_instance['post_count']);
			return $instance;
		}
		function form($instance) {
			//Output admin widget options form
			$instance = wp_parse_args( (array) $instance, array('post_count') );
			$post_count = strip_tags($instance['post_count']);
			
			?>
            <p>
                <label for="<?php echo $this->get_field_id('post_count'); ?>">Number of Posts:
                    <select class="widefat" id="widget-post-count" name="<?php echo $this->get_field_name('post_count'); ?>">
                        <option value="1" <?php selected(esc_attr($post_count), 1) ?>>1</option>
                        <option value="2" <?php selected(esc_attr($post_count), 2) ?>>2</option>
                        <option value="3" <?php selected(esc_attr($post_count), 3) ?>>3</option>
                        <option value="4" <?php selected(esc_attr($post_count), 4) ?>>4</option>
                        <option value="5" <?php selected(esc_attr($post_count), 5) ?>>5</option>
                        <option value="6" <?php selected(esc_attr($post_count), 6) ?>>6</option>
                    </select>
                </label>
            </p>
            <?php
		}
	}//END Similar_Posts_Widget

	//Register Similar_Posts_Widget for use
	register_widget('Similar_Posts_Widget');
?>