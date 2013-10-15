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
        <title>Pica Approval - Manage</title>
		<link rel="stylesheet" href="stylesheets/style.css" />
    </head>
    <body>
    	<nav>
        	<div id="nav-contents">
                <img src="../media/pica-logo-small.jpg" alt="Pica Mark" id="pica-logo" />
                <ul>
                    <li><a href="index.php" class="active">Manage Approvals</a></li>
                    <li><a href="create.php">Create New Approval</a></li>
                </ul>
            </div>
    	</nav>
        <section id="content">
            <table>
                <thead>
                	<tr>
                        <th>Status</th>
                    	<th width="60px">Job #</th>
                        <th>Sent By</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th width="170px">Sent on</th>
                        <th width="170px">Approved On</th>
                        <th>Contact</th>
                        <th>Contact Email</th>
                        <th>Feedback</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    				//Once included we can access the new global $db object
    				include_once('../tech/database.class.php');
    				$approvals = $db->select("SELECT * FROM approvals ORDER BY approval_id DESC", 0);
    				//print_r($approvals);
    				//Loop through and display all the sent approvals (Approved and Unapproved alike)
    				foreach ($approvals as $approval) :
    					//print_r($approval);
    					if ($approval['approval_sign_date'] != 0) : $approval_class = "approved";
    					else : $approval_class = "not-approved"; endif;
    				
    					?>
                        <tr class="<?php echo $approval_class ?>">
                            <td><?php 
                                if ($approval['approval_send_date'] != 0) : 
                                    if ($approval['approval_sign_date'] != 0) : 
                                        echo "Approved";
                                    else : 
                                        //echo "Sent <br /> <a href='edit.php?approval_id={$approval['approval_id']}' title='Resend'>Resend</a>";
                                        echo "Sent";
                                    endif;
                                else : 
                                    echo "Draft <br /> <a href='edit.php?approval_id={$approval['approval_id']}' title='Edit Draft'>Edit</a>";
                                endif;
                                ?>
                            </td>
                        	<td><?php echo $approval['approval_job'] ?></td>
                            <td><?php 
                                $sender = explode('@', $approval['approval_sender_email']);
                                echo ucfirst($sender[0]);
                            ?></td>
                            <td><?php echo $approval['approval_title'] ?></td>
                            <td><?php echo $approval['approval_description'] ?></td>
                            <td><?php 
                                if ($approval['approval_send_date'] != 0) : 
                                    echo date('D M j, Y \a\t g:ia', $approval['approval_send_date']) ;
                                else : 
                                    echo "Not sent yet.";
                                endif;
                                ?>
                            </td>
                            <td><?php 
                                if ($approval['approval_sign_date'] != 0) : 
                                    echo date('D M j, Y \a\t g:ia', $approval['approval_sign_date']) ;
                                else : 
                                    echo "Not approved yet";
                                endif;
                                ?>
                            </td>
                            <td><?php echo $approval['approval_contact_name'] ?></td>
                            <td><a href="mailto:<?php echo $approval['approval_contact_email'] ?>" title="Email <?php echo $approval['approval_contact_name'] ?>"><?php echo $approval['approval_contact_email'] ?></a></td>
                            <td><?php echo $approval['approval_feedback'] ?></td>
                            <td>
                                <?php
                                    $pdf_filename = $approval['approval_job'] . "_Approval.pdf";
                                ?>
                                <a href='<?php echo $site_url ?>/media/signed_approvals/<?php echo $pdf_filename ?>' target="_blank"><?php echo $pdf_filename ?></a>
                            </td>
                        </tr>
                        <?php
    				endforeach;
    			?>
                </tbody>
            </table>
        </section>
    </body>
</html>
