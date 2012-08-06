<?php 
	//Include our theme header.php 
	get_header() ;

	//Gather this posts gallery items
	$gallery = new Post_Gallery($post->ID) ;
	
	//Grab our testimonial if there is one
	$work_testimonial = get_post_meta($post->ID, '_work_testimonial', true);
?>
		<section class="sub-content-wrapper">
            <div class="page-masthead single-work">
            	<div class="page-masthead-inner">
                    <div class="page-title">
                        <h1><a href="<?php bloginfo('url') ?>/work-categories/featured/" title="Back to our featured work">work</a></h1>
                        <figure class="dot-seperator"><div class="dot-image"></div></figure>
                        <h2><?php echo $post->post_title ?></h2>
                    </div>    
                    
                    <div class="page-controller">
                    	<?php if ($work_testimonial != "") : ?>
                        <div id="work-testimonial">
                        	<div id="work-testimonial-trigger"><a href="#" title="View <?php echo $post->post_title ?> Testimonial" class="link-fill-container">+</a></div>
                            <div id="work-testimonial-copy">
                            	<?php
									echo $work_testimonial;
								?>
                            </div>
                        </div>
                       	<?php endif ?>
                        
                        <?php if(!empty($_SESSION)) : ?>
						<!--
                        <div class="back-to">
                        	<figure class="back-arrow"></figure>
                            <a href="<?php echo get_bloginfo('url') . "/work-categories/{$_SESSION['pica_work_category']->slug}" ?>" title="Back to <?php echo $_SESSION['pica_work_category']->name ?>" class="back-text">back to <?php echo strtolower($_SESSION['pica_work_category']->name) ?></a>
                        </div>
                        -->
                        <?php endif ?>
                        
                    </div>                
                </div>
            </div>
        </section><!-- end .sub-content-wrapper -->
            
        <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
            
        <section class="sub-content-wrapper single-work">
			<section class="content-gallery">
				<div class="gallery">
					<?php if (isset($post->post_content)) : ?>
                	<article class="gallery-item large text-slide" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>; color: #<?php echo get_post_meta($post->ID, 'work_text_color', true) ?>;">
						<div><?php echo $post->post_content ?></div>
                    </article><!--end .intro-slide-->
                    <?php endif ?>
					<?php 
						//Iterate through each attachment in this post's gallery and display them
						if (count($gallery->attachments) > 0) :
							foreach ($gallery->attachments as $attachment) : 
								?>
								<figure class="gallery-item large image-slide">
									<img src="<?php echo $attachment->guid ?>" alt="<?php echo $attachment->post_title ?>" />
								</figure>
								<?php 
							endforeach; 
						endif;
					?>
				</div><!-- end .gallery -->
                <div class="gallery-nav">
                	<a class="gallery-prev" href="#" title="Previous"></a> 
                    <a class="gallery-next" href="#" title="Next"></a>
				</div><!-- end .gallery-nav -->
			</section><!-- end .content-gallery -->	
       </section><!-- end .sub-content-wrapper -->
		
<?php 
	//Include our theme footer.php
	get_footer() 
?>