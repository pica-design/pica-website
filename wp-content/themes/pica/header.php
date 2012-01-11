<?php 
	//Determine which page is being loaded and append a class to our html <body> tag for css styling
	if (is_page('home') || is_page('contact')) : 
		$body_class = ' class="content-bleed"' ; 
	else: 
		$body_class = "" ; 
	endif ; 
	
	//We love our quotes
	$quotes = array ('Trust your developer', 'I shot the serif', 'make pixels not war', 'meeeow');
	$random_quote_key = rand(0, (count($quotes) - 1)) ;
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>Pica Design, LLC</title>
        <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory');?>/style.css" />
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    </head>
    <body<?php echo $body_class ?>>
	<section id="site-wrapper">
            <section id="site-controller">
                <a href="#" class="site-controller-trigger inactive" title="Display Page Menus"></a>
                <a href="<?php bloginfo('url') ?>" class="pica-mark inactive" title="<?php echo $quotes[$random_quote_key] ?>"></a>
                <div class="picamarketing">
                	<h4 class="text-color-black">pica</h4>
                    <h4 class="text-color-white">design</h4>
                    <h4 class="text-color-black">+</h4>
                    <h4 class="text-color-white">marketing</h4>
                </div>
                <nav>
                    <ul><?php 
                            //Grab our nav menu items
                            $menu_items = wp_get_nav_menu_items('Primary Navigation');
                            foreach ($menu_items as $menu_item) :
                                if (is_page($menu_item->object_id) || ($post->post_type == 'work' && $menu_item->title == "work")) :
                                    $active = " class='active'";
                                else :
                                    $active = "";
                                endif; ?>
    
                		<li<?php echo $active ?>> <a href="<?php echo $menu_item->url ?>" title="<?php echo $menu_item->title ?>"><span><?php echo $menu_item->title ?></span></a></li><?php endforeach; ?>
                        
                    </ul>
                </nav>
            </section><?php //End navigation bar // ?>
            
	    <section id="content-wrapper">