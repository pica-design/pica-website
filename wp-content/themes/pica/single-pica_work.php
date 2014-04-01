<?php 
	//Include our theme header.php 
	get_header() ;

    the_post();

	//Gather this posts gallery items
	//$gallery = new Post_Gallery($post->ID) ;
	
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
			
					<?php 
						//Iterate through each attachment in this post's gallery and display them
						if (count($post->attachments) > 0) :
							foreach ($post->attachments as $attachment) : 
								?>
								<figure class="brandnew-attachment">
                        <img class="attachment-image" src="<?php echo $attachment->guid ?>" alt="<?php echo $attachment->post_title ?>" />
                        <figcaption class="attachment-description">
                            <?php if ($key == 0) : ?>
                            <h1><strong><?php echo $post->post_title ?></strong></h1>
                            <?php endif ?>
                            <strong><?php echo $attachment->post_title ?></strong>
                            <p><?php echo $attachment->post_content ?></p>
                        </figcaption>
                        <div class="clear"></div>
                    </figure>
								<?php 
							endforeach; 
						endif;
					?>
				
       </section><!-- end .sub-content-wrapper -->
		
<?php 
	//Include our theme footer.php
	get_footer() 
?>