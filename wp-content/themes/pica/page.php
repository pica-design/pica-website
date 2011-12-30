<?php get_header(); ?>
	
    <?php if (is_page('home')) : $body_class = " class='home'"; else: $body_class = "" ; endif ; ?>
    <section id="content-wrapper"<?php echo $body_class ?>>
            
        <div id="page-title">
            <h1><?php echo $post->post_title ?></h1>
        </div>
    
    </section>

<?php get_footer(); ?>
