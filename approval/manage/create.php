<?php
	//Make sure the remote server is set to local EST time for date display
	date_default_timezone_set('America/New_York');
	
	//Include our DB and Variable Gateway
	include_once("../tech/gateway.php");
	
	//Prepare some variables for use in our script
	$success = false;
	$error = false;
	
	/*---------------------------------
		
		PROCCESS SIGN OFF CREATION FORM AFTER SUBMISSION
		
	*/
	//Initilize our approval variable
	$approval = '';
	if (isset($_POST) && !empty($_POST)) :

        //print_r($_POST);
        //Instantiate a new approval object
        $approval = new Approval();
        
        //Send a preview if requested
        if (isset($_POST['send-approval-preview'])) : $approval->preview = true; endif;

        $approval->setup_new_approval();
        $approval->populate_approval_from_post();
        $approval->store_approval();
        $approval->generate_html_email();
        $approval->send_approval();
	endif;
?>
<!DOCTYPE HTML>
<html>
    <head>
    	<!--
             ____                            ____                                          
            /\  _`\   __                    /\  _`\                  __                    
            \ \ \L\ \/\_\    ___     __     \ \ \/\ \     __    ____/\_\     __     ___    
             \ \ ,__/\/\ \  /'___\ /'__`\    \ \ \ \ \  /'__`\ /',__\/\ \  /'_ `\ /' _ `\  
              \ \ \/  \ \ \/\ \__//\ \L\.\_   \ \ \_\ \/\  __//\__, `\ \ \/\ \L\ \/\ \/\ \ 
               \ \_\   \ \_\ \____\ \__/.\_\   \ \____/\ \____\/\____/\ \_\ \____ \ \_\ \_\
                \/_/    \/_/\/____/\/__/\/_/    \/___/  \/____/\/___/  \/_/\/___L\ \/_/\/_/
                                                                             /\____/       
                                                                             \_/__/
                                                                                                                                                         
            Graphic Design & Marketing | www.picadesign.com
        -->
        <meta charset="UTF-8">
        <title>Pica Design Project Approval</title>
        <link rel="stylesheet" href="stylesheets/style.css" />
        <!-- Load the jQuery Library for use in Form Validation -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../tech/controller.js"></script>
    </head>
    
    <body>
    	<nav>
        	<div id="nav-contents">
                <img src="../media/pica-logo-small.jpg" alt="Pica Mark" id="pica-logo" />
                <ul>
                    <li><a href="index.php">Manage Approvals</a></li>
                    <li><a href="create.php" class="active">Create New Approval</a></li>
                </ul>
            </div>
    	</nav>
        
        <section id="content">
			<?php if (!$_POST) : ?>
              <h1>Create Project Approval Request</h1>
              <br />
              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" id="send_approval_form">
                <table>
                	<tr>
                    	<td align="right">Your Email:</td>
                        <td><input type="text" name="approval_sender_email" /></td>
                        <td width="5px"></td>
                	</tr><tr>
                    	<td align="right">Client Name:</td>
                        <td><input type="text" name="approval_client_name" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Contact Name:</td>
                        <td><input type="text" name="approval_contact_name" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Contact Email:</td>
                        <td><input type="text" name="approval_contact_email" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Job Number:</td>
                        <td><input type="text" name="approval_job" /></td>
                        <td></td>
                    </tr><tr>
                    	<td align="right">Project Title:</td>
                        <td><input type="text" name="approval_title" /></td>
                        <td></td>
                    </tr><tr>
                    	<td valign="top" align="right">Project Description:</td>
                        <td><textarea name="approval_description"></textarea></td>
                        <td></td>
                    </tr><tr>
	                    <td align="right" valign="top">Project Files: <small>(Optional)</small></td>
                        <!-- jQuery above adds and manages the input fields that are appended to the following #file_inputs -->
                    	<td id="file_inputs" colspan="2"></td>
                    </tr><tr>
                    	<td colspan="3">
                            <!--<input type="submit" name="send-approval-preview" value="Send me a Preview and Save Draft" id="previewbutton" class="submit" />-->
                            <input type="submit" name="send-approval" value="Send Approval Email" id="submitbutton" class="submit" />
                        </td>
                    </tr>
                </table>
              </form>
              <?php
				endif; //if !$_POST
				
				if (is_object($approval)) :
					if ($approval->success) :
						if ($approval->preview) : 
                            ?>
                            <h1>Approval Preview Sent!</h1>
                            <br />
                            Check your inbox to preview the approval. <a href="edit.php?approval_id=<?php echo $approval->approval_id ?>" title="Edit Approval">Click here to edit your draft and send the approval.</a> 
                            <?php
                        else : 
                            ?>
    						<h1>Approval Request Sent!</h1>
    						<br />
    						An approval request for project #<?php echo $approval->approval_job ?> has been sent to <b><?php echo $approval->approval_contact_email ?></b> for them to approve. You will be notified when <?php echo $approval->approval_contact_name ?> approves the project.
    						<br /><br />
    						A copy of the request email was also sent to you and to approval@picadesign.com.
    						<br /><br />
    						<?php
                        endif;
					endif;
					if ($approval->error) : ?>
						The approval failed to send with the following error: 
                        <br />
						<div class='output'><?php echo str_replace(":", "", $approval->error) ?><div>
					<?php endif;
				endif;
			?>
	    </section>
    </body>
</html>