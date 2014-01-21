<?php 
	get_header(); 
	the_post();
?>
	
	<section class="sub-content-wrapper">  
        <div class="page-masthead">
            <h1><?php the_title() ?></h1>
        </div>
    </section>
    <section class="sub-content-wrapper">
    	<?php the_content() ?>
    </section>


<?php get_footer(); ?>
