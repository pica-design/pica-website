<?php
	/*********************************
	USER ADDITIONS
	*********************************/	
	//We're going to add our new 'title' field directly before the password fields
		//This isn't really the best method - but it's the only one to get our field adjecent to the user bio
	add_filter('show_password_fields', 'add_user_title', 10,1);
	add_action( 'personal_options_update', 'save_additional_user_fields' );
	add_action( 'edit_user_profile_update', 'save_additional_user_fields' );
	
	function add_user_title () {
		global $user_id;
		?>
        <tr>
        	<th><label for="user-title">Title</label></th>
        	<td>
            	
                <input type="text" name="user-title" id="user-title" value="<?php echo esc_attr( get_the_author_meta( 'user-title', $user_id ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your title.</span>
                        
            </td>
        </tr>
        <?php
		
		//If we don't return true the user password fields will no display
		return true;
	}	
	
	//Save the user meta data (including our new 'title' field)
	function save_additional_user_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		update_usermeta( $user_id, 'user-title', $_POST['user-title'] );
	}
?>