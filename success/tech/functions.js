// JavaScript Document
	var imagesToLoad
	var validity = true
	
	//On window load run any initilizations
	window.onload = function () {
		//imagesToLoad is defined in the child pages of this template, as to load different images for each
		if (imagesToLoad == undefined) {
		} else {
			if (imagesToLoad[0] != "") {
				new preLoader();
			}
		}
	}
		//Preload RollOver Button States
		function preLoader () {
			for (var i in imagesToLoad) {
				imageObj = new Image();
				imageObj.src = "../media/" + imagesToLoad[i]
			}
			
		}
	
	
	//USER INPUT VALIDATION
	
	function ValidateTemplateSelection () {
		var form = document.TemplateSelectionForm
		var radios = form.Template
		var validity = false
		
		for (var i = 0; i < radios.length; i++) {
			if (radios[i].checked == true) {
				validity = true	
			} 
		}
		if (validity) {
			form.submit()
		} else {
			document.getElementById('Error').style.display = "block"
			document.getElementById('Error').innerHTML = "<ul><li>Please select a template</li></ul>"
		}
	}
	
	function ValidateUserInfo () {
		var form = document.UserInfoForm
		
		var errorBox = document.getElementById("Error")
			errorBox.innerHTML = ""
		var passwordError = ""
		var emailError = ""
		var HeaderChoice = ""
		var HeaderNotChosen = ""
		//Loop through the form inputs and check for content
		for (var i in form) {
			if (form[i] !== null) {
				if (form[i].type == 'text' || form[i].type == 'password') {
					form[i].style.backgroundColor = "#ffffff"
					//The website field is not required
					//The Header selction validation will be done below
					if (form[i].name != 'Website' && form[i].name != 'HeaderText') {
						if (form[i].value == "") {
							form[i].style.backgroundColor = "#ffe2c8"
							validity = false
						} else {
							//Field is not empty
							//Check the contents for valid input
							if (form[i].name == "Company") {
								//Check if the desired client name is currently being used in CM or not
								var action 		= '?Action=ValidateCompany'
									company		= '&Company=' + form[i].value
								var Response	= '&Response=ValidateCompany'
								var get_vars 	= action
								var post_vars	= company + Response
								makePOSTRequest(AjaxUrl + get_vars, post_vars)				
							}
							if (form[i].name == "Password") {
								if (form[i].value.length < 5) {
									form[i].style.backgroundColor = "#ffe2c8"
									validity = false
									passwordError = "<li>Your Password must be at least 5 characters long.</li>"
								}
							}
							if (form[i].name == "Email") {	
								if (!ValidateUserEmail(form[i].value)) {
									form[i].style.backgroundColor = "#ffe2c8"
									validity = false
									emailError = "<li>Your Email address appears to be invalid.</li>";	
								} else {
									//Check if the desired client name is currently being used in CM or not
									var action 		= '?Action=ValidateEmail'
										company		= '&Email=' + form[i].value
									var Response	= '&Response=ValidateEmail'
									var get_vars 	= action
									var post_vars	= company + Response
									makePOSTRequest(AjaxUrl + get_vars, post_vars)			
								}
							}
						}
					}
				} 
				
				if (form[i].type == 'select-one') {
					form[i].style.backgroundColor = "#ffffff"
					if (form[i].value == "") {
						form[i].style.backgroundColor = "#ffe2c8"
					}
				}
				
			}
		}
		/*
		//find which HeaderChoice radio is selected, and make sure the accompanying input has content
		for (var i in form.HeaderRadio) {
			if (form.HeaderRadio[i].checked == true) {
				var selector = form.HeaderRadio[i].id.split('_')
				switch (selector[2]) {
					case 'Image': 
						HeaderNotChosen = document.getElementById('HeaderText'); 
						HeaderChoice = document.getElementById('HeaderImage'); 
						break ;
					case 'Text' : 
						HeaderChoice = document.getElementById('HeaderText'); 
						HeaderNotChosen = document.getElementById('HeaderImage'); 
						break;
				}
				HeaderNotChosen.style.backgroundColor = "#ffffff"
				if (HeaderChoice.value == '') {
					HeaderChoice.style.backgroundColor = "#ffe2c8"
					validity = false
				} else {
					HeaderChoice.style.backgroundColor = "#ffffff"
				}
			}
		}
		*/
		
		if (form.Terms.checked == false) {
			form.Terms.style.border = '1px solid red'
			validity = false
		} else {
			form.Terms.style.border = '1px solid #4689c6'
		}
		
		
		//Either display the errors or submit the form
		switch (validity) {
			case true: form.submit() ; break;
			//case false: errorBox.style.display = "block" ; errorBox.innerHTML = "<ul><li>Please fill in all the required fields</li>" + passwordError + emailError + "</ul>"; break;
		}
	}
	
	//Check that the user entered email address matches common email adress formats
	function ValidateUserEmail (str) {
		if (window.RegExp) {
			var reg1str = "(@.*@)|(\\.\\.)|(@\\.)|(\\.@)|(^\\.)";
			var reg2str = "^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)$";
			var reg1 = new RegExp(reg1str);
			var reg2 = new RegExp(reg2str);
			if (!reg1.test(str) && reg2.test(str)) {
			  return true;
			}
			return false;
		} else {
			if(str.indexOf("@") >= 0)
			  return true;
		}
	}
	/*
	
	//Toggle the header choice input based on the radio selection
	//i.e. if the user selects to use text for the header, hide the image field and show the text field
	function HeaderSelect(that) {
		var selector = that.id.split('_')
		document.getElementById(selector[0] + selector[2]).style.display = "block"
		switch (selector[2]) {
			case 'Image': 
				document.getElementById('HeaderText').style.display = 'none'; 
				document.getElementById('Header_Required_Image').style.color = "red"
				document.getElementById('Header_Required_Text').style.color = "rgb(255,255,255)"
			break ;
			case 'Text' : 
				document.getElementById('HeaderImage').style.display = 'none'; 
				document.getElementById('Header_Required_Text').style.color = "red"
				document.getElementById('Header_Required_Image').style.color = "rgb(255,255,255)"
			break;
		}
		
	}
	*/
	
	//Ajax Called Functions
	function ValidateCompany (Status) {
		if (Status == 0) {
			var errorBox = document.getElementById("Error")
				errorBox.style.display = "block"
				errorBox.innerHTML += "<ul><li>The company name you entered is already in our system, please choose another.</li><ul>"
				validity = false
		}
	}
	
	function ValidateEmail (Status) {
		if (Status == 0) {
			var errorBox = document.getElementById("Error")
				errorBox.style.display = "block"
				errorBox.innerHTML = "<ul><li>It appears you already have an account. Please give us a call 207-338-1740</li><ul>"
				validity = false
		}
	}