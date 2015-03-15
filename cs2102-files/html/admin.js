function addCategoryChange() {
	var selectBar = document.getElementById('add-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	var options = ["administrator", "member", "reservation", "airline", "aircraft", "airport", "flight", "schedule"];
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
				$('#category-form').collapse('hide'); 
				$('#administrator').collapse('hide'); 
				document.getElementById("add-admin-successful-msg").innerHTML = "New administrator added successfully.";
				$('#add-admin-successful-result').collapse('show');
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
				$('#category-form').collapse('hide'); 
				$('#airline').collapse('hide'); 
				document.getElementById("add-airline-successful-msg").innerHTML = "New airline added successfully.";
				$('#add-airline-successful-result').collapse('show');
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
				$('#category-form').collapse('hide'); 
				$('#aircraft').collapse('hide'); 
				document.getElementById("add-aircraft-successful-msg").innerHTML = "New aircraft added successfully.";
				$('#add-aircraft-successful-result').collapse('show');
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
				$('#category-form').collapse('hide'); 
				$('#airport').collapse('hide'); 
				document.getElementById("add-airport-successful-msg").innerHTML = "New airport added successfully.";
				$('#add-airport-successful-result').collapse('show');
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

	var selectBarD = document.getElementById('flight-designator');
	var designatorStr = selectBarD.options[selectBarD.selectedIndex].value;
	var numberStr = document.getElementById('flight-number').value;
	var selectBarO = document.getElementById('flight-origin');
	var originStr = selectBarO.options[selectBarO.selectedIndex].value;
	var selectBarD2 = document.getElementById('flight-destination');
	var destinationStr = selectBarD2.options[selectBarD2.selectedIndex].value;
	var durationStr = document.getElementById('flight-duration').value;
				
	if(designatorStr && numberStr && originStr && destinationStr && durationStr) {		
		$.post('admin_addFlight.php', {designator:designatorStr, number:numberStr, origin:originStr, destination:destinationStr, duration:durationStr}, function(data) {
			if(data == 'inserted') {
				$('#category-form').collapse('hide'); 
				$('#flight').collapse('hide'); 
				document.getElementById("add-flight-successful-msg").innerHTML = "New airport added successfully.";
				$('#add-flight-successful-result').collapse('show');
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
		return false;
	} else {
		return true;
	}
}

function falseFunction() {
	return false;
}