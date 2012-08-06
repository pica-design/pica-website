<?php

	/*********************************************************
	WORDPRESS CORE MODIFICATIONS
	*********************************************************/
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Display relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'rel_canonical'); //Remove the wp canonical url
	add_filter( 'next_post_rel_link', 'disable_stuff' );
	add_filter( 'excerpt_length', 'excerpt_length', 140 );	
	add_filter('excerpt_more', 'excerpt_more');
	function disable_stuff( $data ) { return false; }
	function excerpt_length( $length ) { return 140; }
	function excerpt_more($more) { return '...'; }
	
	/*********************************************************
	THEME SETUP
	*********************************************************/
	
	/* Pica Theme Setup Action */
	add_action( 'init', 'pica_theme_setup' );
	
	function pica_theme_setup() {
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style('stylesheets/editor.css');	

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', __( 'Primary Menu', 'pica' ) );
		
		//POST TYPES
		include('inc/post-types.php');
		
	}//end function pica_theme_setup

	//META BOXES
	include('inc/meta-boxes.php');
	
	//SHORTCODES
	include('inc/shortcodes.php');

	//USERS
	include('inc/users.php');

	//GALLERIES & IMAGES
	include('inc/galleries-images.php');

	//TWITTER
	include('inc/twitter.php');
	
	//COMMENTS
	include('inc/comments.php');
?>