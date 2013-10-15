<?php
	/*
		APPROVAL GENERATOR CLASS
	*/
	class Approval {
		//Approval Initilization
		public function __construct () {
			//We'll be using our database class
			global $db;
			$this->db = $db;

			//Instance Variables
			$this->success = false;
			$this->error = false;
			$this->preview = false;
			$this->html_message = "";
		}//END @Approval Instance Initilization
		
		public function setup_new_approval () {
			//lets prepare our approval variables
			$this->approval_job = '';
			$this->approval_contact_name = '';
			$this->approval_contact_email = '';
			$this->approval_title = '';
			$this->approval_description = '';
			$this->approval_send_date = time();
			$this->approval_sign_date = 0;
			$this->approval_sender_email = '';
			$this->approval_feedback = '';
			$this->approval_client_name = '';
		}

		public function populate_approval_from_post () {
			//Populate Approval data from the send approval POST form submission
	        foreach ($_POST as $field_name => $field_value) :
	            $this->$field_name = $field_value;
	        endforeach;
		}

		public function fetch_saved_approval ($approval_id) {
			//Select all approval, client, and file data for the given approval id
			$approval_data = $this->db->select("
				SELECT *
				FROM approvals 
				JOIN client_approvals ON (client_approvals.client_id = approvals.approval_id)
				JOIN clients ON (clients.client_id = client_approvals.client_id)
				WHERE approvals.approval_id = {$approval_id}
			", 0);

			//Populate our object with the fetched approval data
			foreach ($approval_data[0] as $approval_datum_key => $approval_datum) :
				$this->$approval_datum_key = $approval_datum;
			endforeach;

			$approval_files = $this->db->select("SELECT * FROM approval_files WHERE approval_id = $approval_id", 0);
			if (count($approval_files) > 0) {
				foreach ($approval_files as $file) {
					$this->approval_files[] = $file;	
				}
			}
		}

		/*------------------------------
		
			APPROVAL DATABASE STORAGE
		*/
		public function store_approval () {	
			global $db, $working_dir;
			//Save the client information
			$db->insert("INSERT INTO clients VALUES('','$this->approval_client_name', '$this->approval_contact_email')", 0) ;	
			$this->client_id = mysql_insert_id();
			
			//Store the Project Approval Information
			if ($this->preview) :
				//If this is a preview the only differenece is that we set a 0 send_date so we know it has not been sent
				$this->approval_send_date = 0;
			endif;

			$db->insert("INSERT INTO approvals VALUES('', '$this->approval_job', '$this->approval_contact_name', '$this->approval_contact_email', '$this->approval_title', '$this->approval_description', $this->approval_send_date,'','$this->approval_sender_email','')", 0);
			$this->approval_id = mysql_insert_id();
			//Store the relationship between the client and the project approval
			$db->insert("INSERT INTO client_approvals VALUES($this->client_id, $this->approval_id)", 0);
			//Store any uploaded project files
			if (count($_FILES) > 0 ) {
				foreach ($_FILES as $file) {
					$filename = str_replace(" ", "_", $file['name']);
					move_uploaded_file($file['tmp_name'], $working_dir . '/media/approval_files/' . $filename);
					$db->insert("INSERT INTO approval_files VALUES('', $this->approval_id, '$filename')", 0);
				}
			}
		}//END store_approval method @Approval CLass
		
		
		
		/*------------------------------
		
			SIGN-OFF HTML EMAIL CREATION
				
		*/
		public function generate_html_email () {
			global $site_url;
			//Generate the html email
			//This should be pulled out into a php / html page and fed variables via get, including via file open or something
			$this->html_message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
				<html>
				<body style='margin: 0px ; padding: 0px; background-color: #ffffff; '>
					<table cellpadding='0' cellspacing='10' border='0' width='600px'>
						<tr>
							<td style='color: #000000;'>
								<span style='color: #000000; font-family: Arial; font-size: 18px;'>Pica Design Project Approval</span>
								<br /><br />
								<table cellpadding='5'>
									<tr>
										<td style='background-color: #eaeaea;' width='90px'><strong style='color: #5f5e5e;'>Client:</strong></td><td style='background-color: #eaeaea;'>$this->approval_client_name</td>
									</tr><tr>
										<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Project Title:</strong></td><td style='background-color: #eaeaea;'>$this->approval_title</td>
									</tr><tr>
										<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Project<br />Description:</strong></td><td valign='top' style='background-color: #eaeaea;'>$this->approval_description</td>
									</tr><tr>
										<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Provided On:</strong></td><td style='background-color: #eaeaea;'>".date("m/d/Y \a\\t g:i a \E\S\T", $this->approval_send_date)."</td>
									</tr>
								";
						if (count($_FILES) > 0 ) {
							$key = 1;
							foreach ($_FILES as $file) {
								$filename = str_replace(" ", "_", $file['name']);
								$this->html_message .= "
									<tr>
										<td style='background-color: #eaeaea;'><strong style='color: #5f5e5e;'>Project File $key:</strong></td><td style='background-color: #eaeaea;'><a href='$site_url/media/approval_files/$filename' style='color: #000000;'>$filename</a></td>
									</tr>";
									$key++;
							}//end foreach files
						}//end check for files
						$this->html_message .= "
									<tr>
										<td colspan='2' style='background-color: #eaeaea; padding: 10px;'>
											I, $this->approval_contact_name, representative of $this->approval_client_name, verify that the project $this->approval_title provided on " . date("m/d/Y \a\\t g:i a \E\S\T", $this->approval_send_date) . " has been reviewed and approved for design, layout, copy and image placement to date and consider all design related work pertaining to the above project to be complete and authorize Pica Design, LLC to prepare and release all digital and material files to the Client's selected vendor(s) for printing, reproduction, manufacturing and or internet publication. Also, any further modifications, additions or deletions to the design or content after this sign-off authorization for the above project will be considered new work and charged based on time + expenses. <br /><br />By clicking 'Approve Project' below I acknowledge my approval of the above project on behalf of $this->approval_client_name.
										</td>
									</tr>
									<tr>
										<td><a href='$site_url/approve/?approval_id={$this->approval_id}' title='Give Approval'><img src='$site_url/media/ApproveProject_button.png' alt='Project Approval Button' border='0' /></a></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='color: #5f5e5e; font-size: 12px;'>
								<br /><br /><br /><br />
								<a href='http://www.picadesign.com' title='Visit Pica Design'><img src='$site_url/media/pica-logo-small.jpg' alt='Pica Design, LLC. Logo' border='0' /></a>
								<br /><br />
								P.O. Box 225 <span style='color: #5193c7;'>/</span> 111 Chuch St <span style='color: #5193c7;'>/</span> Belfast, Maine 04915-0225
								<br />
								<strong>T</strong> 207.338.1740 <span style='color: #5193c7;'>/</span> <strong>F</strong> 207.338.0899 <span style='color: #5193c7;'>/</span> <a href='mailto:info@picadesign.com' title='Email Pica Design' style='color: #5f5e5e; font-size: 12px;'>info@picadesign.com</a> <span style='color: #5193c7;'>/</span> <a href='http://www.picadesign.com' title='Visit Pica Design' style='color: #5f5e5e; font-size: 12px;'>www.picadesign.com</a>
							</td>
						</tr>
					</table>
				</body></html>
			";
		}//END generate_html_emiail method @Approval CLass
		
		
		
		/*------------------------------
		
			EMAIL SENDING via PHPMailer Library
			
		*/
		public function send_approval () {
			require_once '../tech/PHPMailer_5.2.0/class.phpmailer.php';
			$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
			try {
				
				/*
					+ Send a copy to the client 
					+ Send a copy to the pica staff member who initiated the signoff
					+ Send a copy to approval@picadesign.com for archival
				*/
				if ($this->preview) :
					$this->recipients = array( array($this->approval_sender_email, 'Pica Design, LLC.') );
					$this->subject = 'PREVIEW - Project Approval Request: Job Number ' . $this->approval_job;
				else :
					$this->recipients = array(
						array($this->approval_contact_email, $this->approval_client_name),
						array($this->approval_sender_email, 'Pica Design, LLC.'),
						array('approval@picadesign.com', 'Pica Approval Archive')
					);
					$this->subject = 'Project Approval Request: Job Number ' . $this->approval_job;
				endif;
				
				//print_r($this);

				//Attach the email recipients to the mail class
				foreach ($this->recipients as $recipient) :
					$mail->AddAddress($recipient[0], $recipient[1]);
				endforeach;
				//Setup the email from and reply-to addresses
				$mail->AddReplyTo('approval@picadesign.com', 'Pica Design, LLC.');
				$mail->SetFrom('approval@picadesign.com', 'Pica Design, LLC.');
				//Setup the email subject and body
				$mail->Subject = $this->subject;
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML($this->html_message);
				//Setup and attach the email file attachments
				if (count($_FILES) > 0 ) :
					foreach ($_FILES as $file) :
						if ($file['name'] != "") :
							$filename = str_replace(" ", "_", $file['name']);
							$mail->AddAttachment('../media/approval_files/' . $filename);      // attachment
						endif;
					endforeach;
				endif;
				//echo "FOOO";
				//Send the html email
				$mail->Send();
				//Populate any success or error messages
				$this->success = true;
			} catch (phpmailerException $e) {
				$this->error = $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				$this->error = $e->getMessage(); //Boring error messages from anything else!
			}
		}//END send_approval method @Approval CLass

	}//END Approval Class
?>