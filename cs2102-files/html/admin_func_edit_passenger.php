<?php 
	
	$originalNum = $_POST['originalNum'];
	$num = $_POST['num'];
	$title = $_POST['title'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	
	$continue = true;
	require("config.php");
	
	if(strcmp($originalNum, $num) !== 0) {
		// check if the new passenger number is acceptable
		$sql = "SELECT * FROM passenger p WHERE p.passport_number = '".$num."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		
		if($row = oci_fetch_array($stid)) {
			$continue = false;
			echo "passenger_exists";
		}
	} 
	
	if($continue) {
		
		// update the record 
		$sql = "UPDATE passenger SET passport_number = '".$num."', title = '".$title."', first_name = '".$firstName."', last_name = '".$lastName."' WHERE passport_number = '".$originalNum."'";
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid, OCI_DEFAULT);
		
		// update the booking_passenger table
		$sql = "UPDATE booking_passenger SET passenger = '".$num."' WHERE passenger = '".$originalNum."'";
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