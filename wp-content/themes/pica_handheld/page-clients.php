<?php 
	get_header();
	
	$gallery = new Post_Gallery ;
?>
		<div id="content-wrapper">  
            <section class="back-controller">
                <a href="<?php bloginfo('url') ?>" class="link-fill-container"><div class="back-arrow"></div><span>clients</span></a>
            </section>
                
            <section class="sub-content-wrapper">
                <div class="client-grid">
                    <?php foreach ($gallery->attachments as $attachment) : ?>
                        <figure class="client">
                            <?php if (!empty($attachment->meta_data['_attachment-exlink'][0])) : ?>
                                <a href="<?php echo $attachment->meta_data['_attachment-exlink'][0] ?>" title="<?php echo $attachment->post_title ?>" target="_blank">
                            <?php endif ?>
                            
                            <?php if (!empty($attachment->meta_data['_wp_attachment_image_alt'][0])) : ?>
                                <a href="<?php echo $attachment->meta_data['_wp_attachment_image_alt'][0] ?>" title="<?php echo $attachment->post_title ?>">
                            <?php endif ?>
                            <img src="<?php echo $attachment->guid ?>" alt="<?php echo $attachment->post_title ?>" />
                            </a>
                        </figure>
                    <?php endforeach ?>
                </div><!-- .content-gallery grid -->      
            </section><!-- end .sub-content-wrapper -->
		</div>        
<?php get_footer(); ?>