<?php 
	$designator = $_POST['designator'];
	
	require("config.php");
	
	// retrieve all the flights affected
	$sql = "SELECT f.F_NUMBER FROM flight f WHERE f.ORIGIN = '".$designator."' OR f.DESTINATION = '".$designator."'";
	$flight_stid = oci_parse($dbh, $sql);
	oci_execute($flight_stid);
	
	while($flight = oci_fetch_array($flight_stid)) {
	
		// for each flight, retrieve all the bookings affected
		$sql = "SELECT b.ID FROM booking b WHERE b.FLIGHT_NUMBER = '".$flight['F_NUMBER']."'";
		$booking_stid = oci_parse($dbh, $sql);
		oci_execute($booking_stid);

		while($booking = oci_fetch_array($booking_stid)) {
			// for each booking, delete all related entries in booking_passenger
			$sql = "DELETE FROM booking_passenger bp WHERE bp.BOOKING_ID = '".$booking['ID']."'";
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid);					
		}
		
		oci_free_statement($booking_stid);
		
		// if booking does not have any other passenger, delete booking
		$sql = "DELETE FROM booking b WHERE b.ID NOT IN (SELECT bp.BOOKING_ID FROM booking_passenger bp)";
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid);			
		
		// delete all the schedules related to this flight
		$sql = "DELETE FROM schedule s WHERE s.FLIGHT_NUMBER = '".$flight['F_NUMBER']."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid);			
	}
	
	oci_free_statement($flight_stid);
	
	// if passenger does not have any other bookings, delete passenger
	$sql = "DELETE FROM passenger p WHERE p.PASSPORT_NUMBER NOT IN (SELECT bp.PASSENGER FROM booking_passenger bp)";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid);

	// delete all the flights affected
	$sql = "DELETE FROM flight f WHERE f.ORIGIN = '".$designator."' OR f.DESTINATION = '".$designator."'";
	$flight_stid = oci_parse($dbh, $sql);
	oci_execute($flight_stid);
	
	// delete airport
	$sql = "DELETE FROM airport a WHERE a.designator = '".$designator."'";
	$airport_stid = oci_parse($dbh, $sql);
	$result = oci_execute($airport_stid);
	
	if(!$result) {
		echo "Error in deleting ".$designator."<br/>".oci_error($stid)."<br/>";
	} else {
		echo "successful";
	}		

	oci_free_statement($stid);
	ocilogoff($dbh);
?>