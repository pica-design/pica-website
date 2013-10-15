<?php
	//Gather the signoff id
	$i = $_REQUEST['i'];
	
	//Attach our gateway
	include("../tech/gateway.php");
	
	//Select the Sign-Off and accompanying Client information
	$approvalData = sqlSELECT("* FROM approvals WHERE approval_id = $i", 0);
	$clientId = sqlSELECT("client_id FROM client_approvals WHERE approval_id = $i", 0) ;
	$clientId = $clientId[0]['client_id'];
	$clientData = sqlSELECT("* FROM clients WHERE client_id = $clientId", 0) ;
	$signOffFiles = sqlSELECT("* FROM approval_files WHERE approval_id = $i", 0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Pica Design, LLC. | Generated Sign-Off PDF Template</title>
        <style type="text/css">
			@page {
				margin: 25px 0 0 20px ;
			}
			body {
				width: 100% ;
				height: 100% ;
				padding: 0px ;
				margin: 0px ;
			}
				a {
					color: #275270 ;
					font-weight: bold ;
					text-decoration: none ;
				}
					a:hover {
						text-decoration: underline ;
					}
				div#approval-header {
					font-size: 18px ;
					font-weight: bold ;
					color: #275270 ;
					font-family: Georgia, "Times New Roman", Times, serif ;
				}
				#content {
					font-size: 1em ;
					padding: 25px 80px 0 80px ;
				}
					#pica-logo {
						margin: 0 0 0 0 ;
					}
				#footer {
					position: absolute ; 
					top: 950px ;
					left: 80px ;
					font-family: Arial, Helvetica, sans-serif ;
					font-size: 12px ;
				}
				.blue {
					color: #56A1D5 ;
				}
		</style>
    </head>
    
    <body>
    	<div id="content">
	        <img src="../media/Pica_10thAnniversary_FNL_print.jpg" width="60%" id="pica-logo" />
            <br /><br /><br /><br />
            <div id="approval-header">Project Approval Sign-Off</div>
            <br /><br />
            Job Number: <?php echo $approvalData[0]['approval_job'] ?>
            <br />
        	Signed On: <?php echo date("m/d/Y \a\\t g:i a \E\S\T", $approvalData[0]['approval_sign_date']) ?>
            <br />
            Signed By: <?php echo $approvalData[0]['approval_contact_name'] ?>
            <br />
            Client: <?php echo $clientData[0]['client_name'] ?>
            <br />
            Project Title: <?php echo $approvalData[0]['approval_title'] ?>
            <br />
            Project Description: <?php echo $approvalData[0]['approval_description'] ?>
            <br />
            <?php
				if (count($signOffFiles) > 0) {
					$key = 1;
					foreach ($signOffFiles as $file) {
						echo "Project File $key: <a href='$site_url/media/approval_files/{$file['file_name']}' target='_blank'>{$file['file_name']}</a><br />";
						$key++;
					}
				}
            ?>
        	<br />
            I, <?php echo $approvalData[0]['approval_contact_name'] ?>, representative of <?php echo $clientData[0]['client_name'] ?>, verify that the project "<?php echo $approvalData[0]['approval_title'] ?>" provided on <?php echo date("m/d/Y \a\\t g:i a \E\S\T", $approvalData[0]['approval_send_date']) ?> has been reviewed and approved for design, layout, copy and image placement to date and consider all design related work pertaining to the above project to be complete and authorize Pica Design, LLC to prepare and release all digital and material files to the Client's selected vendor(s) for printing, manufacturing and or internet publication. Also, any further modifications, additions or deletions to the design or content after this sign-off authorization for the above project will be considered new work and charged based on time + expenses.
        </div>
        <div id="footer">
        	P.O. Box 225 <span class="blue">/</span> 111 Chuch St. <span class="blue">/</span> Belfast, Maine 04915-0225
            <br />
            <strong>T:</strong> 207-338-1740 <span class="blue">/</span> <strong>F:</strong> 207-338-0899 <span class="blue">/</span> info@picadesign.com <span class="blue">/</span> www.picadesign.com 
        </div>
    </body>
</html>