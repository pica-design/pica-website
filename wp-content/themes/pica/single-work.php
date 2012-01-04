<?php 
	//Include our theme header.php 
	get_header() ;

	//Gather this posts gallery items
	$gallery = new Post_Gallery ;
?>

            <div class="page-title">
                <div class="maintitle">
                    <h1><a href="<?php bloginfo('url') ?>/work" title="Back to our work"><?php echo get_post_type() ?></a></h1>
                    <figure class="dot-seperator"></figure>
                    <h2> <?php echo $post->post_title ?></h2>
                </div>    
                <div class="return">
                    <a href="<?php bloginfo('url') ?>/work" title="Back to gallery"><img src="<?php  bloginfo('template_directory')?>/images/back-arrow.png" /> back to gallery </a>
                </div>                
            </div>


			<div class="content-gallery">
				<div class="gallery">
                	<?php if (isset($post->post_content)) : ?>
                	<div class="gallery-description scalable-text" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>; color: #<?php echo get_post_meta($post->ID, 'work_text_color', true) ?>;">
						<?php echo $post->post_content ?>
                    </div><!--end .intro-slide-->
                    <?php endif ?>
					<?php 
						//get_post_custom('full','0','0','full',"$post->ID",'0','attachment-image','div','small-thumb'); 
						
						//Iterate through each attachment in this post's gallery
						foreach ($gallery->attachments as $attachment) :
							
							//print_r($attachment); 
							
							?>
							
                            <img src="<?php echo $attachment['guid'] ?>" alt="<?php echo $attachment['post_title'] ?>" height="650" width="1130"/>
							
							<?php
							
						endforeach;
					?>
				</div><!-- end gallery -->
                <div class="gallery-nav">
                	<a class="gallery-prev" href="#" title="Previous"></a> 
                    <a class="gallery-next" href="#" title="Next"></a>
				</div><!-- end .gallery-nav -->
			</div><!-- end .content-gallery -->	
<?php 
	//Include our theme footer.php
	get_footer() 
?>