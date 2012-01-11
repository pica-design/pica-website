<?php
get_header(); ?>



<div class="page-title">
                <div class="maintitle">
                    <h1><a href="<?php bloginfo('url') ?>/work" title="Back to our work"><?php echo get_post_type() ?></a></h1>
                    <figure class="dot-seperator"></figure>
                    <h2> <?php echo $post->post_title ?></h2>
                </div>    
                <div class="return">
                    <a href="<?php bloginfo('url') ?>/blog" title="Back to blog"><img src="<?php  bloginfo('template_directory')?>/images/back-arrow.png" /> back to blog </a>
                </div>                
            </div>


            <!-- Start the Loop. -->
             <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>           
             
             <!-- Display the Post's Content in a div box. -->
                 <div class="blog-post">
				 	<strong><?php the_time('F jS, Y') ?></strong>
                    <br /><br />
                    <?php the_content(); ?>
                 </div>
             <?php endwhile; else: ?>
             	<p>Sorry, no posts matched your criteria.</p>
             <?php endif; ?>
                

<?php get_footer(); ?>