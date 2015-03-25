<?php 

	$id = $_POST['booking_id'];
	
	require("config.php");
	
	$output = "";
	
	// retrieve number of passengers affected
	$sql = "SELECT  b.DEPART_TIME, b.FLIGHT_NUMBER, COUNT(*) AS COUNT_PASSENGER FROM booking_passenger bp, booking b WHERE bp.BOOKING_ID = b.ID AND b.ID = '".$id."' GROUP BY b.ID, b.FLIGHT_NUMBER, b.DEPART_TIME";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid);
	
	if($result) {
	
		$row = oci_fetch_array($stid);
		// +number of passengers to flight schedule available seats 
		$sql = "UPDATE schedule s SET s.NUM_OF_SEATS_AVAIL = s.NUM_OF_SEATS_AVAIL + ".$row['COUNT_PASSENGER']." WHERE s.DEPART_TIME = '".$row['DEPART_TIME']."' AND s.FLIGHT_NUMBER  = '".$row['FLIGHT_NUMBER']."'";
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid);
		
		if($result) { 
		
			// delete from booking_passenger
			$sql = "DELETE FROM booking_passenger bp WHERE bp.BOOKING_ID = '".$id."'";
			$stid = oci_parse($dbh, $sql);
			$result = oci_execute($stid);	
		
			if($result) {
				// if passenger does not have any other bookings, delete passenger
				$sql = "DELETE FROM passenger p WHERE p.PASSPORT_NUMBER NOT IN (SELECT bp.PASSENGER FROM booking_passenger bp)";
				$stid = oci_parse($dbh, $sql);
				$result = oci_execute($stid);

				
				if($result) {
					// delete from booking
					$sql = "DELETE FROM booking b WHERE b.ID = '".$id."'";
					$stid = oci_parse($dbh, $sql);
					$result = oci_execute($stid);
					echo "successful";	
				}
			}
			
		}
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
		
?>