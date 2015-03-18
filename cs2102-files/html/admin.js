/********************************
* functions related to ADD
*********************************/

function addCategoryChange() {
	var selectBar = document.getElementById('add-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	var options = ["administrator", "member", "reservation", "airport", "flight", "schedule"];
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

	var designatorStr = document.getElementById('flight-designator').value;
	var numberStr = document.getElementById('flight-number').value;
	var selectBarO = document.getElementById('flight-origin');
	var originStr = selectBarO.options[selectBarO.selectedIndex].value;
	var selectBarD2 = document.getElementById('flight-destination');
	var destinationStr = selectBarD2.options[selectBarD2.selectedIndex].value;
	var durationStr = document.getElementById('flight-duration').value;
	var seatStr = document.getElementById('flight-seat').value;
				
	if(designatorStr && numberStr && originStr && destinationStr && durationStr && seatStr) {		
		if(validateFlightRoute()) {
			$.post('admin_func_add_flight.php', {designator:designatorStr, number:numberStr, origin:originStr, destination:destinationStr, duration:durationStr, seat:seatStr}, function(data) {
				if(data == 'inserted') {
					disableForm(['flight-button', 'add-flight-error-result', 'flightDesignatorError'], ['add-category', 'flight-designator', 'flight-number', 'flight-origin', 'flight-destination', 'flight-duration']);
					disableForm(['#flight-button', '#add-flight-error-result', '#flightDesignatorError'], ['add-category', 'flight-designator', 'flight-number', 'flight-origin', 'flight-destination', 'flight-duration', "flight-seat"]);
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
	var flightStr = selectBarF.options[selectBarF.selectedIndex].value.split(" ");
	var designatorStr = flightStr[0];
	var flightNumberStr = flightStr[1];
	
	var seatStr = document.getElementById('schedule-seats').value;
	var departureStr = document.getElementById('schedule-departure').value;
	var arrivalStr = document.getElementById('schedule-arrival').value;
	var priceStr = document.getElementById('schedule-price').value;
	
	if(designatorStr && flightNumberStr && seatStr && departureStr && arrivalStr && priceStr) {
		if(validateScheduleSeat()) {		
			$.post('admin_func_add_schedule.php', {
										designator:designatorStr, 
										f_number:flightNumberStr, 
										seatNum:seatStr, 
										price:priceStr, 
										departure:departureStr,
										arrival:arrivalStr}, function(data) {	
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
	var selectAircraft = document.getElementById('schedule-aircraft');
    var aircraft =  selectAircraft.options[selectAircraft.selectedIndex].value;
	var seat = document.getElementById('schedule-seats').value;
	if(aircraft && seat && !isNaN(seat)) {
		var totalSeat = parseInt(aircraft.split(" ")[2]);
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
	//var options = ["administrator", "member", "reservation", "airline", "aircraft", "airport", "flight", "schedule"];
	document.getElementById("delete-options").innerHTML = "";
	disableForm(['delete-success-result', 'delete-error-result'], [])
	if(option == "administrator") {
		loadAdminOptions("delete");
	} /*else if(option == "airport") {
		loadAirlineOptions("delete");
	}*/
}

function handleDeleteAdmin(id, emailStr) {
	$.post('admin_func_delete_admin.php', {email:emailStr}, function(data) {	
		if(data == "successful") {
			disableForm([id],[]);
		} else {
			document.getElementById("delete-error-msg").innerHTML = "Error message:" + resultMsg;
			$('#delete-error-result').collapse('show');
		}
	});	
	return false;
}

/********************************
* functions related to EDIT
*********************************/

function editCategoryChange() {
	var selectBar = document.getElementById('edit-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	document.getElementById("edit-options").innerHTML = "";
	if(option == "administrator") {
		loadAdminOptions("edit");
	} /*else if(option == "airport") {
		loadAirlineOptions();
	}*/
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
			document.getElementById('#' + choice + '-success-msg').innerHTML = "No entries found!";
			$('#' + choice + '-success-result').collapse('show');		
		}
	});		
}

/********************************
* functions related to SEARCH
*********************************/

function searchCategoryChange() {
	var selectBar = document.getElementById('search-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	var options = ["administrator", "member", "reservation", "airport", "flight", "schedule"];
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

	var emailStr = document.getElementById('admin-email').value;
	var nameStr = document.getElementById('admin-name').value;
	var pwdStr = document.getElementById('admin-pwd').value;
	
	$.post('admin_func_search_admin.php', {email:emailStr, name:nameStr, pwd:pwdStr}, function(data) {
		if(data) {
			var message = data.split(" ");
			if(message[0] != "Error") {
				document.getElementById("search-results").innerHTML = createTableFormHtml(["test", "Name", "Email"], data, "", "");
				$("#search-results").collapse('show');
			} else {
				// error
				handleSearchError();
			}
		} else {
			handleEmptySearchResults();			
		}
	});
	return false;
	
}

function handleEmptySearchResults() {
	document.getElementById("search-results").innerHTML = "<p>No records found.</p>";
	$("#search-results").collapse('show');
}

function handleSearchError() {
	document.getElementById("search-results").innerHTML = "Sorry, there was an error in searching!";
	$("#search-results").collapse('show');
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
