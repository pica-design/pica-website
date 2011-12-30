<?php 
	get_header();

	//Select our gallery
	global $siteUrl;
	$gallery = getGallery(1);
?>
                   <div id="contentwrapper">
                    	<h1>work</h1>
                        <hr>	
                        <br />
                        <div id="workwrapper">
							<?php 
                                $loop = new WP_Query( array( 'post_type' => 'work') );
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    //the_title();
                                    //the_content();
                                    echo "<a href='";
                                    echo get_post_permalink();
                                    echo "'>";
                                    echo the_post_thumbnail();
                                    echo "</a>";
                                endwhile;
                            ?>
                        </div><!--end workwrapper-->
                           
                    </div><!--end contentwrapper--> 
<?php get_footer(); ?>