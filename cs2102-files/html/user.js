
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