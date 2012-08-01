<?php
	//Grab the page seo settings
	$metadesc = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
	$metakeywords = get_post_meta($post->ID, '_yoast_wpseo_metakeywords', true);
?>
<!DOCTYPE HTML>
<html>
    <head>
    	<!--
             ____                            ____                                          
            /\  _`\   __                    /\  _`\                  __                    
            \ \ \L\ \/\_\    ___     __     \ \ \/\ \     __    ____/\_\     __     ___    
             \ \ ,__/\/\ \  /'___\ /'__`\    \ \ \ \ \  /'__`\ /',__\/\ \  /'_ `\ /' _ `\  
              \ \ \/  \ \ \/\ \__//\ \L\.\_   \ \ \_\ \/\  __//\__, `\ \ \/\ \L\ \/\ \/\ \ 
               \ \_\   \ \_\ \____\ \__/.\_\   \ \____/\ \____\/\____/\ \_\ \____ \ \_\ \_\
                \/_/    \/_/\/____/\/__/\/_/    \/___/  \/____/\/___/  \/_/\/___L\ \/_/\/_/
                                                                             /\____/       
                                                                             \_/__/
                                                                                                                                                         
            Graphic Design & Marketing | www.picadesign.com
        -->
        <meta charset="UTF-8">
        <meta name="robots" content="noindex" />
        <meta name="author" content="Pica Design, LLC." />
        <meta name="copyright" content="Pica Design, LLC." />
        <meta name="geo.region" content="US-ME" />
        <meta name="geo.placename" content="Belfast" />
        <meta name="geo.position" content="44.42537,-69.007053" />
        <meta name="ICBM" content="44.42537,-69.007053" />
        <meta name="viewport" content="width=device-width" />
        
        <title><?php wp_title() ?></title>
        <?php if(!empty($metadesc)) : ?><meta name="description" content="<?php echo $metadesc ?>" /><?php endif ?>

        <?php if(!empty($metakeywords)) : ?><meta name="keywords" content="<?php echo $metakeywords ?>" /><?php endif ?>
        
        <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory');?>/style.css" />
        
        <!-- hide the browser's status bar on startup -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- color the browser's status bar -->
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <!-- image to display while the mobile web app is loading -->
        <link rel="apple-touch-startup-image" href="<?php bloginfo('template_directory');?>/images/icons/pica-avatar-57px.png" />
        <!-- For iOS and older Androids -->
        <link rel="apple-touch-icon" href="<?php bloginfo('template_directory');?>/images/icons/pica-avatar-57px.png" />
        <!-- For Newer Androids -->
        <link rel="shortcut icon" href="<?php echo get_bloginfo('template_directory');?>/images/pica-avatar-favicon.jpg" />
        <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory');?>/images/icons/pica-avatar-57px.png"/>
        <!-- For iPhone 4+ -->
		<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory');?>/images/icons/pica-avatar-114px.png" />

		<script type="text/javascript">	
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-4265805-2']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
    </head>
    
    <body>
    	<section id="website-wrapper">
        	<div id="masthead">
            	<div class="site-slogan"><h1><a href="<?php bloginfo('url') ?>" title="Pica Website Home">Pica Design + Marketing</a></h1></div>
            </div>