<?php

	/* Wordpress Hook / Function Overrides */

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Masthead Navigation', 'FreeLandInMaine' ),
		'secondary' => __( 'Footer Navigation', 'FreeLandInMaine' ),
	) );
?>