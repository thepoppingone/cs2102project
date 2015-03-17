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
	var emailStr = String(document.getElementById('admin-email').value);
	var nameStr = String(document.getElementById('admin-name').value);
	var pwdStr = String(document.getElementById('admin-pwd').value);
				
	if(emailStr && nameStr && pwdStr) {		
		$.post('admin_addAdmin.php', {email:emailStr, name:nameStr, pwd:pwdStr}, function(data) {
			if(data == 'inserted') {
				disableForm(['admin-button', 'add-admin-error-result', 'adminEmailError'], ['add-category', 'admin-email', 'admin-name', 'admin-pwd']);
				displayAddSuccessfulMessage("New administrator added successfully.");
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

function handleAddAirline() {
	var nameStr = document.getElementById('airline-name').value;
	var designatorStr = document.getElementById('airline-designator').value;
				
	if(nameStr && designatorStr) {		
		$.post('admin_addAirline.php', {name:nameStr, designator:designatorStr}, function(data) {
			if(data == 'inserted') {
				disableForm(['airline-button', 'add-airline-error-result', 'airlineDesignatorError'], ['add-category', 'airline-name', 'airline-designator']);
				displayAddSuccessfulMessage("New airline added successfully.");
			}
			else if(data == 'airline_exists'){
				$('#add-airline-error-result').collapse('hide');
				$('#airlineDesignatorError').collapse('show');
			} else {
				$('#airlineDesignatorError').collapse('hide'); 
				document.getElementById("add-airline-error-msg").innerHTML = "Error message:" + data;
				$('#add-airline-error-result').collapse('show');
			}
		});
		return false;
	} else {
		return true;
	}
}

function handleAddAircraft() {
	var selectBar = document.getElementById('aircraft-designator');
	var designatorStr = selectBar.options[selectBar.selectedIndex].value;
	var aircraftIdStr = document.getElementById('aircraft-id').value;
	var modelStr = document.getElementById('aircraft-model').value;
	var seatCapacityStr = document.getElementById('aircraft-seatcapacity').value;
				
	if(designatorStr && aircraftIdStr && modelStr && seatCapacityStr) {		
		$.post('admin_addAircraft.php', {id: aircraftIdStr, model: modelStr, seatCapacity: seatCapacityStr, designator:designatorStr}, function(data) {
			if(data == 'inserted') {
				disableForm(['aircraft-button', 'add-aircraft-error-result', 'aircraftIdError'], ['add-category', 'aircraft-designator', 'aircraft-id', 'aircraft-model', 'aircraft-seatcapacity']);
				displayAddSuccessfulMessage("New aircraft added successfully.");
			}
			else if(data == 'aircraft_exists'){
				$('#add-aircraft-error-result').collapse('hide');
				$('#aircraftIdError').collapse('show');
			} else {
				$('#aircraftIdError').collapse('hide'); 
				document.getElementById("add-aircraft-error-msg").innerHTML = "Error message:" + data;
				$('#add-aircraft-error-result').collapse('show');
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
		$.post('admin_addAirport.php', {name:nameStr, location:locationStr, designator:designatorStr}, function(data) {
			if(data == 'inserted') {
				disableForm(['airport-button', 'add-airport-error-result', 'airportDesignatorError'], ['add-category', 'airport-name', 'airport-designator', 'airport-designator']);
				displayAddSuccessfulMessage("New airport added successfully.");
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
			$.post('admin_addFlight.php', {designator:designatorStr, number:numberStr, origin:originStr, destination:destinationStr, duration:durationStr, seat:seatStr}, function(data) {
				if(data == 'inserted') {
					disableForm(['flight-button', 'add-flight-error-result', 'flightDesignatorError'], ['add-category', 'flight-designator', 'flight-number', 'flight-origin', 'flight-destination', 'flight-duration']);
					disableForm(['#flight-button', '#add-flight-error-result', '#flightDesignatorError'], ['add-category', 'flight-designator', 'flight-number', 'flight-origin', 'flight-destination', 'flight-duration', "flight-seat"]);
					displayAddSuccessfulMessage("New Flight added successfully.");
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
			$.post('admin_addSchedule.php', {
										designator:designatorStr, 
										f_number:flightNumberStr, 
										seatNum:seatStr, 
										price:priceStr, 
										departure:departureStr,
										arrival:arrivalStr}, function(data) {	
				if(data == 'inserted') {
					disableForm(['schedule-button', 'add-schedule-error-result', 'scheduleTimeError'], ['add-category', 'schedule-flight', 'schedule-aircraft', 'schedule-seats', 'schedule-departure', 'schedule-arrival', 'schedule-price']);
					displayAddSuccessfulMessage("New schedule added successfully.");
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

function displayAddSuccessfulMessage(msg) {
	document.getElementById("add-successful-msg").innerHTML = msg;
	$('#add-successful-result').collapse('show');
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
		loadAdminOptions();
	} /*else if(option == "airport") {
		loadAirlineOptions();
	}*/
}

function loadAdminOptions() {
	$.post('admin_deleteAdmin.php', function(data) {
		if(data) {
			// headers in array, rows, function to call when delete button is clicked, words in the button
			document.getElementById("delete-options").innerHTML = createTableFormHtml(["Delete","Name","Email"], data, "handleDeleteAdmin()", "Delete Administrator(s)");
			$('#delete-options').collapse('show');
		} else {
			document.getElementById("delete-success-msg").innerHTML = "No entries found!";
			$('#delete-success-result').collapse('show');		
		}
	});	
}

function handleDeleteAdmin() {
	var inputElements = document.getElementsByClassName('checked-administrator');
	var emails = "";
	for(i = 0; i < inputElements.length; i++) {
		if(inputElements[i].checked && inputElements[i].disabled == false){
		   emails = emails + inputElements[i].value + " ";
		}
	}
	
	$.post('admin_deleteAdmin.php', {email:emails}, function(resultMsg) {	
		var message = resultMsg.split(" ");
		if(message[0] == "successful") {
			disableForm([], message.slice(1,message.length-1));
			document.getElementById("delete-success-msg").innerHTML = "" + (message.length - 2) + " entries deleted.";
			$('#delete-success-result').collapse('show');
		} else {
			document.getElementById("delete-error-msg").innerHTML = "Error message:" + resultMsg;
			$('#delete-error-result').collapse('show');
		}
	});	
	return false;
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
	var emailStr = String(document.getElementById('admin-email').value);
	var nameStr = String(document.getElementById('admin-name').value);
	var pwdStr = String(document.getElementById('admin-pwd').value);
	
	$.post('admin_searchAdmin.php', {email:emailStr, name:nameStr, pwd:pwdStr}, function(data) {
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

function disableForm(hideId, disableId) {
	for(i = 0; i < hideId.length; i++) {
		$("#" + hideId[i]).collapse('hide');
	}
	for(i = 0; i < disableId.length; i++) {
		document.getElementById(disableId[i]).disabled = true;
	}
}

function createTableFormHtml(headers, rows, onclickFunction, buttonContent) {

	var output =  "<form><table id=\"resultTable\" class=\"table table-striped table-hover\"><thead>";
	
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
