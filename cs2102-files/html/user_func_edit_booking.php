<?php 
	
	$bookingID = $_POST['bookingID'];
	$bookingFlight = $_POST['bookingFlight'];
	$bookingDepartTime = $_POST['bookingDepartTime'];
	$bookingEmail = $_POST['bookingEmail'];
	$bookingName = $_POST['bookingName'];
	$bookingNumber = $_POST['bookingNumber'];
	
	$continue = true;
	require("config.php");
	
	//if(strcmp($originalNum, $num) !== 0) {
	//	// check if the new passenger number is acceptable
	//	$sql = "SELECT * FROM passenger p WHERE p.passport_number = '".$num."'";
	//	$stid = oci_parse($dbh, $sql);
	//	oci_execute($stid, OCI_DEFAULT);
	//	
	//	if($row = oci_fetch_array($stid)) {
	//		$continue = false;
	//		echo "passenger_exists";
	//	}
	//} 
	
	if($continue) {
		// update the record 
		$sql = "UPDATE booking SET c_person = '".$bookingName."', c_number = '".$bookingNumber."', c_email = '".$bookingEmail."' where id = '".$bookingID"'";
		
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid);
		
		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "edited";
		}
	}
	
	oci_free_statement($stid);
?>