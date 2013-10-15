<?php
	//Change all attachment url's so they are served from our fake CDN
	add_filter('wp_get_attachment_url', 'modify_image_url_for_cdn');
	function modify_image_url_for_cdn($url) {
		//By doing both str_replace's below we can change the url when the website is running on the live server or local dev
		//Remove www. if we're running on the live website
		$url = str_replace('www.', '', $url);
		//Add the images. subdomain before the domain
		$url = str_replace('http://', 'http://images.', $url);
		return $url;
	}

	class CDN {

		//Define our variables

		#General URL's
		public $domain ;
		public $path ;
		public $site_url ;
		public $template_directory ;

		#CDN URL's
		public $images_url ;
		public $styles_url ;
		public $scripts_url ;
		public $fonts_url ;
		public $downloads_url ;

		#CDN TEMPLATE URL's
		public $template_images_url ;
		public $template_styles_url ;
		public $template_scripts_url ;
		public $template_fonts_url ;
		public $template_downloads_url ;

		#CDN Subdomains
		public $images_subdomain ;
		public $styles_subdomain ;
		public $scripts_subdomain ;
		public $fonts_subdomain ;
		public $downloads_subdomain ;

		//Construct the class instance

		public function __construct ($use_subdomains = 1) {
			//The theme_namespace is defined in functions.php in the theme setup function
			//It simply contains the theme folder name, i.e. 'pica'
			global $theme_namespace;

			//$domain will be domain.com
			$this->domain = str_replace('www.', '', $_SERVER['HTTP_HOST']); 

			//$path will either be / or /subdirectory
			$this->path = str_replace('index.php', '', $_SERVER['PHP_SELF']); 

			//$site_url will either be domain.com/ or domain.com/subdirectory
			$this->site_url = $this->domain . $this->path; 

			//$template_directory will either be domain.com/wp-content/themes/themefolder or domain.com/subdirectory/wp-content/themes/themefolder
			$this->template_directory = $this->domain . $this->path . 'wp-content/themes/' . $theme_namespace . '/' ;

			//Define the CDN subdomains
			if ($use_subdomains) : 
				$this->images_subdomain 	= '//images.';
				$this->styles_subdomain 	= '//scripts.';
				$this->scripts_subdomain 	= '//styles.';
				$this->fonts_subdomain 		= '//fonts.';
				$this->downloads_subdomain 	= '//downloads.';
			else :
				//Live when www exists
				/*
				$this->images_subdomain 	= '//www.';
				$this->styles_subdomain 	= '//www.';
				$this->scripts_subdomain 	= '//www.';
				$this->fonts_subdomain 		= '//www.';
				$this->downloads_subdomain 	= '//www.';
				*/

				//Local when www. does not exist
				$this->images_subdomain 	= '//';
				$this->styles_subdomain 	= '//';
				$this->scripts_subdomain 	= '//';
				$this->fonts_subdomain 		= '//';
				$this->downloads_subdomain 	= '//';
			endif;

			#CND URL's
			$this->images_url 	 = $this->images_subdomain 	  . $this->site_url ;
			$this->styles_url 	 = $this->styles_subdomain 	  . $this->site_url ;
			$this->scripts_url 	 = $this->scripts_subdomain   . $this->site_url ;
			$this->fonts_url 	 = $this->fonts_subdomain 	  . $this->site_url ;
			$this->downloads_url = $this->downloads_subdomain . $this->site_url ;

			#CDN TEMPLATE URL's
			$this->template_images_url 	  = $this->images_subdomain    . $this->template_directory  . 'images/' ;
			$this->template_styles_url 	  = $this->styles_subdomain    . $this->template_directory  . 'stylesheets/' ;
			$this->template_scripts_url   = $this->scripts_subdomain   . $this->template_directory  . 'scripts/'  ;
			$this->template_fonts_url 	  = $this->fonts_subdomain     . $this->template_directory  . 'fonts/'  ;
			$this->template_downloads_url = $this->downloads_subdomain . $this->template_directory ;
		}//__construct
	}//class CDN
?>