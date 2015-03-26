<?php 
	$passport = $_POST['passport'];
	
	require("config.php");
	
	$output = "";
	
	// retrieve all the booking affected
	$sql = "SELECT b.DEPART_TIME, b.FLIGHT_NUMBER FROM booking_passenger bp, booking b WHERE bp.PASSENGER = '".$passport."' AND bp.BOOKING_ID = b.ID";
	$stid_booking_affected = oci_parse($dbh, $sql);
	$result = oci_execute($stid_booking_affected);
	
	if($result) {
	
		// +1 to the flight schedule available seats
		while ($row = oci_fetch_array($stid_booking_affected)) {
			$sql = "UPDATE schedule s  SET s.NUM_OF_SEATS_AVAIL = s.NUM_OF_SEATS_AVAIL + 1 WHERE s.DEPART_TIME = '".$row['DEPART_TIME']."' AND s.FLIGHT_NUMBER  = '".$row['FLIGHT_NUMBER']."'";
			$stid = oci_parse($dbh, $sql);
			$result = oci_execute($stid);
		}
		
		// delete from booking_passenger
		$sql = "DELETE FROM booking_passenger bp WHERE bp.PASSENGER = '".$passport."'";
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid);	

		
		if($result) {
			// if booking does not have any passenger left, delete booking
			$sql = "DELETE FROM booking b WHERE b.ID NOT IN (SELECT bp.BOOKING_ID FROM booking_passenger bp)";
			$stid = oci_parse($dbh, $sql);
			$result = oci_execute($stid);

			
			if($result) {
				// delete passenger
				$sql = "DELETE FROM passenger p WHERE p.passport_number = '".$passport."'";
				$stid = oci_parse($dbh, $sql);
				$result = oci_execute($stid);
				echo "successful";	
			}
		}
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
		
?>