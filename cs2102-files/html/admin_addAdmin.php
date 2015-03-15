<?php 
	$email = $_POST['email'];
	$name = $_POST['name'];
	$password = $_POST['pwd'];
	
	require("config.php");
	$sql = "SELECT * FROM admin a WHERE a.email = '".$email."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "admin exists";
	} else {
		// insert the record in
		echo "inserted";
	}
	oci_free_statement($stid);
?>