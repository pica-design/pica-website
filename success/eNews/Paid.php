<?
	include("../tech/DBConnect.php");
	require_once("campaignmonitor-php-1.4.3/CMBase.php");
	$Error = "";
	$display_error = "";
	
	function recurse_copy($src,$dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ) {
					recurse_copy($src . '/' . $file,$dst . '/' . $file);
				}
				else {
					copy($src . '/' . $file,$dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	} 
	sqlUPDATE("Users SET eNews_Paid = 1 WHERE user_id = {$_SESSION['user_id']}", 0) ;
	
	$user = sqlSELECT("Users.*, User_eNews_Template.* FROM Users RIGHT JOIN User_eNews_Template ON Users.user_id = User_eNews_Template.user_id WHERE Users.user_id = {$_SESSION['user_id']}", 0) ;
	$user = $user[0];
	$template = sqlSELECT("* FROM eNews_Templates WHERE tmp_id={$user['tmp_id']}", 0);
	$template = $template[0];
	$user['tmp_title'] = $template['title'];
	$html_str = "";
	
	/*
	echo "<pre>";
	print_r($user);
	echo "</pre>";
	*/

	//Create the Users eNews Account
	$cm = new CampaignMonitor('474c5ff0c27ac3030c897b8e68e5efd3');
	$result = $cm->clientCreate( $user['company'], $user['contact'], $user['email'], $user['country'], $user['timezone'] );
	
	if (is_array($result['anyType'])) {
		//Gracefull Degrade
		if ($result['anyType']['Code'] == 172) {
			//5 accounts already created in a 30 minute time span
			$Error = "<ul><li>There have been too many accounts created in a 30 minute timeframe, please refresh this page in 5 minutes to try again. We apologise for the inconvenience. </li></ul>";
		}
		if ($result['anyType']['Code'] == 150) {	
			//Email already associated with an account
			$Error = "<ul><li>It appears your email address is already associated with an account. Please try to login with the credentials below. If you're trying to add another template to your account just give us a call @ 207-338-1740 and we'll add it to your current account</li></ul>";
		}
	} else {
		//Client was created successfully
		sqlUPDATE("Users SET client_id = '{$result['anyType']}' WHERE user_id = {$user['user_id']}", 0) ;
		$user['client_id'] = $result['anyType'];
		
		//Update Client Access and Bill
		$result = $cm->clientUpdateAccessAndBilling ( $user['client_id'], "23", $user['company'], $user['password'], "ClientPaysWithMarkup", "USD", "10", "1","0" );
		
		//Upload the client's chosen template to CM
		$html_url = $siteUrl."Campaign Templates/{$user['tmp_title']}/template-with-editor-tags.html";
		$zip_url = $siteUrl."Campaign Templates/{$user['tmp_title']}/Archive.zip";
		$screenshot_url = $siteUrl."Campaign Templates/{$user['tmp_title']}/screenshot.png";
		
		$result = $cm->templateCreate($user['client_id'], $user['tmp_title'], $html_url, $zip_url, $screenshot_url);
	}
	
	if ($Error != "") {
		$display_error = " style=\"display: block;\"";
	} else {
		//No Errors
		
		//Generate an Email to Pica detailing the new Client 
		$to = "enews@picadesign.com";
		$sender = "enews@picadesign.com";
		
		$subject = "eNews - New Client";
		$body = "
Account Name: {$user['company']} 
Contact Name: {$user['contact']} 
Contact Email: {$user['email']} 

Website: {$user['website']} 
Phone: {$user['phone']} 
Mailing: {$user['mailing']} 
Country: {$user['country']} 
Timezone: {$user['timezone']} 
Selected Template: {$user['tmp_title']}";

		mail($to, $subject, $body, "From: $sender", "-f  $sender");
		
		
		//Generate an Email to the Client listing all their login credentials and links
		$to = $user['email'];
		$subject = "Your very own Pica eNews!";
		$body = "
Thank you for choosing Pica eNews™ as your html email campaign provider! 

You can login to your Pica eNews™ Manager here: 
http://eNews.picadesign.com

Your login information is (Remember to save this information):
Username: {$user['company']} 
Password: {$user['password']} 

If you should lose your password just go to the link above and click on 'I forgot my password'

Check out this tutorial on how to create your first Campaign and begin importing your first subscribers: 
http://tutorials.picadesign.com/2009/08/19/creating-an-enew-campaign/ 


Should you have any questions you can reply to this email or call us at 207-338-1740
-Team Pica";
		

		mail($to, $subject, $body, "From: $sender", "-f  $sender");
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Pica Success Master Tmp.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- InstanceBeginEditable name="Title" -->
        <title>Pica eNews&trade; - Thank you for your payment! - Login to your Account</title>
        <!-- InstanceEndEditable -->
        <link rel="stylesheet" href="../tech/master.css" />
        <link rel="shortcut icon" href="../media/Shortcut_Icon.png" />
        <!-- InstanceBeginEditable name="Head" -->
        <link rel="stylesheet" href="../tech/eNews.css" />
        
        <link rel="stylesheet" type="text/css" href="../tech/shadowbox-build-3.0rc1/shadowbox.css">
		<script type="text/javascript" src="../tech/shadowbox-build-3.0rc1/shadowbox.js"></script>
        <script type="text/javascript">
        	Shadowbox.init({
				players: ["html","img","iframe"],
				overlayColor: ["#4689c6"]
			});
        </script>
        
        <!-- InstanceEndEditable -->
        <script type="text/javascript" src="../tech/functions.js"></script>
    </head>
    <body>
    	<div id="wrapper">
        	<div id="TopRow">
            	<div class="Center">
                	<!-- InstanceBeginEditable name="TopRow" -->
                    <a href="index.php" title="Pica eNews Home">
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
                    <div id="Step1">Choose your eNews template</div>
                    <div id="Step2">Tell us about yourself</div>
                    <div id="Step3">Complete Payment</div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="MiddleRow">
            	<div class="Center">
	                <!-- InstanceBeginEditable name="MiddleRow" -->
                    <div class="Copy">
	                    <h1>Thanks for your Payment!</h1> 
                        <div><em>- Now you can start managing your subscribers</em></div>
                    </div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="BottomRow">
            	<div class="Center">
                	<!-- InstanceBeginEditable name="BottomRow" -->
                    <div class="Copy">
						<div id="Error"<?=$display_error?>><?=$Error?></div>
                    	<br />
                        
	                    Thanks <?=$user['contact']?> and welcome to Pica eNews&trade;. You will receive an email momentarily containing a copy of the information listed below. 
                        
                        <?
							if ($template['layout'] != 'family') {
						?>
                        Within 2-4 business days we will modify the header image in your chosen template to include the image or text you chose in the previous step. At that point, we will contact you either by phone or email for you to proof the design. 
                        <br /><br />
                        <?
							}
						?>
                       
                        You can get started setting up your first campaign and managing your subscribers. 
                        <br /><br />
                        Login by clicking on the link below. Your username and password are:
                        <br />
                        <a href="http://enews.picadesign.com" target="_blank" title="Login to the Pica eNews Manager"><h2><u>Pica eNews&trade; Manager Login</u></h2></a>
                        <br />
                        Username: 
                      	<?
							if ($html_str != "") {
								echo $html_str;
							} else {
								echo "<b>{$user['company']}</b>\n";
							}
						?>
                        <br />
                        Password: <b><?=$user['password']?></b>
                        <br /><br /><br />
                        <a href="http://tutorials.picadesign.com/2009/08/19/creating-an-enew-campaign/" title="eNews Tutorial" target="_blank"><u>Check out the Pica eNews&trade; Tutorial</u></a>
                        <br /><br />
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