/*******************************
* functions related to Passenger 
********************************/
function validatePassenger() {
 /*     var passportNumList = [];
  for(i=0;i<numOfPassengers; i++)
  {
    passportNumList.push($('#passenger_passport_no'+(i+1)).text());
    console.log(passportNumList[i]);
  }*/
  return false;
    }

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

/*******************************************
* functions related to Booking Retrieval 
********************************************/

function validate_credentials_for_retrieving_booking() {
	var bookingIdStr = document.getElementById('booking-id').value.trim();
    var emailStr = document.getElementById('booking-email').value.trim();
	if(emailStr && bookingIdStr) {		
		 /*if(validateEmail(emailStr))*/
		$.post('user_func_retrieve_booking.php', {id:bookingIdStr, c_email:emailStr}, function(data) {
			data = data.trim();
			console.log(data);
			if(data == 'retrieved') {
				$('#check-booking-error').collapse('hide');
				document.getElementById('user-manage-booking-form').submit();
			} else {
				document.getElementById("check-booking-error").innerHTML = "Invalid Booking.<br/>";
				$('#check-booking-error').collapse('show');
			}
		});
		return false;
	} else {
		$('#check-booking-error').collapse('hide');
		document.getElementById('booking-id').value = bookingIdStr;
		document.getElementById('booking-email').value = emailStr;	
		return true;
	}	
}

function handleEditBooking() {
	$('#booking-view-details').collapse('hide');
	$('#edit-booking-details').collapse('show');
	return false;
}

function editBookingContactDetails() {
	var idStr = document.getElementById('booking-id').value;
	var emailStr = document.getElementById('booking-email').value.trim();
	var nameStr = document.getElementById('booking-name').value.trim();
	var numberStr = document.getElementById('booking-number').value.trim();
	
	if(emailStr && nameStr && numberStr && !isNaN(numberStr)) {
		if(validateEmail(emailStr)) {
			$('#loadingModal').collapse('show');
			$('#bookingEmailError').collapse('hide'); 
			$.post('admin_func_edit_booking.php', {
											id: idStr,
											email: emailStr,
											name: nameStr,
											number: numberStr
											}, function(data) {
				if(data == 'edited') {
					appendToForm('edit-booking-form', ["id"],[idStr]);
					document.getElementById('edit-booking-form').submit();
					$('#loadingModal').collapse('hide');
				}
				else {
					$('#bookingError').collapse('hide'); 
					document.getElementById("edit-booking-error-msg").innerHTML = "Error message:" + data;
					$('#edit-booking-error-result').collapse('show');
					$('#loadingModal').collapse('hide');
				}
			});
		} else {
			$('#edit-booking-error-result').collapse('hide');
			$('#bookingError').collapse('hide'); 
			$('#bookingEmailError').collapse('show'); 
		}
		return false;
	} else {
		disableForm(['bookingEmailError', 'bookingError', 'edit-booking-error-result'],[]);
		document.getElementById('booking-email').value = emailStr;
		document.getElementById('booking-name').value = nameStr;
		document.getElementById('booking-number').value = numberStr;		
		return true;
	}
}

function appendToForm(formName, names, values) {
	for(i = 0; i < names.length; i++) {
		var input = $("<input>")
					   .attr("type", "hidden")
					   .attr("name", names[i]).val(values[i]);
		$('#'+ formName).append($(input));		
	}
}

// a email at least have this format - string@string
// returns false if given email string does not match that format
function validateEmail(emailStr) {
	var tokens = emailStr.split("@");
	var space = emailStr.split(" ");
	if(tokens.length == 2 && tokens[0].length > 0  && tokens[1].length > 0 && space.length == 1) {
		return true; 
	} else {
		return false;
	}
}