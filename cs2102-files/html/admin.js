/********************************
* functions related to ADD
*********************************/

function addCategoryChange() {
	var selectBar = document.getElementById('add-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	var options = ["administrator", "passenger", "booking", "airport", "flight", "schedule"];
	for(i = 0; i < options.length; i++) {
		if(option == options[i]) {
			$('#' + options[i]).collapse('show');	
		} else {
			$('#' + options[i]).collapse('hide');
		}
	}
}


// Add Administrator
function handleAddAdmin() {

	// retrieve the field values
	var emailStr = document.getElementById('admin-email').value.trim();
	var nameStr = document.getElementById('admin-name').value.trim();
	var pwdStr = document.getElementById('admin-pwd').value.trim();
				
	if(emailStr && nameStr && pwdStr) {		
		if(validateEmail(emailStr)) {
			$.post('admin_func_add_admin.php', {email:emailStr, name:nameStr, pwd:pwdStr}, function(data) {
				if(data == 'inserted') {
					disableForm(['admin-button', 'add-admin-error-result', 'adminEmailError'], ['add-category', 'admin-email', 'admin-name', 'admin-pwd']);
					displayAddSuccessfulMessage("add","New administrator added successfully.");
				}
				else if(data == 'admin_exists'){
					$('#add-admin-error-result').collapse('hide');
					document.getElementById("adminEmailError").innerHTML = "Oops! The owner of the email is already an administrator.";
					$('#adminEmailError').collapse('show');
				} else {
					$('#adminEmailError').collapse('hide'); 
					document.getElementById("add-admin-error-msg").innerHTML = "Error message:" + data;
					$('#add-admin-error-result').collapse('show');
				}
			});
		} else {
			$('#add-admin-error-result').collapse('hide');
			document.getElementById("adminEmailError").innerHTML = "Invalid email format";
			$('#adminEmailError').collapse('show');		
		}
		return false;
	} else {
		disableForm(['adminEmailError', 'add-admin-error-result'],[]);
		document.getElementById('admin-email').value = emailStr;
		document.getElementById('admin-name').value = nameStr;
		document.getElementById('admin-pwd').value = pwdStr;		
		return true;
	}
}

// Add Booking
// empty checkStr means no checking of passenger details done, go ahead and insert/update
// non-empty checkStr means check passenger details first and inform if the passenger exists. else continue
function handleAddBooking(checkStr) {

	$("#confirm-modal").modal('hide');	
	
	// retrieve the field values for booking
	var post_data = createBookingDataObject();
	
	if(requiredFieldsCompleted(post_data)) {	
		if(!validateEmail(post_data.contactEmail)) {
			document.getElementById("bookingEmailError").innerHTML = "Invalid email format";
			$('#bookingEmailError').collapse('show');	
			return false;
		} else if(checkStr) {
			// run a check on passenger
			$.post('admin_func_verify_passenger.php', post_data, function(data) {
				data = data.trim();	
				if (data == 'new_passenger') {
					handleAddBooking("");
				} else if (data) {
					// set modal for informing
					document.getElementById("confirm-modal-content").innerHTML = '<p>' + data + " Any discrepancies will be updated. Continue?" + '</p>';
					$("#confirm-add-btn").attr("onclick", "handleAddBooking('')");
					// display modal
					$("#confirm-modal").modal('show');
				}
			});			
		} else {
			// perform insert
			$.post('admin_func_add_booking.php', post_data, function(data) {
				dataTokens = data.trim().split(" ");	
				if (dataTokens[0] == 'successful') {
					// do disable
					disableForm(['booking-button', 'add-booking-error-result'], ['add-category', 'booking-email', 'booking-name', 'booking-number', 'booking-schedule', 'booking-passenger-num']);
					disableForm([], ['passenger-passport-1', 'passenger-title-1', 'passenger-first-name-1', 'passenger-last-name-1']);
					disableForm([], ['passenger-passport-2', 'passenger-title-2', 'passenger-first-name-2', 'passenger-last-name-2']);
					disableForm([], ['passenger-passport-3', 'passenger-title-3', 'passenger-first-name-3', 'passenger-last-name-3']);
					disableForm([], ['passenger-passport-4', 'passenger-title-4', 'passenger-first-name-4', 'passenger-last-name-4']);
					displayAddSuccessfulMessage("add","New booking added successfully. <br/> Booking Id: " + dataTokens[1]);
				} else {
					document.getElementById("add-booking-error-msg").innerHTML = "Error message:" + data;
					$('#add-booking-error-result').collapse('show');
				}
			});		
					
		}
		return false;
	} else {
		// refresh the field inputs
		updateFieldInput(post_data);
		disableForm(['add-booking-error-result'],[]);
		return true;
	}
}

function createBookingDataObject() {

	var selectSchedule = document.getElementById('booking-schedule');
	var schedule =  selectSchedule.options[selectSchedule.selectedIndex].value.split(";");
	var selectPassengerNum = document.getElementById('booking-passenger-num');

	var bookingData = {
		contactEmail: document.getElementById('booking-email').value.trim(),
		contactName: document.getElementById('booking-name').value.trim(),
		contactNumber: document.getElementById('booking-number').value.trim(),
		flight_number : schedule[0],
		depart_date : schedule[1],
		numOfPassenger : parseInt(selectPassengerNum.options[selectPassengerNum.selectedIndex].value),
		
		passport1 : document.getElementById('passenger-passport-1').value.trim(),
		title1 : document.getElementById('passenger-title-1').value.trim(),
		first1 : document.getElementById('passenger-first-name-1').value.trim(),
		last1 : document.getElementById('passenger-last-name-1').value.trim(),
		
		passport2 : document.getElementById('passenger-passport-2').value.trim(),
		title2 : document.getElementById('passenger-title-2').value.trim(),
		first2 : document.getElementById('passenger-first-name-2').value.trim(),
		last2 : document.getElementById('passenger-last-name-2').value.trim(),

		passport3 : document.getElementById('passenger-passport-3').value.trim(),
		title3 : document.getElementById('passenger-title-3').value.trim(),
		first3 : document.getElementById('passenger-first-name-3').value.trim(),
		last3 : document.getElementById('passenger-last-name-3').value.trim(),

		passport4 : document.getElementById('passenger-passport-4').value.trim(),
		title4 : document.getElementById('passenger-title-4').value.trim(),
		first4 : document.getElementById('passenger-first-name-4').value.trim(),
		last4 : document.getElementById('passenger-last-name-4').value.trim()
	};
	return bookingData;
}

function updateFieldInput(o) {

	document.getElementById('booking-email').value = o.contactEmail;
	document.getElementById('booking-name').value = o.contactName;
	document.getElementById('booking-number').value = o.contactNumber;
	
	document.getElementById('passenger-passport-1').value = o.passport1;
	document.getElementById('passenger-first-name-1').value = o.first1;
	document.getElementById('passenger-last-name-1').value = o.last1;
	
	if(o.numOfPassenger > 1) {
		document.getElementById('passenger-passport-2').value = o.passport2;
		document.getElementById('passenger-first-name-2').value = o.first2;
		document.getElementById('passenger-last-name-2').value = o.last2;		
		if(o.numOfPassenger > 2) {
			document.getElementById('passenger-passport-3').value = o.passport3;
			document.getElementById('passenger-first-name-3').value = o.first3;
			document.getElementById('passenger-last-name-3').value = o.last3;		
			if(o.numOfPassenger > 3) {
				document.getElementById('passenger-passport-4').value = o.passport4;
				document.getElementById('passenger-first-name-4').value = o.first4;
				document.getElementById('passenger-last-name-4').value = o.last4;			
			}
		}
	}
}

function requiredFieldsCompleted(o) {
	$('#bookingEmailError').collapse('hide');
	if(o.contactEmail && o.contactName && o.contactNumber 
		&& o.passport1 && o.title1 && o.first1 && o.last1 && !isNaN(o.contactNumber)) {
		if(o.numOfPassenger > 1 && o.passport2 && o.title2 && o.first2 && o.last2) {
			if (o.passport1 == o.passport2) {
				// same passport
				// set modal for informing
				document.getElementById("error-modal-content").innerHTML = '<p>' + "Identical passport numbers detected. Please check again." + '</p>';
				// display modal
				$("#error-modal").modal('show');				
				return false;
			} else if (o.numOfPassenger > 2 && o.passport3 && o.title3 && o.first3 && o.last3) {	
				if (o.passport1 == o.passport3 || o.passport2 == o.passport3) {
					// same passport
					// set modal for informing
					document.getElementById("error-modal-content").innerHTML = '<p>' + "Identical passport numbers detected. Please check again." + '</p>';
					// display modal
					$("#error-modal").modal('show');						
					return false;
				} else if(o.numOfPassenger > 3 && o.passport4 && o.title4 && o.first4 && o.last4) {
					if (o.passport1 == o.passport4 || o.passport2 == o.passport4 || o.passport3 == o.passport4) {
						// same passport
						// set modal for informing
						document.getElementById("error-modal-content").innerHTML = '<p>' + "Identical passport numbers detected. Please check again." + '</p>';
						// display modal
						$("#error-modal").modal('show');							
						return false;
					} 
				} else if (o.numOfPassenger > 3) {
					return false;
				}
			} else if (o.numOfPassenger > 2) {
				return false;
			}
		} else if (o.numOfPassenger > 1) {
			return false;		
		}		
	} else {
		return false;
	}
	return true;
}

// Add Passenger
// empty checkStr means no checking of passenger details done, go ahead and insert/update
// non-empty checkStr means check passenger details first and inform if the passenger exists. else continue
function handleAddPassenger(checkStr) {

	$("#confirm-modal").modal('hide');	
	
	// retrieve the field values
	var selectTitle = document.getElementById('passenger-title');
    var titleStr =  selectTitle.options[selectTitle.selectedIndex].value;
	var firstNameStr = document.getElementById('passenger-first-name').value.trim();
	var lastNameStr = document.getElementById('passenger-last-name').value.trim();
	var passportStr = document.getElementById('passenger-passport').value.trim();
	var selectBooking = document.getElementById('passenger-booking-id');
    var bookingStr =  selectBooking.options[selectBooking.selectedIndex].value;

	if(titleStr && firstNameStr && lastNameStr && passportStr && bookingStr) {	
		$.post('admin_func_add_passenger.php', {title:titleStr, firstName:firstNameStr, lastName:lastNameStr, passport:passportStr, id:bookingStr, check:checkStr}, function(data) {
			data = data.trim();			
			if (data == 'passenger_exists') {
				// set modal for informing
				document.getElementById("confirm-modal-content").innerHTML = '<p>' + "The passenger is already recorded in the database. Any discrepancies will be updated. Continue?" + '</p>';
				$("#confirm-add-btn").attr("onclick", "handleAddPassenger('')");
				// display modal
				$("#confirm-modal").modal('show');
			} else if (data == 'passenger_booking_exists') {
				// booking already contains the passenger
				$('#add-passenger-error-result').collapse('hide');
				document.getElementById("passengerPassportError").innerHTML = "This passenger is already registered under the selected booking.";
				$('#passengerPassportError').collapse('show');		
			} else if (data == 'new_passenger') {
				handleAddPassenger("");
			} else if (data == 'successful') {
				disableForm(['passenger-button', 'add-passenger-error-result', 'passengerPassportError'], ['add-category', 'passenger-title', 'passenger-first-name', 'passenger-last-name', 'passenger-passport', 'passenger-booking-id']);
				displayAddSuccessfulMessage("add","New passenger added successfully.");
			} else if(!checkStr) {
				$('#passengerPassportError').collapse('hide'); 
				document.getElementById("add-passenger-error-msg").innerHTML = "Error message:" + data;
				$('#add-passenger-error-result').collapse('show');
			}
		});
		return false;
	} else {
		disableForm(['passengerPassportError', 'add-passenger-error-result'],[]);
		document.getElementById('passenger-first-name').value = firstNameStr;
		document.getElementById('passenger-last-name').value = lastNameStr;
		document.getElementById('passenger-passport').value = passportStr;
		return true;
	}
}

// Add Airport
function handleAddAirport() {

	// retrieve the field values
	var nameStr = document.getElementById('airport-name').value.trim();
	var locationStr = document.getElementById('airport-location').value.trim();
	var designatorStr = document.getElementById('airport-designator').value.trim();
				
	if(nameStr && locationStr && designatorStr) {		
		$.post('admin_func_add_airport.php', {name:nameStr, location:locationStr, designator:designatorStr}, function(data) {
			if(data == 'inserted') {
				disableForm(['airport-button', 'add-airport-error-result', 'airportDesignatorError'], ['add-category', 'airport-name', 'airport-location', 'airport-designator']);
				displayAddSuccessfulMessage("add","New airport added successfully.");
			}
			else if(data == 'airport_exists'){
				$('#add-airport-error-result').collapse('hide');
				$('#airportDesignatorError').collapse('show');
			} else {
				$('#airportDesignatorError').collapse('hide'); 
				document.getElementById("add-airport-error-msg").innerHTML = "Error message:" + data;
				$('#add-airport-error-result').collapse('show');
			}
		});
		return false;
	} else {
		disableForm(['airportDesignatorError', 'add-airport-error-result'],[]);
		document.getElementById('airport-name').value = nameStr;
		document.getElementById('airport-location').value = locationStr;
		document.getElementById('airport-designator').value = designatorStr;		
		return true;
	}
}

// Add Flight
function handleAddFlight() {
	
	// retrieve the field values
	var numberStr = document.getElementById('flight-number').value.trim();
	var destinationBar = document.getElementById('flight-destination');
	var destinationStr = destinationBar.options[destinationBar.selectedIndex].value;
	var originBar = document.getElementById('flight-origin');
	var originStr = originBar.options[originBar.selectedIndex].value;
	var seatStr = document.getElementById('flight-seat').value.trim();
				
	if(numberStr && destinationStr && originStr && seatStr &&!isNaN(numberStr)) {		
		if(validateFlightRoute() && validateSeatCapacity()) {
			$.post('admin_func_add_flight.php', {f_number:numberStr, destination:destinationStr, origin:originStr, seat_capacity:seatStr}, function(data) {
				if(data == 'inserted') {
					disableForm(['flight-button', 'add-flight-error-result', 'flightDesignatorError'], ['add-category', 'flight-number', 'flight-destination', 'flight-origin', 'flight-seat']);
					displayAddSuccessfulMessage("add","New flight added successfully.");
				}
				else if(data == 'flight_exists'){
					$('#add-flight-error-result').collapse('hide');
					$('#flightDesignatorError').collapse('show');
				} else {
					$('#flightDesignatorError').collapse('hide'); 
					document.getElementById("add-flight-error-msg").innerHTML = "Error message:" + data;
					$('#add-flight-error-result').collapse('show');
				}
			});
		}
		return false;
	} else {
		disableForm(['flightDesignatorError', 'add-flight-error-result'],[]);
		document.getElementById('flight-number').value = numberStr;
		document.getElementById('flight-seat').value = seatStr;	
		return true;
	}
}

// Add Schedule
function handleAddSchedule() {
	
	var selectBarF = document.getElementById('schedule-flight');
	var flightStr = selectBarF.options[selectBarF.selectedIndex].value;
	var arrivalStr = document.getElementById('schedule-arrival').value;
	var departureStr = document.getElementById('schedule-departure').value;
	var priceStr = document.getElementById('schedule-price').value.trim();
	
	if(flightStr && arrivalStr && departureStr && priceStr) {
		if(validateScheduleTime()) {		
			$.post('admin_func_add_schedule.php', {
										flight_number: flightStr,
										arrival_time: arrivalStr,
										depart_time: departureStr,
										price: priceStr,},  function(data) {	
				if(data == 'inserted') {
					disableForm(['schedule-button', 'add-schedule-error-result', 'scheduleExistsError', 'scheduleTimeError'], ['add-category', 'schedule-flight', 'schedule-departure', 'schedule-arrival', 'schedule-price']);
					displayAddSuccessfulMessage("add","New schedule added successfully.");
				}
				else if(data == 'schedule_exists'){
					$('#add-schedule-error-result').collapse('hide');
					$('#scheduleExistsError').collapse('show');
				} else {
					$('#scheduleExistsError').collapse('hide'); 
					document.getElementById("add-schedule-error-msg").innerHTML = "Error message:" + data;
					$('#add-schedule-error-result').collapse('show');
				}
			});
		}
		return false;
	} else {
		disableForm(['scheduleTimeError', 'scheduleExistsError', 'add-schedule-error-result'],[]);
		document.getElementById('schedule-price').value = priceStr;		
		return true;
	}
}

// a email at least have this format - string@string
// returns false if given email string does not match that format
function validateEmail(emailStr) {
	var tokens = emailStr.split("@");
	if(tokens.length == 2 && tokens[0].length > 0  && tokens[1].length > 0) {
		return true; 
	} else {
		return false;
	}
}

// a flight route should have different origin and destination
// requires two select bar with id 'flight-origin' and 'flight-destination'
// and a id 'flightRouteError' for collapse show/hide
// returns true of the selected values are equal, else false
function validateFlightRoute() {

	// retrieve field values
	var selectOrigin = document.getElementById('flight-origin');
    var origin =  selectOrigin.options[selectOrigin.selectedIndex].value;
	var selectDestination = document.getElementById('flight-destination');
    var destination =  selectDestination.options[selectDestination.selectedIndex].value;
	
	if(origin && destination) {
		if(origin == destination) {
			$('#flightRouteError').collapse('show');
		} else {
			$('#flightRouteError').collapse('hide');
			return true;
		}
	}
	return false;
}

// a flight should have minimum of 1 passenger seat
// requires a number field with id 'flight-seat'
// and a id 'seatCapacityError' for collapse show/hide
// returns true if the values is > 0,  else false
function validateSeatCapacity() {

	// retrieve field values
	var seatStr = document.getElementById('flight-seat').value.trim();
	
	if(seatStr) {
		if(seatStr < 1) {
			$('#seatCapacityError').collapse('show');
		} else {
			$('#seatCapacityError').collapse('hide');
			return true;
		}
	}
	return false;
}
// a schedule requires a valid departure time and arrival time
// both time should be in future and departure should be before arrival
// requires two datetime field with id 'schedule-arrival' and 'schedule-departure'
function validateScheduleTime() {
	var today = new Date();
	var arrivalStr = new Date(document.getElementById('schedule-arrival').value);
	var departureStr = new Date(document.getElementById('schedule-departure').value);
	if(departureStr > today) {
		if(arrivalStr <= departureStr) {
			// invalid arrival time
			document.getElementById("scheduleTimeError").innerHTML = "Arrival time should be later than Departure time";
			$('#scheduleTimeError').collapse('show');
		} else {
			$('#scheduleTimeError').collapse('hide');
			return true;
		}
	} else {
		// invalid departure time
		document.getElementById("scheduleTimeError").innerHTML = "Departure Time is already in the past";
		$('#scheduleTimeError').collapse('show');
	}
	return false;
}

function validateSeatRequest() {

	// retrieve number of seats available
	var selectSchedule = document.getElementById('booking-schedule');
    var capacity_avail = selectSchedule.options[selectSchedule.selectedIndex].value.split(";")[2];
	
	var selectPassengerNum = document.getElementById('booking-passenger-num');
	
	// if current passenger number options is more than available
	if (selectPassengerNum.options.length > capacity_avail) {
		// remove the options
		while(selectPassengerNum.options.length > capacity_avail) {
			selectPassengerNum.remove(selectPassengerNum.length-1);
		}
	} else if(selectPassengerNum.options.length < capacity_avail && selectPassengerNum.options.length < 4) {
		var value = selectPassengerNum.length + 1;
		// can add more options (max 4)
		while(selectPassengerNum.options.length < capacity_avail && selectPassengerNum.options.length < 4) {
			var option = document.createElement("option");
			option.text = value;
			option.value = value;
			value = value + 1;
			selectPassengerNum.add(option);
		}
	}
	loadPassengerFields()
}

function loadPassengerFields() {

	// retrieve number of passengers
	var selectPassengerNum = document.getElementById('booking-passenger-num');
    var passengerNum = parseInt(selectPassengerNum.options[selectPassengerNum.selectedIndex].value);
	
	for(i = 2; i <= passengerNum; i++) {
		$('#passenger-' + i).collapse('show');
		$('#passenger-passport-' + i).prop('required',true);
		$('#passenger-title-' + i).prop('required',true);
		$('#passenger-first-name-' + i).prop('required',true);
		$('#passenger-last-name-' + i).prop('required',true);
	}	
	
	var num = passengerNum + 1;
	for(x = num; x <= 4; x++) {
		$('#passenger-' + x).collapse('hide');
		$('#passenger-passport-' + x).prop('required', false);
		$('#passenger-title-' + x).prop('required', false);
		$('#passenger-first-name-' + x).prop('required', false);
		$('#passenger-last-name-' + x).prop('required', false);
	}
}

/********************************
* functions related to DELETE
*********************************/

function deleteCategoryChange() {
	var selectBar = document.getElementById('delete-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	//var options = ["administrator", "passenger", "reservation", "airport", "flight", "schedule"];
	document.getElementById("delete-options").innerHTML = "";
	disableForm(['delete-error-result'], []);
	$("#loadingModal").modal('show');
	if(option == "administrator") {
		loadAdminOptions("delete");
	} else if(option == "passenger") {
		loadPassengerOptions("delete");
	} else if(option == "airport") {
		loadAirportOptions("delete");
	} else if(option == "reservation") {
		loadReservationOptions("delete");
	} else if(option == "flight") {
		loadFlightOptions("delete");
	}
}

function handleDeleteAdmin(id, emailStr) {
	$.post('admin_func_delete_admin.php', {email:emailStr}, function(data) {	
		if(data == "successful") {
			disableForm([id],[]);
		} else {
			document.getElementById("delete-msg").innerHTML = "Error message:" + data;
			$('#delete-msg').collapse('show');
		}
	});	
	return false;
}

function handleDeletePassenger(id, passportStr) {
	$.post('admin_func_check_delete_passenger.php', {passport:passportStr}, function(data) {
			document.getElementById("confirm-modal-content").innerHTML = '<p>' + data + '</p>';
			$("#confirm-delete-btn").attr("onclick", "confirmDeletePassenger(" + id + ",\"" +  passportStr + "\")");
			$("#confirm-modal").modal('show');	
	});	
	return false;
}

function confirmDeletePassenger(id, passportStr) {

	$.post('admin_func_delete_passenger.php', {passport:passportStr}, function(data) {	
		if(data == "successful") {
			disableForm([id],[]);
		} else {
			document.getElementById("delete-msg").innerHTML = "Error message:" + data;
			$('#delete-msg').collapse('show');
		}
		$("#confirm-modal").modal('hide');	
	});
}

function handleDeleteReservation(id, idStr) {
	$.post('admin_func_check_delete_booking.php', {booking_id:idStr}, function(data) {
		if(data == "not_affected") {
			confirmDeleteBooking(id, idStr);
		} else {	
			document.getElementById("confirm-modal-content").innerHTML = '<p>' + data + '</p>';
			$("#confirm-delete-btn").attr("onclick", "confirmDeleteBooking(" + id + ",\"" +  idStr + "\")");
			$("#confirm-modal").modal('show');	
		}
	});	
	return false;
}

function confirmDeleteBooking(id, idStr) {
	alert("enter");
	$.post('admin_func_delete_booking.php', {booking_id:idStr}, function(data) {
		alert(data);
		if(data == "successful") {
			disableForm([id],[]);
		} else {
			document.getElementById("delete-msg").innerHTML = "Error message:" + data;
			$('#delete-msg').collapse('show');
		}
		$("#confirm-modal").modal('hide');	
	});
}

function handleDeleteAirport(id, designatorStr) {
	$.post('admin_func_check_delete_airport.php', {designator:designatorStr}, function(data) {
		if(data == "not_affected") {
			confirmDeleteAirport(id, designatorStr);
		} else {
			document.getElementById("confirm-modal-content").innerHTML = '<p>' + data + '</p>';
			$("#confirm-delete-btn").attr("onclick", "confirmDeleteAirport(" + id + ",\"" +  designatorStr + "\")");
			$("#confirm-modal").modal('show');	
		}
	});		
	return false;
}

function confirmDeleteAirport(id, designatorStr) {
	$.post('admin_func_delete_airport.php', {designator:designatorStr}, function(data) {	
		if(data == "successful") {
			disableForm([id],[]);
		} else {
			document.getElementById("delete-msg").innerHTML = "Error message:" + data;
			$('#delete-msg').collapse('show');
		}
		$("#confirm-modal").modal('hide');	
	});
}

function handleDeleteFlight(id, f_numberStr) {
	$.post('admin_func_check_delete_flight.php', {f_number:f_numberStr}, function(data) {
		if(data == "not_affected") {
			confirmDeleteFlight(id, f_numberStr);
		} else {
			document.getElementById("confirm-modal-content").innerHTML = '<p>' + data + '</p>';
			$("#confirm-delete-btn").attr("onclick", "confirmDeleteFlight(" + id + ",\"" +  f_numberStr + "\")");
			$("#confirm-modal").modal('show');	
		}
	});		
	return false;
}

function confirmDeleteFlight(id, f_numberStr) {
	$.post('admin_func_delete_flight.php', {f_number:f_numberStr}, function(data) {	
		if(data == "successful") {
			disableForm([id],[]);
		} else {
			document.getElementById("delete-msg").innerHTML = "Error message:" + data;
			$('#delete-msg').collapse('show');
		}
		$("#confirm-modal").modal('hide');	
	});
}


/********************************
* functions related to EDIT
*********************************/

function editCategoryChange() {
	var selectBar = document.getElementById('edit-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	document.getElementById("edit-options").innerHTML = "";
	$("#loadingModal").modal('show');
	if(option == "administrator") {
		loadAdminOptions("edit");
	} else if(option == "airport") {
		loadAirportOptions("edit");
	} else if(option == "passenger") {
		loadPassengerOptions("edit");
	} else if(option == "reservation") {
		loadReservationOptions("edit");
	} else if(option == "flight") {
		loadFlightOptions("edit");
	} else if(option == "schedule") {
		loadFlightOptions("edit");
	}
}

function forwardToAdminEditDetails(emailStr) {
	document.getElementById('result-form').action = "admin_edit_details.php";
	appendToForm('result-form', ["selected", "email"],["administrator", emailStr]);
	document.getElementById('result-form').submit();
	return true;
}


function handleEditAdmin() {
	var originalEmailStr = document.getElementById('admin-email').name;
	var emailStr = document.getElementById('admin-email').value;
	var nameStr = document.getElementById('admin-name').value;
	var pwdStr = document.getElementById('admin-pwd').value;

	if(emailStr && nameStr && pwdStr) {		
		$.post('admin_func_edit_admin.php', {originalEmail: originalEmailStr, email:emailStr, name:nameStr, pwd:pwdStr}, function(data) {
			if(data == 'edited') {
				disableForm(['admin-button', 'edit-admin-error-result', 'adminEmailError'], ['admin-email', 'admin-name', 'admin-pwd']);
				displayAddSuccessfulMessage("edit","Administrator information updated!");
			}
			else if(data == 'admin_exists'){
				$('#edit-admin-error-result').collapse('hide');
				$('#adminEmailError').collapse('show');
			} else {
				$('#adminEmailError').collapse('hide'); 
				document.getElementById("edit-admin-error-msg").innerHTML = "Error message:" + data;
				$('#edit-admin-error-result').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}

function forwardToAirportEditDetails(designatorStr) {
	document.getElementById('result-form').action = "admin_edit_details.php";
	appendToForm('result-form', ["selected", "designator"],["airport", designatorStr]);
	document.getElementById('result-form').submit();
	return true;
}

function handleEditAirport() {
	var originalDesignatorStr = document.getElementById('airport-designator').name;
	var nameStr = document.getElementById('airport-name').value;
	var locationStr = document.getElementById('airport-location').value;
	var designatorStr = document.getElementById('airport-designator').value;

	if(nameStr && locationStr && designatorStr) {		
		$.post('admin_func_edit_airport.php', {originalDesignator: originalDesignatorStr, location:locationStr, name:nameStr, designator:designatorStr}, function(data) {
			if(data == 'edited') {
				disableForm(['airport-button', 'edit-airport-error-result', 'airportDesignatorError'], ['airport-designator', 'airport-name', 'airport-location']);
				displayAddSuccessfulMessage("edit","Airport information updated!");
			}
			else if(data == 'airport_exists'){
				$('#edit-airport-error-result').collapse('hide');
				$('#airportDesignatorError').collapse('show');
			} else {
				$('#airportDesignatorError').collapse('hide'); 
				document.getElementById("edit-airport-error-msg").innerHTML = "Error message:" + data;
				$('#edit-airport-error-result').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}
function forwardToPassengerEditDetails(numStr) {
	document.getElementById('result-form').action = "admin_edit_details.php";
	appendToForm('result-form', ["selected", "num"],["passenger", numStr]);
	document.getElementById('result-form').submit();
	return true;
}

function handleEditPassenger() {
	var originalNumStr = document.getElementById('passenger-num').name;
	var numStr = document.getElementById('passenger-num').value;
	var typeStr = document.getElementById('passenger-type').value;
	var titleStr = document.getElementById('passenger-title').value;
	var firstNameStr = document.getElementById('passenger-firstname').value;
	var lastNameStr = document.getElementById('passenger-lastname').value;

	if(numStr && typeStr && titleStr && firstNameStr && lastNameStr) {		
		$.post('admin_func_edit_passenger.php', {originalNum: originalNumStr, num:numStr, type:typeStr, title:titleStr, firstName:firstNameStr, lastName: lastNameStr}, function(data) {
			if(data == 'edited') {
				disableForm(['passenger-button', 'edit-passenger-error-result', 'passengerNumError'], ['passenger-num', 'passenger-type', 'passenger-title', 'passenger-firstname', 'passenger-lastname']);
				displayAddSuccessfulMessage("edit","Passenger information updated!");
			}
			else if(data == 'passenger_exists'){
				$('#edit-passenger-error-result').collapse('hide');
				$('#passengerNumError').collapse('show');
			} else {
				$('#passengerNumError').collapse('hide'); 
				document.getElementById("edit-passenger-error-msg").innerHTML = "Error message:" + data;
				$('#edit-passenger-error-result').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}

function forwardToFlightEditDetails(numStr) {
	document.getElementById('result-form').action = "admin_edit_details.php";
	appendToForm('result-form', ["selected", "num"],["flight", numStr]);
	document.getElementById('result-form').submit();
	return true;
}

function handleEditFlight() {
	var originalNumStr = document.getElementById('flight-num').name;
	var numStr = document.getElementById('flight-num').value;
	var selectBarD = document.getElementById('flight-dest');
	var destStr = selectBarD.options[selectBarD.selectedIndex].value;
	var selectBarO = document.getElementById('flight-origin');
	var originStr = selectBarO.options[selectBarO.selectedIndex].value;
		var seatCapacityStr = document.getElementById('flight-seatcapacity').value;

	if(numStr && originStr && destStr && seatCapacityStr) {		
		$.post('admin_func_edit_flight.php', {originalNum: originalNumStr, num:numStr, origin:originStr, dest:destStr, seatCapacity:seatCapacityStr}, function(data) {
			if(data == 'edited') {
				disableForm(['flight-button', 'edit-flight-error-result', 'flightNumError'], ['flight-num', 'flight-origin', 'flight-dest', 'flight-seatcapacity']);
				displayAddSuccessfulMessage("edit","Flight information updated!");
			}
			else if(data == 'flight_exists'){
				$('#edit-flight-error-result').collapse('hide');
				$('#flightNumError').collapse('show');
			} else {
				$('#flightNumError').collapse('hide'); 
				document.getElementById("edit-flight-error-msg").innerHTML = "Error message:" + data;
				$('#edit-flight-error-result').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}
/*
function forwardToReservationEditDetails(numStr) {
	document.getElementById('result-form').action = "admin_edit_details.php";
	appendToForm('result-form', ["selected", "id"],["reservation", numStr]);
	document.getElementById('result-form').submit();
	return true;
}

function handleEditReservation() {
	var originalIDStr = document.getElementById('reservation-id').name;
	var idStr = document.getElementById('reservation-id').value;
	var personStr = document.getElementById('reservation-person').value;
	var emailStr = document.getElementById('reservation-email').value;
	var numStr = document.getElementById('reservation-num').value;
	var personStr = document.getElementById('reservation-person').value;
	var flightNumStr = document.getElementById('reservation-flight-num').value;
	var departStr = document.getElementById('reservation-depart').value;
I STOPPED HEREEEEEEEEEE!!!!!!!!
	if(numStr && originStr && destStr && seatCapacityStr) {		
		$.post('admin_func_edit_flight.php', {originalNum: originalNumStr, num:numStr, origin:originStr, dest:destStr, seatCapacity:seatCapacityStr}, function(data) {
			if(data == 'edited') {
				disableForm(['flight-button', 'edit-flight-error-result', 'flightNumError'], ['flight-num', 'flight-origin', 'flight-dest', 'flight-seatcapacity']);
				displayAddSuccessfulMessage("edit","Flight information updated!");
			}
			else if(data == 'flight_exists'){
				$('#edit-flight-error-result').collapse('hide');
				$('#flightNumError').collapse('show');
			} else {
				$('#flightNumError').collapse('hide'); 
				document.getElementById("edit-flight-error-msg").innerHTML = "Error message:" + data;
				$('#edit-flight-error-result').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}
*/

function appendToForm(formName, names, values) {
	for(i = 0; i < names.length; i++) {
		var input = $("<input>")
					   .attr("type", "hidden")
					   .attr("name", names[i]).val(values[i]);
		$('#'+ formName).append($(input));		
	}
}

/**************************************
* functions used by DELETE and EDIT
***************************************/

function loadAdminOptions(choice) {
	var editStr = choice;
	if(choice == "delete") editStr = "";
	$.post('admin_func_retrieve_admin.php',{edit:editStr}, function(data) {
		if(data) {
			// headers in array, rows, function to call when delete/edit button is clicked, words in the button
			document.getElementById(choice + '-options').innerHTML = createTableFormHtml(["Name","Email"], data, "", "");
			$('#' + choice + '-options').collapse('show');
		} else {
			handleEmptyOptions(choice + '-options'); 		
		}
		$("#loadingModal").modal('hide');
	});		
}

function loadAirportOptions(choice) {
	var editStr = choice;
	if(choice == "delete") editStr = "";
	$.post('admin_func_retrieve_airport.php',{edit:editStr}, function(data) {
		
		if(data) {
			// headers in array, rows, function to call when delete/edit button is clicked, words in the button
			document.getElementById(choice + '-options').innerHTML = createTableFormHtml(["Name","Location", "Designator"], data, "", "");
			$('#' + choice + '-options').collapse('show');
		} else {
			handleEmptyOptions(choice + '-options'); 	
		}
		$("#loadingModal").modal('hide');
	});
}

function loadPassengerOptions(choice) {
	var editStr = choice;
	if(choice == "delete") editStr = "";
	$.post('admin_func_retrieve_passenger.php',{edit:editStr}, function(data) {
		if(data) {
			// headers in array, rows, function to call when delete/edit button is clicked, words in the button
			document.getElementById(choice + '-options').innerHTML = createTableFormHtml(["Passenger Number", "Title", "First Name", "Last Name"], data, "", "");
			$('#' + choice + '-options').collapse('show');
		} else {
			handleEmptyOptions(choice + '-options'); 	
		}
		$("#loadingModal").modal('hide');
	});	
}

function loadReservationOptions(choice) {
	var editStr = choice;
	if(choice == "delete") editStr = "";
	$.post('admin_func_retrieve_reservation.php',{edit:editStr}, function(data) {
		if(data) {
			// headers in array, rows, function to call when delete/edit button is clicked, words in the button
			document.getElementById(choice + '-options').innerHTML = createTableFormHtml(["Reservation Id", "Contact Person", "Contact Number", "Contact Email", "Flight Number", "Departure Time"], data, "", "");
			$('#' + choice + '-options').collapse('show');
		} else {
			handleEmptyOptions(choice + '-options'); 	
		}
		$("#loadingModal").modal('hide');
	});	
}

function loadFlightOptions(choice) {
	var editStr = choice;
	if(choice == "delete") editStr = "";
	$.post('admin_func_retrieve_flight.php',{edit:editStr}, function(data) {
		if(data) {
			// headers in array, rows, function to call when delete/edit button is clicked, words in the button
			document.getElementById(choice + '-options').innerHTML = createTableFormHtml(["Flight Number", "Origin", "Destination", "Seat Capacity"], data, "", "");
			$('#' + choice + '-options').collapse('show');
		} else {
			handleEmptyOptions(choice + '-options'); 
		}
		$("#loadingModal").modal('hide');
	});	
}

/********************************
* functions related to SEARCH
*********************************/

function searchCategoryChange() {
	var selectBar = document.getElementById('search-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	var options = ["administrator", "passenger", "reservation", "airport", "flight", "schedule"];
	$("#search-results").collapse('hide');
	for(i = 0; i < options.length; i++) {
		if(option == options[i]) {
			$('#' + options[i]).collapse('show');	
		} else {
			$('#' + options[i]).collapse('hide');
		}
	}
}

function handleSearchAdmin() {
	
	$("#loadingModal").modal('show');
	
	var emailStr = document.getElementById('admin-email').value;
	var nameStr = document.getElementById('admin-name').value;
	var pwdStr = document.getElementById('admin-pwd').value;
	
	$.post('admin_func_search_admin.php', {email:emailStr, name:nameStr, password:pwdStr}, function(data) {
		if(data) {
			var message = data.split(" ");
			if(message[0] != "Error") {
				document.getElementById("search-results").innerHTML = createTableFormHtml(["Name", "Email"], data, "", "");
				$("#search-results").collapse('show');
			} else {
				// error
				handleSearchError();
			}
		} else {
			handleEmptyOptions("search-results");		
		}
		$("#loadingModal").modal('hide');
	});
	return false;
}

function handleSearchPassenger() {

	$("#loadingModal").modal('show');

	var titleStr = document.getElementById('passenger-title').value;
	var firstNameStr = document.getElementById('passenger-first-name').value;
	var lastNameStr = document.getElementById('passenger-last-name').value;
	var passportStr = document.getElementById('passenger-passport').value;
	
	//var selectBar = document.getElementById('passenger-reservation-id');
    //var reservationId =  selectBar.options[selectBar.selectedIndex].value;
	
	$.post('admin_func_search_passenger.php', {title:titleStr, first_name:firstNameStr, last_name:lastNameStr, passport_number:passportStr}, function(data) {
		if(data) {
			var message = data.split(" ");
			if(message[0] != "Error") {
				document.getElementById("search-results").innerHTML = createTableFormHtml(["Title", "First Name", "Last Name", "Passport"], data, "", "");
				$("#search-results").collapse('show');
			} else {
				// error
				handleSearchError();
			}
		} else {
			handleEmptyOptions("search-results");		
		}
		$("#loadingModal").modal('hide');
	});
	return false;
}

function handleSearchAirport() {

	$("#loadingModal").modal('show');

	var nameStr = document.getElementById('airport-name').value;
	var designatorStr = document.getElementById('airport-designator').value;
	var locationStr = document.getElementById('airport-location').value;
	
	$.post('admin_func_search_airport.php', {name:nameStr, location:locationStr, designator:designatorStr}, function(data) {
		if(data) {
			var message = data.split(" ");
			if(message[0] != "Error") {
				document.getElementById("search-results").innerHTML = createTableFormHtml(["Name", "Location", "Designator"], data, "", "");
				$("#search-results").collapse('show');
			} else {
				// error
				handleSearchError();
			}
		} else {
			handleEmptyOptions("search-results");		
		}
		$("#loadingModal").modal('hide');
	});
	return false;
}

function handleSearchReservation() {

	$("#loadingModal").modal('show');

	var reservationIdStr = document.getElementById('reservation-id').value;
	var contactPersonStr =  document.getElementById('reservation-name').value;
	var contactNumberStr =  document.getElementById('reservation-number').value;
	var contactEmailStr =  document.getElementById('reservation-email').value;
	var flightNumberStr =  document.getElementById('reservation-flight-number').value;
	var departTimeMin = document.getElementById('reservation-departure-start').value;
	var departTimeMax = document.getElementById('reservation-departure-end').value;
	
	$.post('admin_func_search_reservation.php', { id: reservationIdStr,
											 c_person: contactPersonStr,
											 c_number: contactNumberStr,
											 c_email: contactEmailStr,
											 flight_number: flightNumberStr,
											 depart_time_min: departTimeMin,
											 depart_time_max: departTimeMax
											}, function(data) {
		if(data) {
			var message = data.split(" ");
			if(message[0] != "Error") {
				document.getElementById("search-results").innerHTML = createTableFormHtml(["Reservation Id", "Contact Person", "Contact Number", "Contact Email", "Flight Number", "Departure Time"], data, "", "");
				$("#search-results").collapse('show');
			} else {
				// error
				handleSearchError();
			}
		} else {
			handleEmptyOptions("search-results");		
		}
		$("#loadingModal").modal('hide');
	});
	return false;
}

function handleSearchFlight() {

	$("#loadingModal").modal('show');

	var flightStr = document.getElementById('flight-number').value;
	var originStr = document.getElementById('flight-origin').value;
	var destinationStr = document.getElementById('flight-destination').value;
	var seatMin = document.getElementById('flight-seat-min').value;
	var seatMax = document.getElementById('flight-seat-max').value;
	var durationStr = document.getElementById('flight-duration').value;
	
	$.post('admin_func_search_flight.php', { f_number: flightStr,
											 origin: originStr,
											 destination: destinationStr,
											 seat_min: seatMin,
											 seat_max: seatMax,
											 duration: durationStr
											}, function(data) {
		if(data) {
			var message = data.split(" ");
			if(message[0] != "Error") {
				document.getElementById("search-results").innerHTML = createTableFormHtml(["Flight Number", "Origin", "Destination", "Seat Capacity"], data, "", "");
				$("#search-results").collapse('show');
			} else {
				// error
				handleSearchError();
			}
		} else {
			handleEmptyOptions("search-results");	
		}
		$("#loadingModal").modal('hide');
	});
	return false;
}

function handleSearchSchedule() {

	$("#loadingModal").modal('show');

	var flightStr = document.getElementById('schedule-flight-number').value;
	var originStr = document.getElementById('schedule-origin').value;
	var destinationStr = document.getElementById('schedule-destination').value;
	var departTimeMin = document.getElementById('schedule-departure-start').value;
	var departTimeMax = document.getElementById('schedule-departure-end').value;
	var arrivalTimeMin = document.getElementById('schedule-arrival-start').value;
	var arrivalTimeMax = document.getElementById('schedule-arrival-end').value;
	var seatMin = document.getElementById('schedule-seat-min').value;
	var seatMax = document.getElementById('schedule-seat-max').value;
	var priceMin = document.getElementById('schedule-price-lowest').value;
	var priceMax = document.getElementById('schedule-price-highest').value;
	
	
	$.post('admin_func_search_schedule.php', { flight_number: flightStr,
											 origin: originStr,
											 destination: destinationStr,
											 depart_time_min: departTimeMin,
											 depart_time_max: departTimeMax,
											 arrival_time_min: arrivalTimeMin,
											 arrival_time_max: arrivalTimeMax,
											 seat_min: seatMin,
											 seat_max: seatMax,
											 price_min: priceMin,
											 price_max: priceMax
											}, function(data) {
		if(data) {
			var message = data.split(" ");
			if(message[0] != "Error") {
				document.getElementById("search-results").innerHTML = createTableFormHtml(["Flight Number", "Origin", "Departure Time", "Arrival Time", "Available Seats", "Price" ], data, "", "");
				$("#search-results").collapse('show');
			} else {
				// error
				handleSearchError();
			}
		} else {
			handleEmptyOptions("search-results");		
		}
		$("#loadingModal").modal('hide');
	});
	return false;
}

/********************************
* helper functions
*********************************/

// use by add, edit
function displayAddSuccessfulMessage(func, msg) {
	document.getElementById(func + "-successful-msg").innerHTML = msg;
	$('#' + func + '-successful-result').collapse('show');
}

function disableForm(hideId, disableId) {
	for(i = 0; i < hideId.length; i++) {
		$("#" + hideId[i]).collapse('hide');
	}
	for(i = 0; i < disableId.length; i++) {
		document.getElementById(disableId[i]).disabled = true;
	}
}

// use by delete, edit, search
function handleEmptyOptions(elementId) {
	document.getElementById(elementId).innerHTML = "<div class=\"col-xs-offset-3 col-xs-9 alert alert-info\" role = \"alert\" >No records found.</div></br>";
	$('#' + elementId).collapse('show');	
}

// use by add, edit, search
function createTableFormHtml(headers, rows, onclickFunction, buttonContent) {
	// the form created uses the get method
	var output =  "<form id = \"result-form\" action =\"\" method = \"POST\"><table id=\"resultTable\" class=\"table table-striped table-hover\"><thead>";
	
	for(i = 0; i < headers.length; i++) {
		output = output + "<th>" + headers[i] + "</th>";
	}	
	
	output = output + "</thead><tbody>" + rows + "</tbody></table>";
	
	if(buttonContent && onclickFunction) {
		output = output + "<button type=\"submit\" class=\"btn btn-primary\" onclick = \"return " + onclickFunction + "\">" + buttonContent + "</button>";
	}
	
	output = output + "</form>";
	
	return output;
}
