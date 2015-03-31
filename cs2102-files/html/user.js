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

/*******************************
* functions related to Booking Retrieval 
********************************/
function validate_user_retrieve_booking_inputs() {
	var bookingIDStr = document.getElementById('inputBookingID').value;
        var emailStr = document.getElementById('inputEmail').value;
				
	if(emailStr && bookingStr) {		
		$.post('user_func_validate_retrieve_booking_inputs.php', {email:emailStr, bookingid:bookingIDStr}, function(data) {
			if(data == 'booking_found') {
				$.post('user_func_retrieve_booking.php',{bookingid:bookingIDStr}, function(data) {

					if(data) 
					// headers in array, rows, function to call when delete/edit button is clicked, words in the button
					document.getElementById(choice + '-options').innerHTML = createTableFormHtml(["Booking ID", "Contact Person", "Contact Email", "Contact Number"], data, "", "");
					
				});	
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

function forwardToBookingEditDetails() {
	document.getElementById('retrieveBooking-form').action = "user_edit_booking_details.php";
//	appendToForm('retrieveBooking-form');
	document.getElementById('retrieveBooking-form').submit();
	return true;
}


function handleEditBooking() {
	var bookingIDStr = document.getElementById('booking-id').name;
	var bookingFlightStr = document.getElementById('booking-flight').value;
	var bookingDepartTimeStr = document.getElementById('booking-depart-time').value;
	var bookingEmailStr = document.getElementById('booking-email').value;
	var bookingNameStr = document.getElementById('booking-name').value;
	var bookingNumberStr = document.getElementById('booking-number').value;

	if(bookingIDStr && bookingFlightStr && bookingDepartTimeStr && bookingEmailStr && bookingNameStr && bookingNumberStr) {		
		$.post('user_func_edit_booking.php', {bookingID: bookingIDStr, bookingFlight:bookingFlightStr, bookingDepartTime:bookingDepartTimeStr, bookingEmail:bookingEmailStr, bookingName: bookingNameStr, bookingNumber: bookingNumberStr}, function(data) {
			if(data == 'edited') {
				disableForm(['edit-booking-error-result'], ['booking-id', 'booking-flight', 'booking-depart-time', 'bookingEmail', 'booking-name', 'booking-number']);
				displayAddSuccessfulMessage("edit","Booking information updated!");
			}
		//	else if(data == 'passenger_exists'){
				//$('#edit-passenger-error-result').collapse('hide');
			//	$('#passengerNumError').collapse('show');
			} else {
				//$('#passengerNumError').collapse('hide'); 
				document.getElementById("edit-booking-error-msg").innerHTML = "Error message:" + data;
				$('#edit-booking-error-result').collapse('show');
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
