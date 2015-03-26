<?php 

	$id = $_POST['booking_id'];
	
	// check the passengers affected if booking is deleted	
	
	require("config.php");
	
	$sql = "SELECT COUNT(*) AS COUNT FROM booking_passenger bp, passenger p WHERE bp.BOOKING_ID = '".$id."' AND bp.PASSENGER = p.PASSPORT_NUMBER AND 1 = (SELECT COUNT(*) FROM booking_passenger bp1 WHERE bp1.PASSENGER = p.PASSPORT_NUMBER)";

	$stid = oci_parse($dbh, $sql);
	oci_execute($stid);
	
	$output = "not_affected";
	
	$row = oci_fetch_array($stid);
	if($row['COUNT'] > 0) {
		$output = "If this booking is deleted, ".$row['COUNT']." passenger(s) will be deleted.<br/>";
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
	
	echo $output;
?>