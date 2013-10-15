<?php
	include("../tech/DBConnect.php");
	$Error = "";
	$display_error = "";
	
	if ($_POST) {	
		//MySQL Input clensing is done to the raw superglobals in DBConnect.php prior to running any insert statements
		if ($_POST['FormName'] == "UserInfoForm") {
			//Turn the POST VARS into local vars
			//i.e. $_POST['Company'] becomes $Company
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}
			//Store the User Data
			
			if ($Website == "") {
				$Website = "None";
			}
			
			if ($user_id = sqlINSERT("Users VALUES('', '','$Company', '$Password', '$Contact', '$Email', '$Website', '$Phone','$Mailing','$Country','$Timezone','','')", 0)) {	
				
				//Store the User's eNews Template Selection
				if (sqlINSERT("User_eNews_Template VALUES($user_id, $Template)", 0)) {
				} else {
					//Compile User / Template Selection Errors
				}
				//All operations went smoothly
				//Create a new user session 
				session_destroy();
				session_start();
				$_SESSION['user_id'] = $user_id;
				
				header("Location: Step3.php");
			}//End User Data Input 
			else {
				//Compile New User Addition Errors
			}
		}//End New Post
		//Display the currently selected template
			//This carries over from Step1.php 
			//THis is present in the form as a hidden field (Carried from Step1.php)
			//So it is available in both instances
		$template = sqlSELECT("* FROM eNews_Templates WHERE tmp_id={$_POST['Template']}", 0);
		$template = $template[0];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Pica Success Master Tmp.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- InstanceBeginEditable name="Title" -->
        <title>Pica eNews&trade; - Step 2 - Creating Your Account</title>
        <!-- InstanceEndEditable -->
        <link rel="stylesheet" href="../tech/master.css" />
        <link rel="shortcut icon" href="../media/Shortcut_Icon.png" />
        <!-- InstanceBeginEditable name="Head" -->
        <script type="text/javascript" src="../tech/Ajax_Lib.js"></script>
        
        <link rel="stylesheet" type="text/css" href="../tech/shadowbox-build-3.0rc1/shadowbox.css">
		<script type="text/javascript" src="../tech/shadowbox-build-3.0rc1/shadowbox.js"></script>
        <script type="text/javascript">
        	Shadowbox.init({
				players: ["html","img","iframe"],
				overlayColor: ["#4689c6"]
			});
        </script>
        
        <link rel="stylesheet" href="../tech/eNews.css" />
        <link rel="stylesheet" type="text/css" href="../tech/shadowbox-build-3.0rc1/shadowbox.css">
        <style type="text/css">
			#SelectedTemplate {
				float: left ;
				width: 160px ;
			}
			#BusinessInfo {
				float: left ;
				margin-left: 85px ;
				margin-right: -15px ;
				width: 600px ;
			}
				Label {
					width: 240px ;
					display: block ;
				}
					.HeaderLabel {
						width: 240px ;
					}
				.Required {
					color: red ;
					font-family: "MS Serif", "New York", serif ;
					font-size: 16px ;
					font-weight: bold ;
				}
				#Header_Required_Text {
					color: rgb(255,255,255) ;
				}
				Input, Textarea, Select {
					width: 225px ;
					border: 1px solid #4689c6 ;
				}
					Select {
						margin-right: -2px ;
					}
					Input:hover, Input:focus, Textarea:hover, Textarea:focus {
						background-color: #FFC ;
					}
					Input.Radio, Input.TermsCheck {
						width: 15px ;
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
                    <div id="Step2" class="Active">Set-up your Account</div>
                    <div id="Step3">Complete Payment through PayPal</div>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="MiddleRow">
            	<div class="Center">
	                <!-- InstanceBeginEditable name="MiddleRow" -->
                    <div class="Copy">
	                    <h1>Set-up your account</h1> 
                        <div><em>- In the next step you will complete payment</em></div>
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
                        <div id="SelectedTemplate">
                            <h2>Selected Template: </h2> 
                            <br />
                            <em><?=$template['title']?></em>
                            <br />
                            <br />
                            <?
								echo "
										<a href='Campaign Templates/{$template['title']}/template-basic.html' title='{$template['title']}' rel='shadowbox[templates];width=900px'>
											<img src='Campaign Templates/{$template['title']}/screenshot.png' alt='Email template Preview' width='158'/> 
										</a> 
								";
                            ?>
                            <br />
                        </div>
                        <div id="BusinessInfo">
                        	&nbsp; <em>Please fill in all required fields</em>
                            <br />
                            <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="UserInfoForm">
                            	<input type="hidden" name="FormName" value="UserInfoForm" />
                            	<input type="hidden" name="Template" value="<?=$template['tmp_id']?>" />
                            	<table cellpadding="0" cellspacing="5" border="0">
                                	<tr>
                                    	<td colspan="2"><label for="Company">Account Name:</label></td><td><input type="text" name="Company" id="Company" maxlength="40"/><!-- &nbsp; <span class="Required">!</span> --></td>
                                    </tr><tr>
                                    	<td colspan="2"><label for="Password">Choose a Password: <em style="font-size: 11px">5 - 10 Characters</em></label></td><td><input type="Password" name="Password" id="Password" maxlength="10"/><!-- &nbsp; <span class="Required">!</span> --></td>
									</tr><tr>
                                    	<td colspan="2"><label for="Contact">Contact Name:</label></td><td><input type="text" name="Contact" id="Contact" maxlength="40"/><!-- &nbsp; <span class="Required">!</span> --></td>
									</tr><tr>
                                        <td colspan="2"><label for="Email">Email:</label></td><td><input type="text" name="Email" id="Email" maxlength="40"/><!-- &nbsp; <span class="Required">!</span> --></td>
                                    </tr><tr>
                                    	<td colspan="2"><label for="Website">Website URL: <em style="font-size: 11px">If Applicable</em></label></td><td><input type="text" name="Website" id="Website" maxlength="40"/></td>
                                    </tr><tr>
                                    	<td colspan="2"><label for="Phone">Phone Number:</label></td><td><input type="text" name="Phone" id="Phone" maxlength="15"/><!-- &nbsp; <span class="Required">!</span> --></td>
                                    </tr><tr>
                                    	<td colspan="2"><label for="Mailing">Billing Address:</label></td><td><input type="text" name="Mailing" id="Mailing" maxlength="60" /><!-- &nbsp; <span class="Required">!</span> --></td>
                                    </tr><tr>
                                    	<td colspan="2"><label for="Country">Country:</label></td>
                                        <td><select name="Country">
												<option value="United States of America" selected="selected">United States of America</option><option value="United Kingdom" >United Kingdom</option><option value="Australia" >Australia</option><option value="Canada" >Canada</option><option value="">-------------</option><option value="Afghanistan" >Afghanistan</option><option value="Albania" >Albania</option><option value="Algeria" >Algeria</option><option value="American Samoa" >American Samoa</option><option value="Andorra" >Andorra</option><option value="Angola" >Angola</option><option value="Anguilla" >Anguilla</option><option value="Antigua & Barbuda" >Antigua & Barbuda</option><option value="Argentina" >Argentina</option><option value="Armenia" >Armenia</option><option value="Aruba" >Aruba</option><option value="Australia" >Australia</option><option value="Austria" >Austria</option><option value="Azerbaijan" >Azerbaijan</option><option value="Azores" >Azores</option><option value="Bahamas" >Bahamas</option><option value="Bahrain" >Bahrain</option><option value="Bangladesh" >Bangladesh</option><option value="Barbados" >Barbados</option><option value="Belarus" >Belarus</option><option value="Belgium" >Belgium</option><option value="Belize" >Belize</option><option value="Benin" >Benin</option><option value="Bermuda" >Bermuda</option><option value="Bhutan" >Bhutan</option><option value="Bolivia" >Bolivia</option><option value="Bonaire" >Bonaire</option><option value="Bosnia & Herzegovina" >Bosnia & Herzegovina</option><option value="Botswana" >Botswana</option><option value="Brazil" >Brazil</option><option value="British Indian Ocean Ter" >British Indian Ocean Ter</option><option value="Brunei" >Brunei</option><option value="Bulgaria" >Bulgaria</option><option value="Burkina Faso" >Burkina Faso</option><option value="Burundi" >Burundi</option><option value="Cambodia" >Cambodia</option><option value="Cameroon" >Cameroon</option><option value="Canada" >Canada</option><option value="Canary Islands" >Canary Islands</option><option value="Cape Verde" >Cape Verde</option><option value="Cayman Islands" >Cayman Islands</option><option value="Central African Republic" >Central African Republic</option><option value="Chad" >Chad</option><option value="Channel Islands" >Channel Islands</option><option value="Chile" >Chile</option><option value="China" >China</option><option value="Christmas Island" >Christmas Island</option><option value="Cocos Island" >Cocos Island</option><option value="Columbia" >Columbia</option><option value="Comoros" >Comoros</option><option value="Congo" >Congo</option><option value="Cook Islands" >Cook Islands</option><option value="Costa Rica" >Costa Rica</option><option value="Cote DIvoire" >Cote D'Ivoire</option><option value="Croatia" >Croatia</option><option value="Cuba" >Cuba</option><option value="Curacao" >Curacao</option><option value="Cyprus" >Cyprus</option><option value="Czech Republic" >Czech Republic</option><option value="Denmark" >Denmark</option><option value="Djibouti" >Djibouti</option><option value="Dominica" >Dominica</option><option value="Dominican Republic" >Dominican Republic</option><option value="East Timor" >East Timor</option><option value="Ecuador" >Ecuador</option><option value="Egypt" >Egypt</option><option value="El Salvador" >El Salvador</option><option value="Equatorial Guinea" >Equatorial Guinea</option><option value="Eritrea" >Eritrea</option><option value="Estonia" >Estonia</option><option value="Ethiopia" >Ethiopia</option><option value="Falkland Islands" >Falkland Islands</option><option value="Faroe Islands" >Faroe Islands</option><option value="Fiji" >Fiji</option><option value="Finland" >Finland</option><option value="France" >France</option><option value="French Guiana" >French Guiana</option><option value="French Polynesia" >French Polynesia</option><option value="French Southern Ter" >French Southern Ter</option><option value="Gabon" >Gabon</option><option value="Gambia" >Gambia</option><option value="Georgia" >Georgia</option><option value="Germany" >Germany</option><option value="Ghana" >Ghana</option><option value="Gibraltar" >Gibraltar</option><option value="Great Britain" >Great Britain</option><option value="Greece" >Greece</option><option value="Greenland" >Greenland</option><option value="Grenada" >Grenada</option><option value="Guadeloupe" >Guadeloupe</option><option value="Guam" >Guam</option><option value="Guatemala" >Guatemala</option><option value="Guinea" >Guinea</option><option value="Guyana" >Guyana</option><option value="Haiti" >Haiti</option><option value="Hawaii" >Hawaii</option><option value="Honduras" >Honduras</option><option value="Hong Kong" >Hong Kong</option><option value="Hungary" >Hungary</option><option value="Iceland" >Iceland</option><option value="India" >India</option><option value="Indonesia" >Indonesia</option><option value="Iran" >Iran</option><option value="Iraq" >Iraq</option><option value="Ireland" >Ireland</option><option value="Isle of Man" >Isle of Man</option><option value="Israel" >Israel</option><option value="Italy" >Italy</option><option value="Jamaica" >Jamaica</option><option value="Japan" >Japan</option><option value="Jordan" >Jordan</option><option value="Kazakhstan" >Kazakhstan</option><option value="Kenya" >Kenya</option><option value="Kiribati" >Kiribati</option><option value="Korea North" >Korea North</option><option value="Korea South" >Korea South</option><option value="Kuwait" >Kuwait</option><option value="Kyrgyzstan" >Kyrgyzstan</option><option value="Laos" >Laos</option><option value="Latvia" >Latvia</option><option value="Lebanon" >Lebanon</option><option value="Lesotho" >Lesotho</option><option value="Liberia" >Liberia</option><option value="Libya" >Libya</option><option value="Liechtenstein" >Liechtenstein</option><option value="Lithuania" >Lithuania</option><option value="Luxembourg" >Luxembourg</option><option value="Macau" >Macau</option><option value="Macedonia" >Macedonia</option><option value="Madagascar" >Madagascar</option><option value="Malaysia" >Malaysia</option><option value="Malawi" >Malawi</option><option value="Maldives" >Maldives</option><option value="Mali" >Mali</option><option value="Malta" >Malta</option><option value="Marshall Islands" >Marshall Islands</option><option value="Martinique" >Martinique</option><option value="Mauritania" >Mauritania</option><option value="Mauritius" >Mauritius</option><option value="Mayotte" >Mayotte</option><option value="Mexico" >Mexico</option><option value="Midway Islands" >Midway Islands</option><option value="Moldova" >Moldova</option><option value="Monaco" >Monaco</option><option value="Mongolia" >Mongolia</option><option value="Montserrat" >Montserrat</option><option value="Morocco" >Morocco</option><option value="Mozambique" >Mozambique</option><option value="Myanmar" >Myanmar</option><option value="Nambia" >Nambia</option><option value="Nauru" >Nauru</option><option value="Nepal" >Nepal</option><option value="Netherland Antilles" >Netherland Antilles</option><option value="Netherlands" >Netherlands</option><option value="Nevis" >Nevis</option><option value="New Caledonia" >New Caledonia</option><option value="New Zealand" >New Zealand</option><option value="Nicaragua" >Nicaragua</option><option value="Niger" >Niger</option><option value="Nigeria" >Nigeria</option><option value="Niue" >Niue</option><option value="Norfolk Island" >Norfolk Island</option><option value="Norway" >Norway</option><option value="Oman" >Oman</option><option value="Pakistan" >Pakistan</option><option value="Palau Island" >Palau Island</option><option value="Palestine" >Palestine</option><option value="Panama" >Panama</option><option value="Papua New Guinea" >Papua New Guinea</option><option value="Paraguay" >Paraguay</option><option value="Peru" >Peru</option><option value="Philippines" >Philippines</option><option value="Pitcairn Island" >Pitcairn Island</option><option value="Poland" >Poland</option><option value="Portugal" >Portugal</option><option value="Puerto Rico" >Puerto Rico</option><option value="Qatar" >Qatar</option><option value="Reunion" >Reunion</option><option value="Romania" >Romania</option><option value="Russia" >Russia</option><option value="Rwanda" >Rwanda</option><option value="St Barthelemy" >St Barthelemy</option><option value="St Eustatius" >St Eustatius</option><option value="St Helena" >St Helena</option><option value="St Kitts-Nevis" >St Kitts-Nevis</option><option value="St Lucia" >St Lucia</option><option value="St Maarten" >St Maarten</option><option value="St Pierre & Miquelon" >St Pierre & Miquelon</option><option value="St Vincent & Grenadines" >St Vincent & Grenadines</option><option value="Saipan" >Saipan</option><option value="Samoa" >Samoa</option><option value="Samoa American" >Samoa American</option><option value="San Marino" >San Marino</option><option value="Sao Tome & Principe" >Sao Tome & Principe</option><option value="Saudi Arabia" >Saudi Arabia</option><option value="Senegal" >Senegal</option><option value="Seychelles" >Seychelles</option><option value="Serbia & Montenegro" >Serbia & Montenegro</option><option value="Sierra Leone" >Sierra Leone</option><option value="Singapore" >Singapore</option><option value="Slovakia" >Slovakia</option><option value="Slovenia" >Slovenia</option><option value="Solomon Islands" >Solomon Islands</option><option value="Somalia" >Somalia</option><option value="South Africa" >South Africa</option><option value="Spain" >Spain</option><option value="Sri Lanka" >Sri Lanka</option><option value="Sudan" >Sudan</option><option value="Suriname" >Suriname</option><option value="Swaziland" >Swaziland</option><option value="Sweden" >Sweden</option><option value="Switzerland" >Switzerland</option><option value="Syria" >Syria</option><option value="Tahiti" >Tahiti</option><option value="Taiwan" >Taiwan</option><option value="Tajikistan" >Tajikistan</option><option value="Tanzania" >Tanzania</option><option value="Thailand" >Thailand</option><option value="Togo" >Togo</option><option value="Tokelau" >Tokelau</option><option value="Tonga" >Tonga</option><option value="Trinidad & Tobago" >Trinidad & Tobago</option><option value="Tunisia" >Tunisia</option><option value="Turkey" >Turkey</option><option value="Turkmenistan" >Turkmenistan</option><option value="Turks & Caicos Is" >Turks & Caicos Is</option><option value="Tuvalu" >Tuvalu</option><option value="Uganda" >Uganda</option><option value="Ukraine" >Ukraine</option><option value="United Arab Emirates" >United Arab Emirates</option><option value="United Kingdom" >United Kingdom</option><option value="United States of America">United States of America</option><option value="Uruguay" >Uruguay</option><option value="Uzbekistan" >Uzbekistan</option><option value="Vanuatu" >Vanuatu</option><option value="Vatican City State" >Vatican City State</option><option value="Venezuela" >Venezuela</option><option value="Vietnam" >Vietnam</option><option value="Virgin Islands (Brit)" >Virgin Islands (Brit)</option><option value="Virgin Islands (USA)" >Virgin Islands (USA)</option><option value="Wake Island" >Wake Island</option><option value="Wallis & Futana Is" >Wallis & Futana Is</option><option value="Yemen" >Yemen</option><option value="Zaire" >Zaire</option><option value="Zambia" >Zambia</option><option value="Zimbabwe" >Zimbabwe</option>
													</select>
                                        <!-- &nbsp; <span class="Required">!</span> --></td>
                                	</tr><tr>
                                	<td colspan="2"><label for="Timezone">Time Zone:</label></td><td>                                    
                                        <select name="Timezone">
                                        	<option value='(GMT-05:00) Eastern Time (US & Canada)' selected="selected">(GMT-05:00) Eastern Time (US & Canada)</option>
                                            <option value='(GMT-06:00) Central Time (US & Canada)'>(GMT-06:00) Central Time (US & Canada)</option>
                                            <option value='(GMT-08:00) Pacific Time (US & Canada)'>(GMT-08:00) Pacific Time (US & Canada)</option>
	                                        <option value="">-------------</option>
											<option value='(GMT) Casablanca'>(GMT) Casablanca</option><option value='(GMT) Coordinated Universal Time'>(GMT) Coordinated Universal Time</option><option value='(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London'>(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option><option value='(GMT) Monrovia, Reykjavik'>(GMT) Monrovia, Reykjavik</option><option value='(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option><option value='(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague'>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option><option value='(GMT+01:00) Brussels, Copenhagen, Madrid, Paris'>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option><option value='(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb'>(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option><option value='(GMT+01:00) West Central Africa'>(GMT+01:00) West Central Africa</option><option value='(GMT+02:00) Amman'>(GMT+02:00) Amman</option><option value='(GMT+02:00) Athens, Bucharest, Istanbul'>(GMT+02:00) Athens, Bucharest, Istanbul</option><option value='(GMT+02:00) Beirut'>(GMT+02:00) Beirut</option><option value='(GMT+02:00) Cairo'>(GMT+02:00) Cairo</option><option value='(GMT+02:00) Harare, Pretoria'>(GMT+02:00) Harare, Pretoria</option><option value='(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius'>(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option><option value='(GMT+02:00) Jerusalem'>(GMT+02:00) Jerusalem</option><option value='(GMT+02:00) Minsk'>(GMT+02:00) Minsk</option><option value='(GMT+02:00) Windhoek'>(GMT+02:00) Windhoek</option><option value='(GMT+03:00) Baghdad'>(GMT+03:00) Baghdad</option><option value='(GMT+03:00) Kuwait, Riyadh'>(GMT+03:00) Kuwait, Riyadh</option><option value='(GMT+03:00) Moscow, St. Petersburg, Volgograd'>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option><option value='(GMT+03:00) Nairobi'>(GMT+03:00) Nairobi</option><option value='(GMT+03:00) Tbilisi'>(GMT+03:00) Tbilisi</option><option value='(GMT+03:30) Tehran'>(GMT+03:30) Tehran</option><option value='(GMT+04:00) Abu Dhabi, Muscat'>(GMT+04:00) Abu Dhabi, Muscat</option><option value='(GMT+04:00) Baku'>(GMT+04:00) Baku</option><option value='(GMT+04:00) Caucasus Standard Time'>(GMT+04:00) Caucasus Standard Time</option><option value='(GMT+04:00) Port Louis'>(GMT+04:00) Port Louis</option><option value='(GMT+04:00) Yerevan'>(GMT+04:00) Yerevan</option><option value='(GMT+04:30) Kabul'>(GMT+04:30) Kabul</option><option value='(GMT+05:00) Ekaterinburg'>(GMT+05:00) Ekaterinburg</option><option value='(GMT+05:00) Islamabad, Karachi'>(GMT+05:00) Islamabad, Karachi</option><option value='(GMT+05:00) Tashkent'>(GMT+05:00) Tashkent</option><option value='(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi'>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option><option value='(GMT+05:30) Sri Jayawardenepura'>(GMT+05:30) Sri Jayawardenepura</option><option value='(GMT+05:45) Kathmandu'>(GMT+05:45) Kathmandu</option><option value='(GMT+06:00) Almaty, Novosibirsk'>(GMT+06:00) Almaty, Novosibirsk</option><option value='(GMT+06:00) Astana, Dhaka'>(GMT+06:00) Astana, Dhaka</option><option value='(GMT+06:30) Yangon (Rangoon)'>(GMT+06:30) Yangon (Rangoon)</option><option value='(GMT+07:00) Bangkok, Hanoi, Jakarta'>(GMT+07:00) Bangkok, Hanoi, Jakarta</option><option value='(GMT+07:00) Krasnoyarsk'>(GMT+07:00) Krasnoyarsk</option><option value='(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi'>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option><option value='(GMT+08:00) Irkutsk, Ulaan Bataar'>(GMT+08:00) Irkutsk, Ulaan Bataar</option><option value='(GMT+08:00) Kuala Lumpur, Singapore'>(GMT+08:00) Kuala Lumpur, Singapore</option><option value='(GMT+08:00) Perth'>(GMT+08:00) Perth</option><option value='(GMT+08:00) Taipei'>(GMT+08:00) Taipei</option><option value='(GMT+09:00) Osaka, Sapporo, Tokyo'>(GMT+09:00) Osaka, Sapporo, Tokyo</option><option value='(GMT+09:00) Seoul'>(GMT+09:00) Seoul</option><option value='(GMT+09:00) Yakutsk'>(GMT+09:00) Yakutsk</option><option value='(GMT+09:30) Adelaide'>(GMT+09:30) Adelaide</option><option value='(GMT+09:30) Darwin'>(GMT+09:30) Darwin</option><option value='(GMT+10:00) Brisbane'>(GMT+10:00) Brisbane</option><option value='(GMT+10:00) Canberra, Melbourne, Sydney'>(GMT+10:00) Canberra, Melbourne, Sydney</option><option value='(GMT+10:00) Guam, Port Moresby'>(GMT+10:00) Guam, Port Moresby</option><option value='(GMT+10:00) Hobart'>(GMT+10:00) Hobart</option><option value='(GMT+10:00) Vladivostok'>(GMT+10:00) Vladivostok</option><option value='(GMT+11:00) Magadan, Solomon Is., New Caledonia'>(GMT+11:00) Magadan, Solomon Is., New Caledonia</option><option value='(GMT+12:00) Auckland, Wellington'>(GMT+12:00) Auckland, Wellington</option><option value='(GMT+12:00) Fiji, Marshall Is.'>(GMT+12:00) Fiji, Marshall Is.</option><option value='(GMT+12:00) Petropavlovsk-Kamchatsky'>(GMT+12:00) Petropavlovsk-Kamchatsky</option><option value='(GMT+13:00) Nuku'alofa'>(GMT+13:00) Nuku'alofa</option><option value='(GMT-01:00) Azores'>(GMT-01:00) Azores</option><option value='(GMT-01:00) Cape Verde Is.'>(GMT-01:00) Cape Verde Is.</option><option value='(GMT-02:00) Mid-Atlantic'>(GMT-02:00) Mid-Atlantic</option><option value='(GMT-03:00) Brasilia'>(GMT-03:00) Brasilia</option><option value='(GMT-03:00) Buenos Aires'>(GMT-03:00) Buenos Aires</option><option value='(GMT-03:00) Cayenne'>(GMT-03:00) Cayenne</option><option value='(GMT-03:00) Greenland'>(GMT-03:00) Greenland</option><option value='(GMT-03:00) Montevideo'>(GMT-03:00) Montevideo</option><option value='(GMT-03:30) Newfoundland'>(GMT-03:30) Newfoundland</option><option value='(GMT-04:00) Asuncion'>(GMT-04:00) Asuncion</option><option value='(GMT-04:00) Atlantic Time (Canada)'>(GMT-04:00) Atlantic Time (Canada)</option><option value='(GMT-04:00) Georgetown, La Paz, San Juan'>(GMT-04:00) Georgetown, La Paz, San Juan</option><option value='(GMT-04:00) Manaus'>(GMT-04:00) Manaus</option><option value='(GMT-04:00) Santiago'>(GMT-04:00) Santiago</option><option value='(GMT-04:30) Caracas'>(GMT-04:30) Caracas</option><option value='(GMT-05:00) Bogota, Lima, Quito'>(GMT-05:00) Bogota, Lima, Quito</option><option value='(GMT-06:00) Central America'>(GMT-06:00) Central America</option><option value='(GMT-06:00) Guadalajara, Mexico City, Monterrey - New'>(GMT-06:00) Guadalajara, Mexico City, Monterrey - New</option><option value='(GMT-06:00) Guadalajara, Mexico City, Monterrey - Old'>(GMT-06:00) Guadalajara, Mexico City, Monterrey - Old</option><option value='(GMT-06:00) Saskatchewan'>(GMT-06:00) Saskatchewan</option><option value='(GMT-07:00) Arizona'>(GMT-07:00) Arizona</option><option value='(GMT-07:00) Chihuahua, La Paz, Mazatlan - New'>(GMT-07:00) Chihuahua, La Paz, Mazatlan - New</option><option value='(GMT-07:00) Chihuahua, La Paz, Mazatlan - Old'>(GMT-07:00) Chihuahua, La Paz, Mazatlan - Old</option><option value='(GMT-07:00) Mountain Time (US & Canada)'>(GMT-07:00) Mountain Time (US & Canada)</option><option value='(GMT-08:00) Tijuana, Baja California'>(GMT-08:00) Tijuana, Baja California</option><option value='(GMT-09:00) Alaska'>(GMT-09:00) Alaska</option><option value='(GMT-10:00) Hawaii'>(GMT-10:00) Hawaii</option><option value='(GMT-11:00) Midway Island, Samoa'>(GMT-11:00) Midway Island, Samoa</option><option value='(GMT-12:00) International Date Line West'>(GMT-12:00) International Date Line West</option>

													</select>

                                    <!-- &nbsp; <span class="Required">!</span> --></td>
                                </tr>
                                
                                
                                <tr>
                                	<td colspan="3"><br />By checking this box you agree to the <a href="Terms.html" title="Terms & Conditions" rel="shadowbox">Terms & Conditions</a>     <input type="checkbox" name="Terms" class="TermsCheck" /></td>
                                </tr>
							</table>
                            </form>
                            <div style="clear: both ;"></div>
                            <br />
                            <div class="Button">
                                <a href="#" onclick="ValidateUserInfo();">
                                    <div class="Green_Btn">
                                        Step 3
                                    </div>
                                </a>
                            </div>
                        </div>
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