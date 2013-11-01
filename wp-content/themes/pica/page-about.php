<?php get_header() ?>
        <section class="sub-content-wrapper about">
            <div class="about-wrapper">
				<article class="about-content">
				<?php if ( have_posts() ) : ?> 
                    <?php while ( have_posts() ) : the_post(); ?>    
						<?php the_content() ?>
                    <?php endwhile ?>
                <?php endif; ?>
                <div class="employees grid">
                    <?php $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => '',
                        'meta_key'     => '',
                        'meta_value'   => '',
                        'meta_compare' => '',
                        'meta_query'   => array(),
                        'include'      => array(),
                        'exclude'      => array(),
                        'orderby'      => 'login',
                        'order'        => 'ASC',
                        'offset'       => '',
                        'search'       => '',
                        'number'       => '',
                        'count_total'  => false,
                        'fields'       => 'all',
                        'who'          => ''
                     ); ?>

                     <?php $employees = get_users( $args ); ?> 
                     <?php foreach ($employees as $employee) : ?>
                            <?php $user_meta = get_user_meta($employee->ID); ?>
                            <div class="employee">
                                <div class="user-image">
                                    
                                </div>
                                <p><?php //print_r($user_meta['first_name')]?></p>
                            </div>

                     <?php endforeach; ?>
                
                </div>
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