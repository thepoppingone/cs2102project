/*******************************
* functions related to SEARCH 
********************************/
function validateUserSearchForm() {
	
	var returnVal = false;
	returnVal = validateOrigin();
	if(returnVal) {
		returnVal = validateDate();
	}
	
	return returnVal;
}

function validateOrigin() {
	return true;
}

function validateDate() {
	var dateStr = document.forms["userSearchForm"]["departure_date"].value
	var tokens = dateStr.split("-");
	
	// format : yyyy-mm-dd
	var year = parseInt(tokens[0]);
	var month = parseInt(tokens[1] - 1);
	var day = parseInt(tokens[2]);
	
	var currDate = new Date();

	var inputDate = new Date(year, month, day, 23, 59, 59, 59);
	if(inputDate <  currDate) {
		$('#date-alert').collapse('show');
		return false;
	}
	return true;
}

/*******************************
* functions related to LOGIN 
********************************/
function validate_admin_login() {
	var emailStr = document.getElementById('inputEmail').value;
	var pwdStr = document.getElementById('inputPassword').value;
				
	if(emailStr && pwdStr) {		
		$.post('user_func_admin_login.php', {email:emailStr, password:pwdStr}, function(data) {
			if(data == 'login') {
				document.getElementById('login-form').submit();
			}
			else {
				document.getElementById("login-error").innerHTML = "Invalid Credentials.<br/>";
				$('#login-error').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}