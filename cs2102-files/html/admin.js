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

function handleAddAdmin() {
	var emailStr = String(document.getElementById('admin_email').value);
	var nameStr = String(document.getElementById('admin_name').value);
	var pwdStr = String(document.getElementById('admin_pwd').value);

	if(emailStr && nameStr && pwdStr) {		
		$.post('admin_addAdmin.php', {email:emailStr, name:nameStr, pwd:pwdStr}, function(data) {
			if(data == 'inserted') {
				$('#add-admin-form').submit();
			}
			else {
				$('#adminEmailError').collapse('show'); 
				return false;
			}
		});
	}
	 
    return false;
}
