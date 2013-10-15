<?php
	$siteUrl = "http://success.picadesign.com/hosting/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
    
    Order Hosting $10/Month
    <form action="https://www.paypal.com/cgi-bin/webscr"; method="post">
        <input type="hidden" name="cmd" value="_xclick-subscriptions">
        <input type="hidden" name="business" value="C9FQ9D9ZRA84G">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="item_name" value="Pica Web Hosting">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="a3" value="10.00">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="src" value="1">
        <input type="hidden" name="p3" value="1">
        <input type="hidden" name="t3" value="M">
        <input type="hidden" name="sra" value="1">
        <input type="hidden" name="return" value="<?=$siteUrl?>Paid.php">
        <input type="hidden" name="cancel_return" value="<?=$siteUrl?>">
        <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribe_LG.gif:NonHosted">
        <input type="hidden" name="image_url" value="http://success.picadesign.com/media/Pica_PayPal_Header.png" />
        <input type="image" src="../media/Order Now.png" />
    </form>
    
    <br /><br />
    
    Order a Domain $15/Year
    <form action="https://www.paypal.com/cgi-bin/webscr"; method="post">
        <input type="hidden" name="cmd" value="_xclick-subscriptions">
        <input type="hidden" name="business" value="C9FQ9D9ZRA84G">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="item_name" value="Pica Web Hosting - Domain">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="a3" value="15.00">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="src" value="1">
        <input type="hidden" name="p3" value="1">
        <input type="hidden" name="t3" value="Y">
        <input type="hidden" name="sra" value="1">
        <input type="hidden" name="return" value="<?=$siteUrl?>Paid.php">
        <input type="hidden" name="cancel_return" value="<?=$siteUrl?>">
        <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribe_LG.gif:NonHosted">
        <input type="hidden" name="image_url" value="http://success.picadesign.com/media/Pica_PayPal_Header.png" />
        <input type="image" src="../media/Order Now.png" />
    </form>
                        
</body>
</html>