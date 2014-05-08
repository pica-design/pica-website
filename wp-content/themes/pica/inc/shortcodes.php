<?php
	/*********************************
	SHORTCODES
	*********************************/	
	add_shortcode('employee-bios', 'employee_bio_shortcode');
	function employee_bio_shortcode () {
		global $post;


			?>
			<?php $htmlStr = '<div class="clear"></div>';
			      $htmlStr .= '<div class="about-employee-profile">';

                    $pica_roles = array('principal', 'art_director', 'web_developer', 'impact_architect', 'dot_connector'); ?>
                    
                    <?php foreach($pica_roles as $role):?>
                        <?php $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => $role
                     ); ?>
                        
                        <?php //print_r(get_role( $role )); ?>
                     <?php $employees = get_users( $args ); ?> 
                     <?php foreach ($employees as $employee) : ?>
                            <?php $user_meta = get_user_meta($employee->ID); ?>
                            <?php $htmlStr .= '<div class="employee-profile"><strong>'; ?>
                                <?php $htmlStr .= get_avatar($employee->ID, $size = '195', $default = '', $alt = false) . '<br>' ?>  
                                    <?php $htmlStr .= $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0] ?>
                                    <?php $htmlStr .= '</strong><br>'; ?>
                                    <?php $user_role = $employee->roles[0]; ?>
                                    <?php $htmlStr .= '<small>'; ?>
                                    <?php global $wp_roles; 
                                            $htmlStr .= $wp_roles->role_names[$user_role];  ?>
                                    <?php $htmlStr .= '</small><br><br>'; ?>
                                    <?php $htmlStr.= $user_meta['description'][0] ?>
                            <?php $htmlStr .= '</div>'; ?>
                     <?php endforeach; ?>
                     <?php wp_reset_query(); ?>
                    <?php endforeach; ?>
                
                <?php $htmlStr .= '</div>'; return $htmlStr;?>
                <?php
	}

?>