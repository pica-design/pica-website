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
	var senderEmailError = true
	var recipientEmailError = true
	var clientNameError = true
	var contactNameError = true
	var jobNumberError = true
	var projectTitleError = true
	var password = true
	//Attach our validation runtime to the signoff form
	$('#send_approval_form').submit(function(e){
		//Reset any previous form field errors | They will be set again if the field still fails validation
		$(this).find('input').removeClass('formFieldError')
		//-------------- EMAIL VALIDATION ------------------//
		var emailPattern = "[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])";
		var emailRegExp = new RegExp(emailPattern,"");
		//Test the sender email address
		if (!emailRegExp.test($(this).find('input[name=senderEmail]').val())) {
			$(this).find('input[name=senderEmail]').addClass('formFieldError')
		} else { senderEmailError = false }
		//Test the recipient email address
		if (!emailRegExp.test($(this).find('input[name=contactEmail]').val())) {
			$(this).find('input[name=contactEmail]').addClass('formFieldError')
		} else { recipientEmailError = false }
		//-------------- EMPTY FIELDS CHECK ---------------//
		//Test for a value in the Contact Name field
		if ($(this).find('input[name=contactName]').val() == "") {
			$(this).find('input[name=contactName]').addClass('formFieldError')
		} else { contactNameError = false }
		//Test for a value in the Client Name field
		if ($(this).find('input[name=clientName]').val() == "") {
			$(this).find('input[name=clientName]').addClass('formFieldError')
		} else { clientNameError = false }
		//Test for a value in the Job Number field
		if ($(this).find('input[name=jobNumber]').val() == "") {
			$(this).find('input[name=jobNumber]').addClass('formFieldError')
		} else { jobNumberError = false }
		//Test for a value in the Project Title field
		if ($(this).find('input[name=projectTitle]').val() == "") {
			$(this).find('input[name=projectTitle]').addClass('formFieldError')
		} else { projectTitleError = false }
		//Keep the form from submitting to display errors
		if (senderEmailError || recipientEmailError || contactNameError || clientNameError || jobNumbererror || projectTitleError || passwordError) {
			return false
		}
	})
})