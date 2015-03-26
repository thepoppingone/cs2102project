<?php 

	$f_number = $_POST['f_number'];
	
	// check the schedule, booking and passengers affected if flight is deleted	
	
	require("config.php");
	
	// check number of schedules that will de deleted
	$sql = "SELECT COUNT(*) AS SCHEDULE_COUNT FROM schedule s WHERE s.FLIGHT_NUMBER = '".$f_number."'";	
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid);	
	
	$output = "not_affected";
	
	$row = oci_fetch_array($stid);
	if($row['SCHEDULE_COUNT'] > 0) {
		
		// add on to message to show schedule count
		$output = "If this flight is deleted, ".$row['SCHEDULE_COUNT']." schedule(s)";
		
		// check number of bookings that will be deleted
		$sql = "SELECT COUNT(*) AS BOOKING_COUNT FROM schedule s, booking b WHERE s.FLIGHT_NUMBER = '".$f_number."' AND b.FLIGHT_NUMBER = s.FLIGHT_NUMBER AND b.DEPART_TIME = s.DEPART_TIME";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid);	
		
		$row = oci_fetch_array($stid);
		if($row['BOOKING_COUNT'] > 0) {
			
			// add on to message to show booking count
			$output = $output.", ".$row['BOOKING_COUNT']." booking(s)";
			
			// check number of passengers that will be deleted
			$sql = "SELECT COUNT(*) AS PASSENGER_COUNT FROM schedule s, booking b, booking_passenger bp, passenger p WHERE s.FLIGHT_NUMBER = '".$f_number."' AND b.FLIGHT_NUMBER = s.FLIGHT_NUMBER AND b.DEPART_TIME = s.DEPART_TIME AND bp.BOOKING_ID = b.ID AND bp.PASSENGER = p.PASSPORT_NUMBER AND 1 = (SELECT COUNT(*) FROM booking_passenger bp1 WHERE bp1.PASSENGER = p.PASSPORT_NUMBER)";
		
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid);		
			
			$row = oci_fetch_array($stid);
			if($row['PASSENGER_COUNT'] > 0) {
				// add on to message to show passenger count
				$output = $output.", ".$row['PASSENGER_COUNT']." passenger(s)";
			}
		}
		$output = $output."  will be deleted.</br>";
	}

	oci_free_statement($stid);
	ocilogoff($dbh);
	
	echo $output;
?>