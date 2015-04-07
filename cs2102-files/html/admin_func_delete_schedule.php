<?php 

	$flight_number = $_POST['flight_number'];
	$depart_time = $_POST['depart_time'];
	
	require("config.php");	
		
	// delete the schedule
	$sql = "DELETE FROM schedule s WHERE s.FLIGHT_NUMBER = '".$flight_number."' AND s.DEPART_TIME = '".$depart_time."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);			
	
	// if passenger does not have any other bookings, delete passenger
	$sql = "DELETE FROM passenger p WHERE p.PASSPORT_NUMBER NOT IN (SELECT bp.PASSENGER FROM booking_passenger bp)";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);

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