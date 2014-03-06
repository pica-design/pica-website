<?php
	/*
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
	*/

	/*********************************************************
		Pica Design Theme Setup
	*********************************************************/
	//Load in our WordPress core overrides
	include('inc/overrides.php');
	//Load in our Post Types
	include('inc/post-types.php');
	//Load in our Post Attachments
	include('inc/post-attachments.php');
	//Load in our Post Attachments
	include('inc/menus.php');
	//Load in our Meta Boxes
	include('inc/meta-boxes.php');
	//Load in our Shortcodes
	include('inc/shortcodes.php');
	//Load in our Users
	include('inc/users.php');
	//Load in our Comments
	include('inc/comments.php');
	//Load in our Sidebars 
	include('inc/sidebars.php');
	//Load in our Widgets
	include('inc/widgets.php');
	//Load in our Twitter
	include('inc/twitter.php');

	//Theme Setup
	add_action( 'init', 'pica_theme_setup' );
	function pica_theme_setup() {
		//The theme namespace is used for menu of the operations below. 
		//The namespace NEEDS to mirror the name of the theme folder
		//And the primary js script file should also use this same namespace
		global $theme_namespace; $theme_namespace = 'pica';
		
		//Load our psuedo-cdn/subdomain url generation
		include('inc/cdn-url-generation.php');
		//Instantiate our CDN url class
		//This variable with be used throughout the theme to point to website assets
		global $cdn;
		$cdn = new CDN(1) ;		

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style('stylesheets/editor.css');	

		//Load the website styles and scripts 
		//include('inc/styles-and-scripts.php');
	}//end function pica_theme_setup
?>