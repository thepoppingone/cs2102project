<?php 
	
	$f_number = $_POST['f_number'];
	$duration = $_POST['duration'];
	$destination = $_POST['destination'];
	$origin = $_POST['origin'];	
	$seat_capacity = $_POST['seat_capacity'];		
	
	require("config.php");
	$sql = "SELECT * FROM flight f WHERE f.f_number='".$f_number."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "flight_exists";
	} else {
		// insert the record in
		$sql = "INSERT INTO flight VALUES(:f_number, :duration, :destination, :origin, :seat_capacity)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':f_number', $f_number);
		oci_bind_by_name($stid, ':duration', $duration);
		oci_bind_by_name($stid, ':destination', $destination);
		oci_bind_by_name($stid, ':origin', $origin);
		oci_bind_by_name($stid, ':seat_capacity', $seat_capacity);
		
		$result = oci_execute($stid);
		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "inserted";
		}
	}
	oci_free_statement($stid);
?>