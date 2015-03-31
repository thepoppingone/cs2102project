<?php 
	
	$id = $_POST['id'];
	$email = $_POST['email'];
	$name = $_POST['name'];
	$number = $_POST['number'];
	
	require("config.php");

	// update the record 
	$sql = "UPDATE booking SET c_person = '".$name."', c_email = '".$email."', c_number = '".$number."' WHERE id = '".$id."'";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);
	
	if(!$result) {
		$error_message = oci_error($stid);
		echo $error_message;
	} else {
		echo "edited";
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
?>