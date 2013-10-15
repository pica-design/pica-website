<?php
	/*------------------------------
		DATABASE lIBRARY & GLOBAL VARIABLE PREPERATION
	*/
	include("../tech/gateway.php");
	//Gather the signoff id and key
	$i = $_REQUEST['i'];
		
		
	/*------------------------------
		FEEDBACK FORM PROCESSING
	*/
	if ($_POST) {
		$approvalData = sqlSELECT("* FROM approvals WHERE approval_id = $i", 0);
		sqlUPDATE("approvals SET approval_feedback = '{$_POST['Feedback']}' WHERE approval_id = $i", 0);
		$htmlMessage = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
			<html>
			<body style='margin: 0px ; padding: 0px;'>
				<table cellpadding='10' cellspacing='0' border='0' width='100%'>
					<tr>
						<td>
							{$approvalData[0]['approval_contact_name']} from {$clientData[0]['client_name']} had this to say: 
							<br />
							<h4><em>'".stripslashes(stripslashes($_POST['Feedback']))."'</em></h4>
						</td>
					</tr>
				</table>
			</body></html>";
		require_once '../tech/PHPMailer_5.2.0/class.phpmailer.php';
		$mail = new PHPMailer(true);
		try {
			$mail->AddAddress($approvalData[0]['approval_sender_email'], 'Pica Design, LLC.');
			$mail->AddAddress('approval@picadesign.com', 'Pica Approval Archive');  
			$mail->AddReplyTo('approval@picadesign.com', 'Pica Design, LLC.');
			$mail->SetFrom('approval@picadesign.com', 'Pica Design, LLC.');
			$mail->Subject = "Project Approval Feedback: Job Number {$approvalData[0]['approval_job']}";
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
			$mail->MsgHTML($htmlMessage);
			$mail->Send();	
		} catch (phpmailerException $e) {
			$error = $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			$error = $e->getMessage(); //Boring error messages from anything else!
		}
	}//END FEEDBACK FORM PROCESSING
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Pica Design Project Approval</title>
        <link rel="stylesheet" href="../tech/style.css" />
    </head>
    
    <body>
        <div id="Content">
            <a href="http://www.picadesign.com" title="Pica Design, LLC.">
            <img src="../media/Pica_10thAnniversary_FNL.png" alt="Pica Design Logo" id="Logo"/>
            </a>
            <br /><br />            
			<?php
				//Select the Sign-Off and accompanying Client information
				if ($approvalData = sqlSELECT("* FROM approvals WHERE approval_id = $i", 0)) {
					$pdf_filename = "{$approvalData[0]['approval_job']}_Approval.pdf";
					//Make sure the signoff has not yet been signed
					if ($approvalData[0]['approval_sign_date'] == 0 || $approvalData[0]['approval_sign_date'] == "") {
						$clientId = sqlSELECT("client_id FROM client_approvals WHERE approval_id = $i", 0) ;
						$clientId = $clientId[0]['client_id'];
						$clientData = sqlSELECT("* FROM clients WHERE client_id = $clientId", 0) ;
						$signOffFiles = sqlSELECT("* FROM approval_files WHERE approval_id = $i", 0);
						//Update the sign-off record in the database to reflect the sign date		
						sqlUPDATE("approvals SET approval_sign_date = ".time()." WHERE approval_id = $i", 0);
						/*----------------------------
						PDF CREATION
						+ Create our pdf from the compiled html
						-----------------------------*/
						require_once("../tech/dompdf_6.0/dompdf_config.inc.php");
						$dompdf = new DOMPDF();
						$dompdf->load_html(file_get_contents("$site_url/approve/pdf-template.php?i=" . $_REQUEST['i']));
						$dompdf->set_paper('letter'); 
						$dompdf->render();
						$pdf_string = $dompdf->output(); // store the entire PDF as a string in $pdf_string
						/*----------------------------
						PDF FILE OUTPUT
						+ Write out the pdf to a file. 
						+ Ex: siteroot/wp-content/uploads/WCGH_Doctor_PDFS/WCGH_Doctor_PDF_01-07-2011-646pm.pdf
						-----------------------------*/		
						file_put_contents($working_dir . '/media/signed_approvals/' . $pdf_filename, $pdf_string);
						
						//Email Staff member + approval email archive letting them know the approval has been given						
						$htmlMessage = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
							<html>
							<body style='margin: 0px ; padding: 0px;'>
								<table cellpadding='10' cellspacing='0' border='0' width='100%'>
									<tr>
										<td>
											{$approvalData[0]['approval_contact_name']} from {$clientData[0]['client_name']} has approved project: {$approvalData[0]['approval_job']}. Attached is a copy of the approval PDF. 
										</td>
									</tr>
								</table>
							</body></html>";
						require_once '../tech/PHPMailer_5.2.0/class.phpmailer.php';
						$mail = new PHPMailer(true);
						try {
							$mail->AddAddress($approvalData[0]['approval_sender_email'], 'Pica Design, LLC.');
							$mail->AddAddress('approval@picadesign.com', 'Pica Approval Archive');  
							$mail->AddReplyTo('approval@picadesign.com', 'Pica Design, LLC.');
							$mail->SetFrom('approval@picadesign.com', 'Pica Design, LLC.');
							$mail->Subject = "Project Approval Received: Job Number {$approvalData[0]['approval_job']}";
							$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
							$mail->MsgHTML($htmlMessage);
							$mail->AddAttachment('../media/signed_approvals/' . $pdf_filename); // attachment
							$mail->Send();	
						} catch (phpmailerException $e) {
							$error = $e->errorMessage(); //Pretty error messages from PHPMailer
						} catch (Exception $e) {
							$error = $e->getMessage(); //Boring error messages from anything else!
						}
						?>
							<h1>Thank you for submitting your project approval.</h1>
							You can download a pdf copy of the approval here: <a href='<?php echo $site_url ?>/media/signed_approvals/<?php echo $pdf_filename ?>'><?php echo $pdf_filename ?></a>.
							<br /><br />
							Please let us know when we can be of service to you again!<br /><br /><br /><br />
							How did this project go? Please let us know what you think! <small>(Optional)</small>
							<br />
							<form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post'>
								<textarea name='Feedback' id='feedback'></textarea>
								<input type='hidden' name='i' value='<?php echo $i ?>' />
								<input type='hidden' name='FeedbackForm' value='true' />
								<br /><br />
								<input type='submit' value='Leave Feedback' id='feedback-submit'/>
							</form>
							<br />
							<small>info@picadesign.com<br />207-338-1740</small>
						<?php
					} else {
						//The signoff has already been signed
						if (!$_POST) {
							?>
								Project #<?php echo $approvalData[0]['approval_job'] ?> (<?php echo $approvalData[0]['approval_title'] ?>) has <b>already been approved</b> by <?php echo $approvalData[0]['approval_contact_name'] ?> on <?php echo date("m/d/Y \a\\t g:i a \E\S\T", $approvalData[0]['approval_sign_date']) ?>.
								<br /><br />
								You can <a href='<?php echo $site_url ?>/media/signed_approvals/<?php echo $pdf_filename ?>'>download a PDF copy of the approval</a>.
								<br /><br />
								If you feel you've reached this page in error please give us a call @ 207-338-1740. Thank you.
							<?php
						} else {
							//The signoff has been approved and the user has left some feedback, display a thank you. 
							echo "<em>Thanks {$approvalData[0]['approval_contact_name']}, <strong>your opinion means a lot to us!</strong></";
						}
					}
				} else {
					//There is no sign-off with that id
					echo "I was unable to select your signoff. <br />Please contact the Pica Team @ <b>207-338-1740</b>";
				}
            ?>
        </div>
    </body>
</html>