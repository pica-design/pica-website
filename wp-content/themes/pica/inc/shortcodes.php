<?php
	/*********************************
	SHORTCODES
	*********************************/	
	add_shortcode('employee-bios', 'employee_bio_shortcode');
	function employee_bio_shortcode () {
		global $post;


			?>
			<div class='clear'></div>
			<div class="about-employee-profile">
                    <!--//For the owner-->
                    <?php $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => 'principal'
                     ); ?>

                     <?php $employees = get_users( $args ); ?> 
                     <?php foreach ($employees as $employee) : ?>
                            <?php $user_meta = get_user_meta($employee->ID); ?>
                            <div class="employee-profile">
                                <?php echo get_avatar($employee->ID, $size = '195', $default = '', $alt = false)?>  
                                    <strong><?php echo $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0] ?></strong>
                                    <br>
                                    <small>Principal & Creative Director</small>
                                    <br>
                                    <br>
                                    <?php echo $user_meta['description'][0] ?>
                            </div>
                     <?php endforeach; ?>
                     <?php wp_reset_query(); ?>
                    
                    <!--//For the art director-->
                     <?php $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => 'art_director'
                     ); ?>

                     <?php $employees = get_users( $args ); ?> 
                     <?php foreach ($employees as $employee) : ?>
                            <?php $user_meta = get_user_meta($employee->ID); ?>
                            <div class="employee-profile">
                                <?php echo get_avatar($employee->ID, $size = '195', $default = '', $alt = false)?>  
                                    <strong><?php echo $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0] ?></strong>
                                    <br>
                                    <small>Art Director</small>
                                    <br>
                                    <br>
                                    <?php echo $user_meta['description'][0] ?>
                            </div>
                     <?php endforeach; ?>
                     <?php wp_reset_query() ?>

                     <!--//For the art director-->
                     <?php $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => 'senior_web'
                     ); ?>

                     <?php $employees = get_users( $args ); ?> 
                     <?php foreach ($employees as $employee) : ?>
                            <?php $user_meta = get_user_meta($employee->ID); ?>
                            <div class="employee-profile">
                                <?php echo get_avatar($employee->ID, $size = '195', $default = '', $alt = false)?>  
                                    <strong><?php echo $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0] ?></strong>
                                    <br>
                                    <small>Senior Web Developer</small>
                                    <br>
                                    <br>
                                    <?php echo $user_meta['description'][0] ?>
                            </div>
                     <?php endforeach; ?>
                     <?php wp_reset_query() ?>

                     <!--//For the art director-->
                     <?php $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => 'junior_web'
                     ); ?>

                     <?php $employees = get_users( $args ); ?> 
                     <?php foreach ($employees as $employee) : ?>
                            <?php $user_meta = get_user_meta($employee->ID); ?>
                            <div class="employee-profile">
                                <?php echo get_avatar($employee->ID, $size = '195', $default = '', $alt = false)?>  
                                    <strong><?php echo $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0] ?></strong>
                                    <br>
                                    <small>Junior Web Developer</small>
                                    <br>
                                    <br>
                                    <?php echo $user_meta['description'][0] ?>
                            </div>
                     <?php endforeach; ?>
                     <?php wp_reset_query() ?>

                     <!--//For the art director-->
                     <?php $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => 'impact_architect'
                     ); ?>

                     <?php $employees = get_users( $args ); ?> 
                     <?php foreach ($employees as $employee) : ?>
                            <?php $user_meta = get_user_meta($employee->ID); ?>
                            <div class="employee-profile">
                                <?php echo get_avatar($employee->ID, $size = '195', $default = '', $alt = false)?>  
                                    <strong><?php echo $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0] ?></strong>
                                    <br>
                                    <small>Impact Architect</small>
                                    <br>
                                    <br>
                                    <?php echo $user_meta['description'][0] ?>
                            </div>
                     <?php endforeach; ?>
                     <?php wp_reset_query() ?>
                
                </div>
                <?php
	}

?>