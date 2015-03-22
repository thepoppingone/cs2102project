/*******************************
* functions related to SEARCH 
********************************/
function validateUserSearchForm() {
	
	var returnVal = false;
	returnVal = validateOrigin();
	var valDate = false;
	var valPass = false;
	if(returnVal) {
		valDate = validateDate();
		valPass = validatePassenger();
		returnVal = valDate&&valPass;
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

function validatePassenger(){
	var adult = parseInt($('#child').val());
	var child = parseInt($('#adult').val());

	var valTotal = adult + child;
	if(valTotal > 4)
	{
		$('#passengers-alert').collapse('show');
		return false;
	}
	return true;


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

/*******************************
* functions related to Booking Retrieval 
********************************/
function validate_user_retrieve_booking_inputs() {
	var bookingIDStr = document.getElementById('inputBookingID').value;
        var emailStr = document.getElementById('inputEmail').value;
				
	if(emailStr && bookingStr) {		
		$.post('user_validate_retrieve_booking_inputs.php', {email:emailStr, bookingid:bookingIDStr}, function(data) {
			if(data == 'booking_found') {
				document.getElementById('retrieveBooking-form').submit();
			}
			else {
				document.getElementById("retrieveBooking-error").innerHTML = "Invalid Credentials.<br/>";
				$('#retrieveBooking-error').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}

}

/*******************************
* functions related to BOOKING
********************************/

//get query string using javascript
//use jquery assign each SELECT button by ID value

// Read a page's GET URL variables and return them as an associative array.
// the above function is to make it easy to retrieve values from GET

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
