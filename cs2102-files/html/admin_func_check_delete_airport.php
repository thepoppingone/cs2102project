<?php 

	$designator = $_POST['designator'];
	
	// check the flight, schedule, booking and passengers affected if airport is deleted	
	
	require("config.php");
	
	$sql = "SELECT COUNT(*) AS COUNT FROM flight f WHERE f.ORIGIN = '".$designator."' OR f.DESTINATION = '".$designator."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid);
	
	$output = "not_affected";
	
	$row = oci_fetch_array($stid);
	if($row['COUNT'] > 0) {
	
		$output = "If this airport is deleted, ".$row['COUNT']." flight(s)";
	
		$sql = "SELECT COUNT(*) AS COUNT FROM schedule s, flight f WHERE (f.ORIGIN = '".$designator."' OR f.DESTINATION = '".$designator."') AND f.F_NUMBER = s.FLIGHT_NUMBER";	
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid);	
		
		$row = oci_fetch_array($stid);
		if($row['COUNT'] > 0) {
			$output = $output.", ".$row['COUNT']." schedule(s)";
			
			$sql = "SELECT COUNT(*) AS COUNT FROM booking b, flight f WHERE (f.ORIGIN = '".$designator."' OR f.DESTINATION = '".$designator."') AND b.FLIGHT_NUMBER = f.F_NUMBER";
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid);	
			
			$row = oci_fetch_array($stid);
			if($row['COUNT'] > 0) {
				$output = $output.", ".$row['COUNT']." booking(s)";
				
				$sql = "SELECT COUNT(*) AS COUNT FROM booking_passenger bp, booking b, flight f WHERE (f.ORIGIN = '".$designator."' OR f.DESTINATION = '".$designator."') AND b.FLIGHT_NUMBER = f.F_NUMBER AND bp.BOOKING_ID = b.ID AND bp.passenger IN (SELECT bp1.passenger FROM booking_passenger bp1 GROUP BY (bp1.passenger) HAVING COUNT(bp1.booking_id) = 1)";
				$stid = oci_parse($dbh, $sql);
				oci_execute($stid);		
				
				$row = oci_fetch_array($stid);
				if($row['COUNT'] > 0) {
					$output = $output.", ".$row['COUNT']." passenger(s)";
				}
			}
		}
		
		$output = $output."  will be deleted.</br>";
	
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
	
	echo $output;
?>