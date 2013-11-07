<?php 
	get_header();

    global $cdn ;
?>

        <section class="sub-content-wrapper">
            <!-- Display page header --> 
            <div class="page-masthead">
            	<div class="page-masthead-inner">
                    <!-- Display page title and sub title ex 'work . featured' -->
                    <div class="page-title">
                        <h2>This page does not exist.</h2>
                    </div>      
            	</div>
            </div>
        </section><!-- end .sub-content-wrapper -->
        <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
        <section class="sub-content-wrapper">
            <img src="<?php echo $cdn->template_images_url ?>content/american-pika.jpg" alt="American Pika" />
            <br />
            The pika (PY-ka) is a small mammal, with short limbs, rounded ears, and short tail. 
            <br /><br />
            <strong>He is unafraid when faced with missing web pages.</strong>
		</section><!-- end .sub-content-wrapper -->
<?php get_footer(); ?>