<?php 
	
	$originalNum = $_POST['originalNum'];
	$num = $_POST['num'];
	$origin = $_POST['origin'];
	$dest = $_POST['dest'];
	$seatCapacity = $_POST['seatCapacity'];
	
	$continue = true;
	require("config.php");
	
	if(strcmp($originalNum, $num) !== 0) {
		// check if the new designator is acceptable
		$sql = "SELECT * FROM flight f WHERE f.f_number = '".$num."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		
		if($row = oci_fetch_array($stid)) {
			$continue = false;
			echo "flight_exists";
		}
	} 
	
	if($continue) {
		// update the record 
		$sql = "UPDATE flight SET f_number = '".$num."', origin = '".$origin."', destination = '".$dest."', seat_capacity = '".$seatCapacity."' WHERE f_number = '".$originalNum."'";
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
	ocilogoff($dbh);	
?>