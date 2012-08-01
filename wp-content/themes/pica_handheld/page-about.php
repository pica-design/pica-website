<?php 
	get_header();
	
	$gallery = new Post_Gallery($post->ID);
?>
	<div id="content-wrapper">  
		<section class="back-controller">
            <a href="<?php bloginfo('url') ?>" class="link-fill-container"><div class="back-arrow"></div><span>about</span></a>
        </section>  
        <section class="sub-content-wrapper about">
            <div class="about-wrapper">
				<article class="about-content">
				<?php if ( have_posts() ) : ?> 
                    <?php while ( have_posts() ) : the_post(); ?>    
						<?php the_content() ?>
                    <?php endwhile ?>
                <?php endif; ?>
                
                <?php
				
				/* Grab the top-level (parent) terms in the pica_work_type taxonomy */
				$work_parent_categories = get_terms('pica_work_type', array('exclude' => 8, 'hide_empty' => 0, 'parent' => 0, 'orderby' => 'term_order', 'order' => 'ASC'));

				foreach ($work_parent_categories as $work_parent_category) : ?>
					<br />
						<h1><a href="<?php bloginfo('url') ?>/work-categories/<?php echo $work_parent_category->slug ?>" title="View our <?php echo $work_parent_category->name ?> work"><?php echo $work_parent_category->name ?></a></h1>
                        
						
				<?php endforeach ?>
                </article>
			</div>   
		</section><!-- end .sub-content-wrapper -->
    </div>
<?php get_footer(); ?>