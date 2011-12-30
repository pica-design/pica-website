<?php 
	//Include our theme header.php 
	get_header() ;
	//Grab the gallery attached to this page
	$gallery = getGallery(get_post_meta($post->ID, 'gallery', true)) ;
?>
				
        <?php if (is_page('home')) : $body_class = " class='home'"; else: $body_class = "" ; endif ; ?>
        <section id="content-wrapper"<?php echo $body_class ?>>
            
        <div id="page-title">
            <h1><?php echo get_post_type()?></h1>
            	<img src="<?php echo get_bloginfo('template_directory'); ?>/images/dot-seperator.png" class="titleimage"/>
            <h1 class="subtitle"> <?php echo $post->post_title ?></h1>
        </div>
        	
		
					<?php //while ( have_posts() ) : the_content();  ?>
					
			<div id="workwrapper">
				<div class="workgallery">
                	<div id="textslide">
						<?php 
                            //$args = array( 'post_type' => 'sponsor', 'posts_per_page' => 10 );
                                //$loop = new WP_Query( $args );
                                while ( have_posts() ) : the_post();
                                    //the_title();
                                    the_content();
                                endwhile;
                        ?>
                    </div><!--end textslide-->
					<?php 
                        foreach ($gallery['images'] as $image) : 
                            echo "<img src='";
                            echo get_bloginfo('url');
                            echo "/";
                            echo $gallery['path'];
                            echo "/";
                            echo $image['filename'];
                            echo "'";
                            echo "/>";
                        endforeach;
                    ?>
				</div><!--end work gallery-->
                <div id="gallnav">
                	<a id="prev" href="#"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/slide-arrow-left-inactive.png" /></a> 
                    <a id="next" href="#"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/slide-arrow-right-inactive.png" /></a>
				</div><!--end gallnav-->
			</div><!--end workwrapper-->
       
       
       </section>
					
<?php 
	//Include our theme footer.php
	get_footer() 
?>