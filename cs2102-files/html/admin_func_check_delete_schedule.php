<?php 

	$flight_number = $_POST['flight_number'];
	$depart_time = $_POST['depart_time'];
	
	$output = "not_affected";
	
	require("config.php");
	
	// check number of bookings that will be deleted
	$sql = "SELECT COUNT(*) AS BOOKING_COUNT FROM booking b WHERE b.FLIGHT_NUMBER = '".$flight_number."' AND b.DEPART_TIME = '".$depart_time."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);	
	
	$row = oci_fetch_array($stid);
	if($row['BOOKING_COUNT'] > 0) {
		// add on to message to show bookings affected
		$output = "If this schedule is deleted, ".$row['BOOKING_COUNT']." booking(s) will be deleted. All related passenger record(s) with no other booking(s) will be deleted.";
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
	
	echo $output;
?>