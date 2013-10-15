jQuery(function($) {
	//File Input Controller
		//Append the first file input field
	var file_input_count = 0
	var file_input_table = '<table class="file_input_table"><tr><td valign="top" width="225px"><input type="file" name="projectFile-' + file_input_count + '" /></td><td><div class="add_file"><a class="file_link">+</a></div></td></tr></table>'
	$('#file_inputs').append(file_input_table)
	//Add a new file input field
	$('.add_file .file_link').click(function(e){
		e.preventDefault()					
		file_input_count++;
		var secondary_file_input_table = '<table class="file_input_table"><tr><td valign="top" width="225px"><input type="file" name="projectFile-' + file_input_count + '" /></td><td><div class="remove_file"><a class="file_link">-</a></div></td></tr></table>'
		$('#file_inputs').append(secondary_file_input_table);
	})
	//Remove a file input field
	$('.remove_file .file_link').live('click', function(e){
		e.preventDefault()
		$(this).parent().parent().parent().parent().parent().remove()
	})
	//----------------- FORM INPUT VALIDATION ------------//
	/*
		Initially we set a flag for all fields to fail form submittion
		Upon entering proper values into each form field; each field flag is set to true (allowing submittion for their field)
		Not until all fields are set the true will form submit
	*/
	//Form Field Validation Failure Flags
	var approval_sender_emailError = true
	var recipientEmailError = true
	var approval_client_nameError = true
	var approval_contact_nameError = true
	var approval_jobError = true
	var approval_titleError = true

	//Attach our validation runtime to the signoff form
	$('#send_approval_form').submit(function(e){
		//Reset any previous form field errors | They will be set again if the field still fails validation
		$(this).find('input').removeClass('formFieldError')
		//-------------- EMAIL VALIDATION ------------------//
		var emailPattern = "[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])";
		var emailRegExp = new RegExp(emailPattern,"");
		
		//Test the sender email address
		if (!emailRegExp.test($(this).find('input[name=approval_sender_email]').val())) {
			$(this).find('input[name=approval_sender_email]').addClass('formFieldError')
		} else { approval_sender_emailError = false }
		//Test the recipient email address
		if (!emailRegExp.test($(this).find('input[name=approval_contact_email]').val())) {
			$(this).find('input[name=approval_contact_email]').addClass('formFieldError')
		} else { recipientEmailError = false }
		
		//-------------- EMPTY FIELDS CHECK ---------------//
		//Test for a value in the Contact Name field
		if ($(this).find('input[name=approval_contact_name]').val() == "") {
			$(this).find('input[name=approval_contact_name]').addClass('formFieldError')
		} else { approval_contact_nameError = false }
		//Test for a value in the Client Name field
		if ($(this).find('input[name=approval_client_name]').val() == "") {
			$(this).find('input[name=approval_client_name]').addClass('formFieldError')
		} else { approval_client_nameError = false }
		//Test for a value in the Job Number field
		if ($(this).find('input[name=approval_job]').val() == "") {
			$(this).find('input[name=approval_job]').addClass('formFieldError')
		} else { approval_jobError = false }
		//Test for a value in the Project Title field
		if ($(this).find('input[name=approval_title]').val() == "") {
			$(this).find('input[name=approval_title]').addClass('formFieldError')
		} else { approval_titleError = false }
		
		//Keep the form from submitting or being previewed so we can display errors
		if (approval_sender_emailError || recipientEmailError || approval_contact_nameError || approval_client_nameError || approval_jobError || approval_titleError) {
			e.preventDefault()
			return false
		}
		
		//K, we're clear the gauntlet of form submission
		/*
		//If the approval is being previewed; halt submission and instead send the user a preview of the form
		var trigger_el_id = e.originalEvent.explicitOriginalTarget.attributes.id.value
		switch (trigger_el_id) {
			case "submitbutton": break
			case "previewbutton":
				e.preventDefault()
				preview_approval_form($(this), $('#previewbutton'))
			break
		}
		*/
	})
	
	/*
	function preview_approval_form (oForm, oTrigger) {
		$(oTrigger).val('Hang on, sparky..')
		$.post("../tech/gateway.php?a=preview", $(oForm).serialize(), function(returned) {
			$('#previewbutton')
				.val('K, check your email')
				.animate({ color: '#000000' }, 5000, 'linear', function() {
					$('#previewbutton').val('Send me a Preview')
				})
		})
	}
	*/
})