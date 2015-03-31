<?php 

	$id = $_POST['id'];
	$passport = $_POST['passport'];
	$flight_number = $_POST['flight_number'];
	$depart_time = $_POST['depart_time'];
	
	require("config.php");
	
	// remove the booking_passenger first
	$sql = "DELETE FROM booking_passenger bp WHERE bp.PASSENGER = '".$passport."' AND bp.BOOKING_ID = ".$id ;
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	if(oci_num_rows($stid) == 1) {
		// release the seat book for the schedule
		$sql = "UPDATE schedule s SET s.NUM_OF_SEATS_AVAIL = s.NUM_OF_SEATS_AVAIL + 1 WHERE s.DEPART_TIME = '".$depart_time."' AND s.FLIGHT_NUMBER  = '".$flight_number."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);		
	
		if(oci_num_rows($stid) == 1) {
		
			// remove the passenger if passenger does not have any other bookings
			$sql = "DELETE FROM passenger p WHERE p.passport_number NOT IN (SELECT bp.PASSENGER FROM booking_passenger bp)";
			$stid = oci_parse($dbh, $sql);
			$result = oci_execute($stid, OCI_DEFAULT);				
			
			if($result) {
				/************
				* Successful
				*************/
				oci_commit($dbh);
				echo "edited";
			} else {
				/**************
				* Unsuccessful
				***************/	
				echo "An error occurred when removing passenger information from booking.<br/>".oci_error($stid);			
			}
		
		} else {
			/**************
			* Unsuccessful
			***************/	
			echo "An error occurred when releasing the seat.<br/>";			
		}
	} else {
			/**************
			* Unsuccessful
			***************/	
			echo "An error occurred when removing passenger information from booking.<br/>";			
	}

	oci_free_statement($stid);
	ocilogoff($dbh);
		
?>