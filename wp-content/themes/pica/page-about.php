<?php get_header() ?>
        <section class="sub-content-wrapper about">
            <div class="about-wrapper">
				<article class="about-content">
				<?php if ( have_posts() ) : ?> 
                    <?php while ( have_posts() ) : the_post(); ?>    
						<?php the_content() ?>
                    <?php endwhile ?>
                <?php endif; ?>
                <table>
                    <tbody>
                        <tr>
							<?php
                            /* Grab the top-level (parent) terms in the pica_work_type taxonomy */
                            $work_parent_categories = get_terms('pica_work_type', array('exclude' => 8, 'hide_empty' => 0, 'parent' => 0, 'orderby' => 'term_order', 'order' => 'ASC'));

                            foreach ($work_parent_categories as $work_parent_category) : ?>
                                <td valign="top">
                                    <strong><a href="<?php bloginfo('url') ?>/work-categories/<?php echo $work_parent_category->slug ?>" title="View our <?php echo $work_parent_category->name ?> work"><?php echo $work_parent_category->name ?></a></strong>
                                    <br />
                                    <?php
                                        
                                        $work_child_categories = get_terms('pica_work_type', array('parent' => $work_parent_category->term_id, 'hide_empty' => 0, 'orderby' => 'term_order', 'order' => 'ASC')) ;
                                        foreach ($work_child_categories as $work_child_category) :					
                                            echo $work_child_category->name . "<br />";
                                        endforeach ;
                                    ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    </tbody>
                </table>
                </article>
			</div>   
		</section><!-- end .sub-content-wrapper -->
<?php get_footer(); ?>