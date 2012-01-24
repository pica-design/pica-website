            </section><?php // END .content-wrapper // ?>
            
            <footer>
            	<br />
            	<div class="color-swatch bg-color-gray"></div>
                <span>
                	&nbsp; &copy; <?php echo date('Y', time()) ?> Pica Design, LLC &bull; 
                    <a href="<?php bloginfo('url') ?>/careers" title="Be a Pica">Careers</a>
                    &bull; 
                    <a href="<?php bloginfo('rss2_url') ?>" title="Stay tuned in">RSS</a>
                    &bull; 
                    <a href="<?php bloginfo('url') ?>/downloads" title="Freebies!">Downloads</a>
                </span>
            </footer>
        </section><?php // END .site-wrapper // ?>
        
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.latest.js"></script>
   	<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/scripts/jquery.fittext.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory') ?>/scripts/jquery.tweet.js" charset="utf-8"></script>
    <script type="text/javascript">
		var post_type = "<?php echo $post->post_type ?>"
		var page_title = "<?php echo $post->post_title ?>"
		var single = <?php echo is_single() ? 1 : 0 ?>
	</script>
	<script type="text/javascript" src="<?php bloginfo('template_directory') ?>/scripts/site-controller.js"></script>
    </body>
</html>