<?php 
	//Make the global variables we need available
  global $cdn;

    //Determine which page is being loaded and append a class to our html <body> tag for css styling
	if (is_page('home')) : $body_class = ' class="content-bleed"' ; 
	else : $body_class = "" ; endif ; 
	
	//We love our quotes
	$quotes = array ('Trust your developer', 
                     'I shot the serif', 
                     'make pixels not war', 
                     'meeeow', 
                     'do or do not', 
                     'there is no try', 
                     'be the spoon', 
                     'be bold', 
                     'be different');
	$random_quote_key = rand(0, (count($quotes) - 1)) ; ?>
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
                                                                                                                                                         
            Design + Marketing | www.picadesign.com
        -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <meta name="google-site-verification" content="wF-kxO_aFfkTppia2uV5ZWr-p4YENIKKW6ztxF6QTC4" />
        <meta name="msvalidate.01" content="5EEAF8559BB30800CEB7EB72D4B159B9" />
        <title><?php wp_title() ?></title>
        <link rel="stylesheet" href="<?php echo $cdn->template_styles_url ?>style.css" />
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!-- Add our favicon -->
        <link rel="shortcut icon" href="<?php echo $cdn->template_images_url ?>icons/pica-avatar-favicon.png" />
        <!-- Icon for iPads -->
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $cdn->template_images_url ?>icons/pica-avatar-72px.png" />
        <!-- Associate our RSS feed with the website so browsers can display an RSS Icon for the website -->
        <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url')?>" />
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
      <?php wp_head() ?>
    </head>
    <body<?php echo $body_class ?>>
	<section id="site-wrapper"><?php if (class_exists('Device_Theme_Switcher')) : Device_Theme_Switcher::generate_link_back_to_mobile(); endif; ?>
        
            <section id="site-controller">
                <a href="#" class="site-controller-trigger inactive" title="Open Page Menu"></a>
                <a href="<?php bloginfo('url') ?>" class="pica-mark" title="<?php echo $quotes[$random_quote_key] ?>"></a>
                <div class="site-slogan"><h1 class="text-color-black">Pica Design + Marketing</h1></div>
                <nav>
                    <ul><?php 
                            //Grab our nav menu items
                            $menu_items = wp_get_nav_menu_items('Primary Navigation');
                            foreach ($menu_items as $menu_item) :
                                if (is_page($menu_item->object_id) || ($post->post_type == 'pica_work' && $menu_item->title == "work")) :
                                    $active = " class='active'";
                                else :
                                    $active = "";
                                endif; ?>

                        <li<?php echo $active ?>><a href="<?php echo $menu_item->url ?>" title="<?php echo $menu_item->title ?>"><span><?php echo $menu_item->title ?></span></a></li><?php endforeach; ?>
                        
                    </ul>
                </nav>
            </section>
            <section id="content-wrapper">