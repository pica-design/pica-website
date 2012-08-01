            </section><!-- .content-wrapper -->
            <footer>
            	<br />
            	<div class="pica-mark-small"></div>
                <div class="footer-copy">
                    <span>
                        &nbsp; &copy; <?php echo date('Y', time()) ?> Pica Design, LLC &bull; 
                        <a href="<?php bloginfo('url') ?>/blog" title="Visit the Pica Blog">Blog</a>
                        &bull; 
                        <a href="https://www.facebook.com/picadesign" title="Find us on Facebook" target="_blank">Facebook</a>
                        &bull; 
                        <a href="https://twitter.com/#!/picadesign" title="Follow us on Twitter" target="_blank">Twitter</a>
                        &bull; 
                        <a href="http://www.linkedin.com/company/pica-design-llc" title="See our business on LinkedIn" target="_blank">LinkedIn</a>
                        &bull;
                        <a href="<?php bloginfo('rss2_url') ?>" title="Follow our blog">RSS</a>
                    </span>
                 </div>
            </footer>
        </section><!-- .site-wrapper -->
        <figure class="back-to-top inactive">Back to top</figure>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    	<script src="http://malsup.github.com/jquery.cycle.all.js"></script>
    	<script type="text/javascript">
			var post_type = "<?php echo $post->post_type ?>"
			var page_title = "<?php echo $post->post_title ?>"
			var single = <?php echo is_single() ? 1 : 0 ?>
		
        </script>
		<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/scripts/jquery.pica.scripts.js"></script>
    </body>
</html>