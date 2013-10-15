<?php

	
	/*
		 ____  _             ____  _                    ___   __  __ 
		|  _ \(_) ___ __ _  / ___|(_) __ _ _ __        / _ \ / _|/ _|
		| |_) | |/ __/ _` | \___ \| |/ _` | '_ \ _____| | | | |_| |_ 
		|  __/| | (_| (_| |  ___) | | (_| | | | |_____| |_| |  _|  _|
		|_|   |_|\___\__,_| |____/|_|\__, |_| |_|      \___/|_| |_|  
									 |___/                           

		This sign-off tool is composed of a few pieces.
			+ gateway.php is the database and settings gateway. Here is where you can control which db this tool uses (change for local or remote use)
			+ index.php (landing page) is used to send an approval request to the client
				+ The signoff form only submits if the correct password is entered (spamban) password: picapica
			+ signoff.php is used display an approval confirmation form.
				+ It then generates the signoff pdf and emails it to the client (upon them signing the approval)
					+ The pdf is generated with dompdf
						+ The raw html (prior to pdf conversion) is located in pdf-template.php (so you can easily update the pdf in the future)
				+ A feedback form is then displayed
	*/
	
	
	//Make sure the remote server is set to local EST time for date display
	date_default_timezone_set('America/New_York');
	
	//Include our DB and Variable Gateway
	include("../tech/gateway.php");
	
	//Prepare some variables for use in our script
	$success = false;
	$error = false;
	
	/*---------------------------------
		
		PROCCESS SIGN OFF CREATION FORM AFTER SUBMISSION
		
	*/
	if ($_POST) {
		/*------------------------------
		
			SIGNOFF DATABASE STORAGE
		*/
		sqlINSERT("clients VALUES('','{$_POST['clientName']}', '{$_POST['contactEmail']}')", 0) ;	
		$clientId = mysql_insert_id();
		
		$approval_send_date = time();
		//Store the Job SignOff Information
		sqlINSERT("approvals VALUES('', '{$_POST['jobNumber']}', '{$_POST['contactName']}', '{$_POST['contactEmail']}', '{$_POST['projectTitle']}', '{$_POST['projectDescription']}', $approval_send_date,'','{$_POST['senderEmail']}','')", 0);
		$signOffId = mysql_insert_id();
		
		//Store the relationship between the client and the signoff
		sqlINSERT("client_approvals VALUES($clientId, $signOffId)", 0);
		
		//Store any uploaded project files
		if (count($_FILES) > 0 ) {
			foreach ($_FILES as $file) {
				$filename = str_replace(" ", "_", $file['name']);
				move_uploaded_file($file['tmp_name'], $working_dir . '/media/approval_files/' . $filename);
				sqlINSERT("approval_files VALUES('', $signOffId, '$filename')", 0);
			}
		}
		
		
		/*------------------------------
		
			SIGN-OFF HTML EMAIL CREATION
				
		*/
		$htmlMessage = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
			<html>
			<body style='margin: 0px ; padding: 0px; background-color: #ffffff; '>
				<table cellpadding='0' cellspacing='10' border='0' width='600px'>
					<tr>
						<td style='color: #000000;'>
							<span style='color: #000000; font-family: Arial; font-size: 18px;'>Pica Design Project Approval</span>
							<br /><br />
							<table cellpadding='5'>
								<tr>
									<td style='background-color: #eaeaea;' width='90px'><strong style='color: #5f5e5e;'>Client:</strong></td><td style='background-color: #eaeaea;'>{$_POST['clientName']}</td>
								</tr><tr>
									<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Project Title:</strong></td><td style='background-color: #eaeaea;'>{$_POST['projectTitle']}</td>
								</tr><tr>
									<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Project<br />Description:</strong></td><td valign='top' style='background-color: #eaeaea;'>{$_POST['projectDescription']}</td>
								</tr><tr>
									<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Provided On:</strong></td><td style='background-color: #eaeaea;'>".date("m/d/Y \a\\t g:i a \E\S\T", $approval_send_date)."</td>
								</tr>
							";
					if (count($_FILES) > 0 ) {
						$key = 1;
						foreach ($_FILES as $file) {
							$filename = str_replace(" ", "_", $file['name']);
							$htmlMessage .= "
								<tr>
									<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Project File $key:</strong></td><td style='background-color: #eaeaea;'><a href='$site_url/media/approval_files/$filename' style='color: #000000;'>$filename</a></td>
								</tr>";
								$key++;
						}//end foreach files
					}//end check for files
					$htmlMessage .= "
								<tr>
									<td colspan='2' style='background-color: #eaeaea; padding: 10px;'>
										I, {$_POST['contactName']}, representative of {$_POST['clientName']}, verify that the project {$_POST['projectTitle']} provided on " . date("m/d/Y \a\\t g:i a \E\S\T", $approval_send_date) . " has been reviewed and approved for design, layout, copy and image placement to date and consider all design related work pertaining to the above project to be complete and authorize Pica Design, LLC to prepare and release all digital and material files to the Client's selected vendor(s) for printing, reproduction, manufacturing and or internet publication. Also, any further modifications, additions or deletions to the design or content after this sign-off authorization for the above project will be considered new work and charged based on time + expenses. <br /><br />By clicking 'Approve Project' below I acknowledge my approval of the above project on behalf of {$_POST['clientName']}.
									</td>
								</tr>
								<tr>
									<td><a href='$site_url/approve/?i=$signOffId' title='Give Approval'><img src='$site_url/media/ApproveProject_button.png' alt='Project Approval Button' border='0' /></a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style='color: #5f5e5e; font-size: 12px;'>
							<br /><br /><br /><br />
							<a href='http://www.picadesign.com' title='Visit Pica Design'><img src='$site_url/media/Pica_Single_RGB.png' alt='Pica Design, LLC. Logo' border='0' /></a>
							<br /><br />
							P.O. Box 225 <span style='color: #5193c7;'>/</span> 111 Chuch St <span style='color: #5193c7;'>/</span> Belfast, Maine 04915-0225
							<br />
							<strong>T</strong> 207.338.1740 <span style='color: #5193c7;'>/</span> <strong>F</strong> 207.338.0899 <span style='color: #5193c7;'>/</span> <a href='mailto:info@picadesign.com' title='Email Pica Design' style='color: #5f5e5e; font-size: 12px;'>info@picadesign.com</a> <span style='color: #5193c7;'>/</span> <a href='http://www.picadesign.com' title='Visit Pica Design' style='color: #5f5e5e; font-size: 12px;'>www.picadesign.com</a>
						</td>
					</tr>
				</table>
			</body></html>
		";
		
		/*------------------------------
		
			EMAIL SENDING via PHPMailer Library
				+ Send a copy to the client 
				+ Send a copy to the pica staff member who initiated the signoff
				+ Send a copy to approval@picadesign.com for archival
		*/
		require_once '../tech/PHPMailer_5.2.0/class.phpmailer.php';
		$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
		try {
			$mail->AddAddress($_POST['contactEmail'], $_POST['clientName']);	
			$mail->AddAddress($_POST['senderEmail'], 'Pica Design, LLC.');  
			$mail->AddAddress('approval@picadesign.com', 'Pica Approval Archive');  
			$mail->AddReplyTo('approval@picadesign.com', 'Pica Design, LLC.');
			$mail->SetFrom('approval@picadesign.com', 'Pica Design, LLC.');
			$mail->Subject = 'Project Approval Request: Job Number ' . $_POST['jobNumber'];
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML($htmlMessage);
			if (count($_FILES) > 0 ) {
				foreach ($_FILES as $file) {
					$filename = str_replace(" ", "_", $file['name']);
					$mail->AddAttachment('../media/approval_files/' . $filename);      // attachment
				}
			}
			$mail->Send();
			$success = true;
		} catch (phpmailerException $e) {
			$error = $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			$error = $e->getMessage(); //Boring error messages from anything else!
		}
	}//END SIGNOFF CREATION FORM SUBMITTION
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Pica Design Project Approval</title>
        <link rel="stylesheet" href="../tech/style.css" />
        <!-- Load the jQuery Library for use in Form Validation -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript" src="../tech/controller.js"></script>
    </head>
    
    <body>
    	<div id="Content">
            <img src="../media/Pica_10thAnniversary_FNL.png" alt="Pica Design Logo" id="Logo"/>
            <br /><br />
			<?php if (!$_POST) : ?>
              <center><h1>Create Sign-Off</h1>
              <br />
              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" id="send_approval_form">
                <table>
                	<tr>
                    	<td align="right">Your Email:</td>
                        <td><input type="text" name="senderEmail" /></td>
                        <td width="5px"></td>
                	</tr><tr>
                    	<td align="right">Client Name:</td>
                        <td><input type="text" name="clientName" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Contact Name:</td>
                        <td><input type="text" name="contactName" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Contact Email:</td>
                        <td><input type="text" name="contactEmail" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Job Number:</td>
                        <td><input type="text" name="jobNumber" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Project Title:</td>
                        <td><input type="text" name="projectTitle" /></td>
                        <td></td>
                    </tr><tr>
                    	<td valign="top" align="right">Project Description:</td>
                        <td><textarea name="projectDescription"></textarea></td>
                        <td></td>
                    </tr><tr>
	                    <td align="right" valign="top">Project Files: <small>(Optional)</small></td>
                        <!-- jQuery above adds and manages the input fields that are appended to the following #file_inputs -->
                    	<td id="file_inputs" colspan="2"></td>
                    </tr><tr>
                    	<td align="right" colspan="3"><br /><input type="submit" value="Send Approval Email" id="submitbutton"/></td>
                    </tr>
                </table>
              </form>
              <?php
					endif;
					if ($success) :
				?>
                  <center><h1>Approval Requested!</h1>
                    <br />
                	An approval request for project #<?php echo $_POST['jobNumber'] ?> has been sent to <?php echo $_POST['contactEmail'] ?> for them to approve. 
                    <br /><br />
                    You will be notified when <?php echo $_POST['contactName'] ?> approves the project.
                    <br /><br />
                    A copy of the request email was also sent to you and to approval@picadesign.com.
                    <br /><br />
                <?php
					endif;
					if ($error) :
						echo "The Sign-Off failed to send with the following error: <br />";
						echo $error;
					endif;
				?>
              </center>
	    </div>
    </body>
</html>