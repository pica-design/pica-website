<?php
		global $siteUrl; $siteUrl = "picadesign.ath.cx/pica_website_2/";
?>
<!DOCTYPE HTML> 
<html>
    <head>    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>Pica Design LLC</title>
        <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory');?>/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <!--IE SHIV-->
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
            	<div class="navcontainer">
						<script type="text/javascript"> 
							$(document).ready(function() {							
								var showText="<img src='Screenshot.jpg'>";
								var hideText="<img src='Screenshot.jpg'>";
									$("#hide_this").before("<p><a href='#' id='toggle_link'>"+showText+"</a>");								
									$('#hide_this').hide();
									$('a#toggle_link').click(function() {
								if ($('a#toggle_link').html()==showText) {
									$('a#toggle_link').html(hideText);
									}
								else {
									$('a#toggle_link').html(showText);
									}
									$('#hide_this').toggle('slow');
									// return false so any link destination is not followed
								return false;
												});
							});
                     </script>
                     	<div id="hide_this">
                     	<p> BASOUYFWIGOPHDIABDAOUGWD OUIGHPADGULF OUGFAYDPHABDDagUODGA</p>
                        </div>
              </div><!--navcontainer-->
            </nav><!--end navigation bar-->
			<div id="wrapper"> <!--site wrapper-->