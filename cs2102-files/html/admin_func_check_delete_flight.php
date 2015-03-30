<?php 

	$f_number = $_POST['f_number'];
	
	// check the schedule, booking and passengers affected if flight is deleted	
	
	require("config.php");
	
	// check number of schedules that will de deleted
	$sql = "SELECT COUNT(*) AS SCHEDULE_COUNT FROM schedule s WHERE s.FLIGHT_NUMBER = '".$f_number."'";	
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);	
	
	$output = "not_affected";
	
	$row = oci_fetch_array($stid);
	if($row['SCHEDULE_COUNT'] > 0) {
		
		// add on to message to show schedule count
		$output = "If this flight is deleted, ".$row['SCHEDULE_COUNT']." schedule(s)";
		
		// check number of bookings that will be deleted
		$sql = "SELECT COUNT(*) AS BOOKING_COUNT FROM schedule s, booking b WHERE s.FLIGHT_NUMBER = '".$f_number."' AND b.FLIGHT_NUMBER = s.FLIGHT_NUMBER AND b.DEPART_TIME = s.DEPART_TIME";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);	
		
		$row = oci_fetch_array($stid);
		if($row['BOOKING_COUNT'] > 0) {
			// add on to message to show booking count
			$output = $output.", ".$row['BOOKING_COUNT']." booking(s) will be deleted.</br>All related passenger record(s) with no other booking(s) ";
		}
		
		$output = $output."  will be deleted.</br>";
	}

	oci_free_statement($stid);
	ocilogoff($dbh);
	
	echo $output;
?>