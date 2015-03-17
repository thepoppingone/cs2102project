<?php 
	$email = $_POST['email'];
	$name = $_POST['name'];
	$password = $_POST['pwd'];
	
	require("config.php");
	$sql = "SELECT * FROM admin a WHERE a.email = '".$email."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "admin_exists";
	} else {
		// insert the record in
		$sql = "INSERT INTO admin VALUES(:name, :email, :password)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':name', $name);
		oci_bind_by_name($stid, ':email', $email);
		oci_bind_by_name($stid, ':password', $password);
		
		$result = oci_execute($stid);
		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "inserted";
		}
	}
	oci_free_statement($stid);
?>