<?php 
	
	$originalEmail = $_POST['originalEmail'];
	$email = $_POST['email'];
	$name = $_POST['name'];
	$password = $_POST['pwd'];
	
	$continue = true;
	require("config.php");
	
	if(strcmp($originalEmail, $email) !== 0) {
		// check if the new email is acceptable
		$sql = "SELECT * FROM admin a WHERE a.email = '".$email."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		
		if($row = oci_fetch_array($stid)) {
			$continue = false;
			echo "admin_exists";
		}
	} 
	
	if($continue) {
		// update the record 
		$sql = "UPDATE admin SET email = '".$email."', password = '".$password."', name = '".$name."' WHERE email = '".$originalEmail."'";
		
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid, OCI_DEFAULT);
		
		if($result) {			
			/************
			* Successful
			*************/
			oci_commit($dbh);
			echo "edited";
		} else {
			/**************
			* Unsuccessful
			***************/
			echo oci_error($stid);
		}
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
?>