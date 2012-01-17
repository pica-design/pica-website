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


			<section class="content-gallery">
				<div class="gallery">
                	<?php if (isset($post->post_content)) : ?>
                	<figure class="gallery-item large text-slide" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>; color: #<?php echo get_post_meta($post->ID, 'work_text_color', true) ?>;">
						<div><?php echo $post->post_content ?></div>
                    </figure><!--end .intro-slide-->
                    <?php endif ?>
					<?php //Iterate through each attachment in this post's gallery ?>
					<?php foreach ($gallery->attachments as $attachment) : ?>
                    <figure class="gallery-item large image-slide">
                        <img src="<?php echo $attachment['guid'] ?>" alt="<?php echo $attachment['post_title'] ?>" />
                    </figure>
					<?php endforeach ?>
				</div><!-- end .gallery -->
                <div class="gallery-nav">
                	<a class="gallery-prev" href="#" title="Previous"></a> 
                    <a class="gallery-next" href="#" title="Next"></a>
				</div><!-- end .gallery-nav -->
			</div><!-- end .content-gallery -->	
<?php 
	//Include our theme footer.php
	get_footer() 
?>