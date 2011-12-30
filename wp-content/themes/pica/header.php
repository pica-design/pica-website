<!DOCTYPE HTML> 
<html>
    <head>    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>Pica Design, LLC</title>
        <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory');?>/style.css" />
        <style type="text/css">
			/*-------Navigation-------*/
			nav {
				background-color: #939598 ;
				width: 100% ;	
				min-height: 40px ;
				color: white ;
			}
				nav #nav-trigger-container {
					width: 72px ;
					height: 50px ; /* 72 - 22 (padding-top) = 50 */
					padding-top: 22px ;
				}
					nav #nav-trigger-container .nav-trigger {
						width: 24px ;
						height: 28px ;
						margin: 0px auto 0 auto ;
					}
						nav #nav-trigger-container .nav-trigger.inactive {
							background-image: url(<?php echo get_bloginfo('template_directory');?>/images/nav-trigger-inactive.png) ;
						}
						nav #nav-trigger-container .nav-trigger.active {
							background-image: url(<?php echo get_bloginfo('template_directory');?>/images/nav-trigger-active.png) ;						
						}
						
				nav #menu-primary-navigation {
					display: none ;
				}
					nav #menu-primary-navigation li {
					}
						nav #menu-primary-navigation li a {
	
						}
						nav #menu-primary-navigation li.current-menu-item a {
							backgrond-color: #58595B ;
						}
		</style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
        <nav>
        	<section id="nav-trigger-container">
	            <div class="nav-trigger inactive"></div>
            </section>
            <?php wp_nav_menu(array('theme_location' => 'Masthead', 'menu' => 'Primary Navigation', 'container' => '')); ?>
        </nav><!--end navigation bar-->
        
        <section id="wrapper">