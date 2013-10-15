<?php get_header() ?>

   <section class="sub-content-wrapper blog-header">
        <div class="page-masthead">
            <div class="page-masthead-inner">
                <div class="page-title">
                    <h1><a href="<?php bloginfo('url') ?>/blog" title="View the full blog">Pica Blog</a></h1>
                    <?php if (is_category()) : ?>
                    	<figure class="dot-seperator"><div class="dot-image"></div></figure>
                        <h2><?php echo single_cat_title("",false) ?></h2>
					<?php endif ?>
                </div>    
            </div>
        </div>
    </section><!-- end .sub-content-wrapper -->

    <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
        
    <section class="sub-content-wrapper blog">
		<div class="blog-wrapper">
            <div class="blog-posts">
                <?php if (have_posts()) : ?> 
                    <?php while ( have_posts() ) : the_post(); ?>           
                        <div class="blog-post">
                        	<div class="blog-post-date">
                            	<span class="month"><?php the_time('M') ?></span>
                                <span class="year"><?php the_time('Y') ?></span>
                            </div>
                            <strong class="blog-post-title"><a href="<?php the_permalink() ?>" title="View the full <?php the_title() ?> article"><?php the_title() ?></a></strong>
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endwhile ?>
                <?php endif; ?>
                <div class="older-posts-link"><?php next_posts_link('Older Entries', 0); ?></div>
				<div class="newer-posts-link"><?php previous_posts_link('Newer Entries', 0); ?></div>
            </div>
            <div class="blog-sidebar">
                <ul><?php wp_list_categories(array('title_li' => '', 'show_count' => 1)) ?></ul>
            </div>
        </div>
    </section><!-- end .sub-content-wrapper -->
        
<?php get_footer(); ?>