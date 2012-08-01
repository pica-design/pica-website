<?php 
	get_header();
	
	$gallery = new Post_Gallery ;
?>
		
        <section class="sub-content-wrapper">
        
            <!-- Display page header --> 
            <div class="page-masthead">
            	<div class="page-masthead-inner">
                    <!-- Display page title and sub title ex 'work . featured' -->
                    <div class="page-title">
                        <h2>clients</h2>
                    </div>      
            	</div>
            </div>
        </section><!-- end .sub-content-wrapper -->
            
        <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
            
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
<?php get_footer(); ?>