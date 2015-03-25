/********************************
* functions related to ADD
*********************************/

function addCategoryChange() {
	var selectBar = document.getElementById('add-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	var options = ["administrator", "passenger", "reservation", "airport", "flight", "schedule"];
	for(i = 0; i < options.length; i++) {
		if(option == options[i]) {
			$('#' + options[i]).collapse('show');	
		} else {
			$('#' + options[i]).collapse('hide');
		}
	}
}

function handleAddAdmin() {
	var emailStr = document.getElementById('admin-email').value;
	var nameStr = document.getElementById('admin-name').value;
	var pwdStr = document.getElementById('admin-pwd').value;
				
	if(emailStr && nameStr && pwdStr) {		
		$.post('admin_func_add_admin.php', {email:emailStr, name:nameStr, pwd:pwdStr}, function(data) {
			if(data == 'inserted') {
				disableForm(['admin-button', 'add-admin-error-result', 'adminEmailError'], ['add-category', 'admin-email', 'admin-name', 'admin-pwd']);
				displayAddSuccessfulMessage("add","New administrator added successfully.");
			}
			else if(data == 'admin_exists'){
				$('#add-admin-error-result').collapse('hide');
				$('#adminEmailError').collapse('show');
			} else {
				$('#adminEmailError').collapse('hide'); 
				document.getElementById("add-admin-error-msg").innerHTML = "Error message:" + data;
				$('#add-admin-error-result').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}

function handleAddAirport() {
	var nameStr = document.getElementById('airport-name').value;
	var locationStr = document.getElementById('airport-location').value;
	var designatorStr = document.getElementById('airport-designator').value;
				
	if(nameStr && locationStr && designatorStr) {		
		$.post('admin_func_add_airport.php', {name:nameStr, location:locationStr, designator:designatorStr}, function(data) {
			if(data == 'inserted') {
				disableForm(['airport-button', 'add-airport-error-result', 'airportDesignatorError'], ['add-category', 'airport-name', 'airport-designator', 'airport-designator']);
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
		return true;
	}
}

function handleAddFlight() {
	
	var numberStr = document.getElementById('flight-number').value;
	var durationStr = document.getElementById('flight-duration').value;
	var selectBarD2 = document.getElementById('flight-destination');
	var destinationStr = selectBarD2.options[selectBarD2.selectedIndex].value;
	var selectBarO = document.getElementById('flight-origin');
	var originStr = selectBarO.options[selectBarO.selectedIndex].value;
	var seatStr = document.getElementById('flight-seat').value;
				
	if(numberStr && durationStr && destinationStr && originStr && seatStr) {		
		if(validateFlightRoute()) {
			$.post('admin_func_add_flight.php', {f_number:numberStr, duration:durationStr, destination:destinationStr, origin:originStr, seat_capacity:seatStr}, function(data) {
				if(data == 'inserted') {
					disableForm(['flight-button', 'add-flight-error-result', 'flightDesignatorError'], ['add-category', 'flight-number', 'flight-duration', 'flight-destination', 'flight-origin', 'flight-seat']);
					displayAddSuccessfulMessage("add","New Flight added successfully.");
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
		return true;
	}
}

function validateFlightRoute() {
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


function handleAddSchedule() {
	
	var selectBarF = document.getElementById('schedule-flight');
	var flightStr = selectBarF.options[selectBarF.selectedIndex].value;
	var flightNumberStr; // set it to flight number
	var arrivalStr = document.getElementById('schedule-arrival').value;
	var departureStr = document.getElementById('schedule-departure').value;
	var seatStr = document.getElementById('schedule-seats').value;
	var priceStr = document.getElementById('schedule-price').value;
	
	if(flightStr && arrivalStr && departureStr && seatStr && priceStr) {
		if(validateScheduleSeat()) {		
			$.post('admin_func_add_schedule.php', {
										arrival_time: arrivalStr,
										depart_time: departureStr,
										num_of_seats_avail: seatStr,
										price: priceStr,
										flight_number: flightNumberStr},  function(data) {	
				if(data == 'inserted') {
					disableForm(['schedule-button', 'add-schedule-error-result', 'scheduleTimeError'], ['add-category', 'schedule-flight', 'schedule-aircraft', 'schedule-seats', 'schedule-departure', 'schedule-arrival', 'schedule-price']);
					displayAddSuccessfulMessage("add","New schedule added successfully.");
				}
				else if(data == 'schedule_exists'){
					$('#add-schedule-error-result').collapse('hide');
					$('#scheduleTimeError').collapse('show');
				} else {
					$('#scheduleTimeError').collapse('hide'); 
					document.getElementById("add-schedule-error-msg").innerHTML = "Error message:" + data;
					$('#add-schedule-error-result').collapse('show');
				}
			});
		}
		return false;
	} else {
		return true;
	}
}

function validateScheduleSeat() {
	var selectBarF = document.getElementById('schedule-flight');
	var flight = selectBarF.options[selectBarF.selectedIndex].value;
	var seat = document.getElementById('schedule-seats').value;
	if(flight && seat && !isNaN(seat)) {
		var totalSeat = parseInt(flight);
		var seatNum = parseInt(seat);
		if(seatNum > totalSeat) {
			document.getElementById("scheduleSeatError").innerHTML = "This plane can only hold a maximum of " + totalSeat + " passengers.";
			$('#scheduleSeatError').collapse('show');
		} else {
			$('#scheduleSeatError').collapse('hide');
			return true;
		}
	} else {
			$('#scheduleSeatError').collapse('hide');
	}
	return false;
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
	var originStr = document.getElementById('flight-origin').value;
	var destStr = document.getElementById('flight-dest').value;
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
			document.getElementById(choice + '-options').innerHTML = createTableFormHtml(["Passenger Number", "Type", "Title", "First Name", "Last Name"], data, "", "");
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
