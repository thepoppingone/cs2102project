<?php 
	
	$originalNum = $_POST['originalNum'];
	$num = $_POST['num'];
	$type = $_POST['type'];
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
		$sql = "UPDATE passenger SET passport_number = '".$num."', type = '".$type."', title = '".$title."', first_name = '".$firstName."', last_name = '".$lastName."' WHERE passport_number = '".$originalNum."'";
		
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