<?php 
	
	$originalFlight = $_POST['originalFlight'];
	$originalDeparture = $_POST['originalDeparture'];
	$arrival_time = $_POST['arrival_time'];
	$depart_time = $_POST['depart_time'];
	$num_of_seats_avail = $_POST['num_of_seats_avail'];
	$price = $_POST['price'];
	
	require("config.php");
		
	// Check if there are any other schedules for the flight with the same scheduled depart time given that the user modified the depart time
	// cannot compare $originalDeparture with $depart_time directly in php because they are not formatted the same
	$sql = "SELECT * FROM schedule s WHERE s.flight_number = '".$originalFlight."' AND s.depart_time =  TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS') AND TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS') <> '".$originalDeparture."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	if($row = oci_fetch_array($stid)) {
		echo "schedule_exists";
	} else {
	
		// update the record 
		$sql = "UPDATE schedule 
				SET arrival_time = TO_TIMESTAMP('".$arrival_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS'), 
					depart_time = TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS'), 
					num_of_seats_avail = '".$num_of_seats_avail."', 
					price = '".$price."' 
				WHERE flight_number = '".$originalFlight."' AND depart_time = '".$originalDeparture."'";
		
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid, OCI_DEFAULT);
		
		if($result) {			
			/************
			* Successful
			*************/
		} else {
			/**************
			* Unsuccessful
			***************/
			echo oci_error($stid);
		}

		//MY EXTRA CODES HERE 
		$sql = "UPDATE booking
				SET depart_time = TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS')
				WHERE flight_number = '".$originalFlight."' AND depart_time = '".$originalDeparture."'";
		
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
			echo oci_error($stid);
		}

	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
	
?>