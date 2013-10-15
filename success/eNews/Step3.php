<?php
	include("../tech/DBConnect.php");
	
	$user = sqlSELECT("Users.*, User_eNews_Template.tmp_id FROM Users RIGHT JOIN User_eNews_Template ON Users.user_id = User_eNews_Template.user_id WHERE Users.user_id = {$_SESSION['user_id']}", 0) ;
	$user = $user[0];
	
	$template = sqlSELECT("* FROM eNews_Templates WHERE tmp_id={$user['tmp_id']}", 0);
	$template = $template[0];
	
	$user['tmp_title'] = $template['title'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Pica Success Master Tmp.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- InstanceBeginEditable name="Title" -->
        <title>Pica eNews&trade; - Step 3 - Completing Payment</title>
        <!-- InstanceEndEditable -->
        <link rel="stylesheet" href="../tech/master.css" />
        <link rel="shortcut icon" href="../media/Shortcut_Icon.png" />
        <!-- InstanceBeginEditable name="Head" -->
        <link rel="stylesheet" href="../tech/eNews.css" />
        <link rel="stylesheet" type="text/css" href="../tech/shadowbox-build-3.0rc1/shadowbox.css">
        
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
                    <div id="Step1">Choose your Pica eNews&trade; template</div>
                    <div id="Step2">Set-up your Account</div>
                    <div id="Step3" class="Active">Complete Payment through PayPal</div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="MiddleRow">
            	<div class="Center">
	                <!-- InstanceBeginEditable name="MiddleRow" -->
                    <div class="Copy">
	                    <h1>Complete Payment through PayPal</h1> 
                        <div><em>- Start using your eNews Account today!</em></div>
                    </div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="BottomRow">
            	<div class="Center">
                	<!-- InstanceBeginEditable name="BottomRow" -->
                    <div class="Copy">
                    	<br />
                        Thanks for supplying your information <?=$user['contact']?>, 
                        <br /><br />Billing will be handled by PayPal. By clicking 'Checkout' below you will be redirected to PayPal where you can complete your payment with either a Credit Card or a PayPal Account.
                        <!-- <br />You can add the eNews package to your PayPal cart and keep shopping if you like. -->
                        <br /><br />
                        <!--
                        <div style="border: 1px dotted rgb(175,175,175);padding: 5px ;">
                        	<br />
                            <strong>IMPORTANT:</strong>
                            To ensure that your account is created: When you are prompted by PayPal, please click the button which looks like this ->
                                <img src="../media/ReturnToPica.png" alt="Return to Pica Design" style="margin-bottom: -10px;"/> Your account will not be created until you have clicked this.
                            <br /><br />
                        </div>
                        <br /><br />
                        -->
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_cart">
                            <input type="hidden" name="add" value="1">
                            <input type="hidden" name="business" value="C9FQ9D9ZRA84G">
                            <input type="hidden" name="lc" value="US">
                            <input type="hidden" name="item_name" value="eNews Package">
                            <input type="hidden" name="amount" value="10.00">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="rm" value="1">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="undefined_quantity" value="0">
                            <input type="hidden" name="return" value="<?=$siteUrl?>Paid.php">
                            <input type="hidden" name="rm" value="1" />
                            <input type="hidden" name="cancel_return" value="<?=$siteUrl?>">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_SM.gif:NonHosted">
                            <input type="hidden" name="image_url" value="http://success.picadesign.com/media/Pica_PayPal_Header.png" />
                            <input type="image" src="../media/Checkout.png" />
                        </form>
                        <!--
						<br />
    					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_cart">
                            <input type="hidden" name="add" value="1">
                            <input type="hidden" name="business" value="C9FQ9D9ZRA84G">
                            <input type="hidden" name="lc" value="US">
                            <input type="hidden" name="item_name" value="Basic Website">
                            <input type="hidden" name="amount" value="0.02">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="rm" value="1">
                            <input type="hidden" name="return" value="http://picadesign.ath.cx/Pica Success/eNews/Paid.php">
                            <input type="hidden" name="cancel_return" value="http://picadesign.ath.cx/Pica Success/eNews">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_SM.gif:NonHosted">
                            <input type="hidden" name="image_url" value="http://www.picadesign.com/templates/Pica/images/logo.jpg" />
                            <input type="submit" value="Add website to Cart" />
                        </form>
						<br />
                        
                        <form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_cart">
                            <input type="hidden" name="business" value="C9FQ9D9ZRA84G">
                            <input type="hidden" name="display" value="1">
                            <input type="image" src="../media/Checkout.png" />
                        </form>
                        -->
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