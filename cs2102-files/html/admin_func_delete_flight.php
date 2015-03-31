<?php 
	$f_number = $_POST['f_number'];
	
	require("config.php");
	
	// retrieve all the bookings affected
	$sql = "SELECT b.ID FROM booking b WHERE b.FLIGHT_NUMBER = '".$f_number."'";
	$booking_stid = oci_parse($dbh, $sql);
	oci_execute($booking_stid, OCI_DEFAULT);

	while($booking = oci_fetch_array($booking_stid)) {
		// for each booking, delete all related entries in booking_passenger
		$sql = "DELETE FROM booking_passenger bp WHERE bp.BOOKING_ID = '".$booking['ID']."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);					
	}
		
	// if booking does not have any other passenger, delete booking
	$sql = "DELETE FROM booking b WHERE b.ID NOT IN (SELECT bp.BOOKING_ID FROM booking_passenger bp)";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);			
		
	// delete all the schedules related to this flight
	$sql = "DELETE FROM schedule s WHERE s.FLIGHT_NUMBER = '".$f_number."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);			
	
	// if passenger does not have any other bookings, delete passenger
	$sql = "DELETE FROM passenger p WHERE p.PASSPORT_NUMBER NOT IN (SELECT bp.PASSENGER FROM booking_passenger bp)";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);

	// delete all the flights affected
	$sql = "DELETE FROM flight f WHERE f.F_NUMBER = '".$f_number."'";
	$flight_stid = oci_parse($dbh, $sql);
	oci_execute($flight_stid, OCI_DEFAULT);
	
	if($result) {
		/************
		* Successful
		*************/
		oci_commit($dbh);
		echo "successful";
	} else {
		/**************
		* Unsuccessful
		***************/	
		echo oci_error($stid);				
	}	

	oci_free_statement($stid);
	ocilogoff($dbh);	
?>