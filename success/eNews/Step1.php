<?php
	include("../tech/DBConnect.php");
	
	//Gather the Template selections
	$templates['family'] = sqlSELECT("* FROM eNews_Templates WHERE genre = 'family'", 0);	
	$templates['business'] = sqlSELECT("* FROM eNews_Templates WHERE genre = 'business'", 0);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Pica Success Master Tmp.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- InstanceBeginEditable name="Title" -->
        <title>Pica eNews&trade; - Step 1 - Choose Your Template</title>
        <!-- InstanceEndEditable -->
        <link rel="stylesheet" href="../tech/master.css" />
        <link rel="shortcut icon" href="../media/Shortcut_Icon.png" />
        <!-- InstanceBeginEditable name="Head" -->
        <script type="text/javascript">
			//Define any images which need to load, i.e. the on-state for rollover images
			var imagesToLoad = Array("Btn_Green_On.png");
		</script>
        
        <link rel="stylesheet" type="text/css" href="../tech/shadowbox-build-3.0rc1/shadowbox.css">
		<script type="text/javascript" src="../tech/shadowbox-build-3.0rc1/shadowbox.js"></script>
        <script type="text/javascript">
        	Shadowbox.init({
				players: ["html","img","iframe"],
				overlayColor: ["#4689c6"]
			});
        </script>
        
        <link rel="stylesheet" href="../tech/eNews.css" />
        <style type="text/css">	
			#EmailClients {
				list-style: none ;
				margin: 0 0 36px 0 ;
				padding: 0 ;
			}
				#EmailClients li {
					background: url(../media/green_check_mark.png) no-repeat 0 0 ;
					float: left ;
					margin-bottom: 6px ;
					padding-left: 25px ;
					width: 140px ;
				}
			#Templates .EmailTemplates {
				display: inline ;
			}
			#Templates .EmailTemplates li {
				float: left ;
				margin: 10px 30px 10px 10px;
				list-style: none ;
			}
				#Templates .EmailTemplates li span {
					display: block ;
					color: rgb(150,150,150) ;
					font-family: Arial, Helvetica, sans-serif ;
					font-size: 12px ;
				}
			#BottomRow .Center .Button {
				float: right ;
				margin-right: 60px ;
			}
			
		</style>
        
        <!-- InstanceEndEditable -->
        <script type="text/javascript" src="../tech/functions.js"></script>
    </head>
    <body>
    	<div id="wrapper">
        	<div id="TopRow">
            	<div class="Center">
                	<!-- InstanceBeginEditable name="TopRow" -->
                    <a href="index.php" title="Pica eNews Home" name="top">
	                    <img src="../media/eNews/eNews_Logo.png" class="Logo" "Pica eNews Logo" />
                    </a>
                    <div id="SiteNavigation">
                    	
                        <a href="AntiSpam.html" rel="shadowbox">
                        	<div class="Button">
                            	<div class="Blue_Btn">
                                	Anti-Spam Policy
                                </div>
                           	</div>
                        </a>
                        <a href="Terms.html" rel="shadowbox">
                        	<div class="Button">
                            	<div class="Blue_Btn">
                                	Terms & Conditions
                                </div>
                           	</div>
                        </a>
                        
                    </div>
                    <div style="clear: both;"></div>
                    <br /><br /><br /><br />
                    <div id="Step1" class="Active">Choose your Pica eNews&trade; template</div>
                    <div id="Step2">Set-up your Account</div>
                    <div id="Step3">Complete Payment through PayPal</div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="MiddleRow">
            	<div class="Center">
	                <!-- InstanceBeginEditable name="MiddleRow" -->
                    <div class="Copy">
	                    <h1>Choose your eNews Template below</h1> 
                    </div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="BottomRow">
            	<div class="Center">
                	<!-- InstanceBeginEditable name="BottomRow" -->
                    <div class="Copy">
                    	<? 
							if ($_GET['error']) {
								$display_error = " style=\"display: block ;\"";
								$Error = "Please select a template";
							}
						?>
                    	<div id="Error"<?=$display_error?>><?=$Error?></div>
                        <br />
                    
                    <div style="clear: both ;"></div>
                    <br />
                    
                    <em>Click the thumbnails below to preview each template. Choose your inital template and proceed to Step 2. You can add additional templates later on free of charge. <a href="mailto: enews@picadesign.com" title="Mail Us">enews@picadesign.com</a></em>
                    <br /><br /><br />
                    <div id="Templates">    
                    	<form action="Step2.php" method="post" name="TemplateSelectionForm">
                        <input type="hidden" name="FormName" value="TemplateSelectionForm" />
                        
                        <h2>Family & Friends Templates</h2>
                        <br />
                        
                        
                        <ul class="EmailTemplates">
                        <?
							foreach ($templates['family'] as $template) {
			echo "
				<li class='left-sidebar'>
					<a href='Campaign Templates/{$template['title']}/template-basic.html' title='{$template['title']}' rel='shadowbox[templates];width=900px'>
						<img src='Campaign Templates/{$template['title']}/screenshot.png' alt='Email template Preview' width='158'/> 
					</a>
					<span>
						Select: <input type='radio' name='Template' value='{$template['tmp_id']}' />
					</span> 
				</li>
			";
							}
						?>
                        </ul>
                        
                        <div style="clear: both ;"></div>
                        <br /><br />
                        
                        <h2>Business & Non-Profit Templates</h2>
                        <br />
                        <em>Click the thumbnails below to preview each template</em>
	                    <br /><br />
                        
                        
                        <ul class="EmailTemplates">
                        <?
							foreach ($templates['business'] as $template) {
			echo "
				<li class='left-sidebar'>
					<a href='Campaign Templates/{$template['title']}/template-basic.html' title='{$template['title']}' rel='shadowbox[templates];width=900px'>
						<img src='Campaign Templates/{$template['title']}/screenshot.png' alt='Email template Preview' width='158' height='168'/> 
					</a>
					<span>
						Select: <input type='radio' name='Template' value='{$template['tmp_id']}' />
					</span> 
				</li>
			";
							}
						?>
                        </ul>
                        
                        <div style="clear: both ;"></div>
                        <br />
                        
                        </form>
                    </div>
                    <div style="clear: both ;"></div>
                    <br />
                    <em>eNews works as expected in all major email clients!</em>
                        <br /><br />
                        <ul id="EmailClients">
                            <li>Outlook <em>(2007)</em></li>
                            <li>Apple Mail</li>
                            <li>Windows Live Mail</li>
                            <li>Hotmail</li>
                            <li class="last">Lotus Notes</li>
                            <li class="last">Outlook Express</li>
                            <li>Yahoo! Mail</li>
                            <li>AOL</li>
                            <li class="last">Thunderbird</li>
                            <li>Gmail <em>(older)</em></li>
                            <li>Gmail <em>(latest)</em></li>
                        </ul>
                    <br /><br /><br />
                    <div style="float: right; margin-right: 60px;">
	                    <em>Stay tuned for more template options coming soon!</em>
					</div>
                    <br /><br />
                    <div class="Button">
                    	<a href="#top" onclick="ValidateTemplateSelection();">
                            <div class="Green_Btn">
                                Step 2
                            </div>
                        </a>
                    </div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div style="clear: both;"></div>
            <div id="Footer">
            	<div class="Center">
	            	© 2000-2010 <a href="http://www.picadesign.com" title="Pica Design, LLC." target="_blank">Pica Design, LLC</a>. P.O. Box 225 / 111 Church Street, Belfast, Maine 04915-0225 / T 207.338.1740
                    <a href="http://www.picadesign.com" title="Pica Design, LLC." target="_blank">
	                    <img src="../media/PicaLogo.png" alt="Pica Design Logo" />
                    </a>
               	</div>
                <br /><br /><br /><br />
            </div>
        </div>
        <script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
				var pageTracker = _gat._getTracker("UA-4265805-30");
				pageTracker._trackPageview();
			} catch(err) {}
        </script>
    </body>
<!-- InstanceEnd --></html>