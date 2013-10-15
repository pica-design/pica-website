<?php
	//Load the theme styles and scripts scripts
	add_action('wp_enqueue_scripts', 'load_theme_styles_and_scripts');
	function load_theme_styles_and_scripts() {
		if (!is_admin()) : 
	    	global $is_IE, $theme_namespace, $cdn ;
		    /* SCRIPTS */
		    //Use the hosted version of jquery - we need jquery in the header, hence the use of false for the last argument
		    wp_deregister_script( 'jquery' );
		    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', '', '', true);
		    wp_enqueue_script( 'jquery' );
			
			//The following is only for working on the script file (no the min version)
			wp_register_script("jquery-$theme_namespace", $cdn->template_scripts_url . "jquery.$theme_namespace.js", 'jquery', '', true);
			wp_enqueue_script("jquery-$theme_namespace");

			/* STYLES */
			//Load our stylesheet
		    wp_register_style("style-$theme_namespace", $cdn->template_styles_url . "style.css", '', null);
		    wp_enqueue_style("style-$theme_namespace");

			//Add our < IE9 scripts and styles
		    if ($is_IE) : 
		    	// Include the file, if needed
			    if ( ! function_exists( 'wp_check_browser_version' ) )
			        include_once( ABSPATH . 'wp-admin/includes/dashboard.php' );
			    
		    	// IE version conditional enqueue
			    $response = wp_check_browser_version();
			    if ( 0 > version_compare( intval( $response['version'] ) , 9 ) ) :
			        wp_register_script ('html5shim', "http://html5shim.googlecode.com/svn/trunk/html5.js");
			        wp_enqueue_script ('html5shim');

			        //Load our stylesheet
				    wp_register_style("style-$theme_namespace-ie", $cdn->template_styles_url . "ie.css", '', null);
				    wp_enqueue_style("style-$theme_namespace-ie");
				endif;//END IE9
			endif;//END IE
		endif;
	}    
?>