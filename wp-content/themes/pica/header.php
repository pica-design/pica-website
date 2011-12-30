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
        <!-- Internet Explorer HTML5 enabling code: -->        
        <!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <style type="text/css">
                .clear {
                  zoom: 1;
                  display: block;
                }
            </style>
        <![endif]-->
        <?php wp_head() ?>
    </head>
   
    <body>
    	<section id="site-wrapper">
            <section id="site-controller">
                <div id="site-controller-trigger-container">
                    <div class="site-controller-trigger inactive"></div>
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
    
                <li<?php echo $active ?>><a href="<?php echo $menu_item->url ?>" title="<?php echo $menu_item->title ?>"><span><?php echo $menu_item->title ?></span></a></li><?php endforeach; ?>
                                
                    </ul>
                </nav>
            </section><!--end navigation bar-->