<?php 
	
	$designator = $_POST['designator'];
	$f_number = $_POST['number'];
	$origin = $_POST['origin'];
	$destination = $_POST['destination'];
	$duration = $_POST['duration'];
	
	require("config.php");
	$sql = "SELECT * FROM flight f WHERE f.designator = '".$designator."'
			AND f.f_number='".$f_number."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "flight_exists";
	} else {
		// insert the record in
		$sql = "INSERT INTO flight VALUES(:f_number, :duration, :destination, :origin, :designator)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':f_number', $f_number);
		oci_bind_by_name($stid, ':duration', $duration);
		oci_bind_by_name($stid, ':destination', $destination);
		oci_bind_by_name($stid, ':origin', $origin);
		oci_bind_by_name($stid, ':designator', $designator);
		
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