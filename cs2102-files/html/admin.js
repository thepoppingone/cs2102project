function addCategoryChange() {
	var selectBar = document.getElementById('add-category');
    var option =  selectBar.options[selectBar.selectedIndex].value;
	var options = ["administrator", "member", "reservation", "airline", "aircraft", "airport", "flight", "schedule"];
	for(i = 0; i < options.length; i++) {
		$('#' + options[i]).collapse({toggle: false});
		if(option == options[i]) {
			$('#' + options[i]).collapse('show');	
		} else {
			$('#' + options[i]).collapse('hide');
		}
	}
}