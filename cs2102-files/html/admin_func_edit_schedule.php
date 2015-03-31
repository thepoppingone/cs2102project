<?php 
	
	
	$originalFlight = $_POST['originalFlight'];
	$originalDeparture = $_POST['originalDeparture'];
	$arrival_time = $_POST['arrival_time'];
	$depart_time = $_POST['depart_time'];
	$num_of_seats_avail = $_POST['num_of_seats_avail'];
	$price = $_POST['price'];
	
	
	$continue = true;
	require("config.php");
	
	if(strcmp($originalDeparture, $depart_time) !== 0) {
		// check if the new depart_time is acceptable
		$sql = "SELECT * FROM schedule s WHERE s.flight_number = '".$originalFlight."' AND s.depart_time =  TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS')"; ;
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		
		if($row = oci_fetch_array($stid)) {
			$continue = false;
			echo "schedule_exists";
		}
	} 
	
	if($continue) {
		// update the record 
		$sql = "UPDATE schedule 
				SET arrival_time = TO_TIMESTAMP('".$arrival_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS'), 
					depart_time = TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS'), 
					num_of_seats_avail = '".$num_of_seats_avail."', 
					price = '".$price."' 
				WHERE flight_number = '".$originalFlight."'AND depart_time = '".$originalDeparture."'";
		
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid);
		
		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "edited";
		}
	}
	
	oci_free_statement($stid);
?>