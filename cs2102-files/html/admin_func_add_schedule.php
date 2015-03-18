<?php 
	
	date_default_timezone_set('Asia/Singapore');

	$arrival_time = $_POST['arrival_time'];	
	$depart_time = $_POST['depart_time'];
	$num_of_seats_avail = $_POST['num_of_seats_avail'];
	$price = $_POST['price'];			
	$flight_number = $_POST['flight_number'];

	
	require("config.php");
	$sql = "SELECT * FROM schedule s WHERE s.flight_number = '".$flight_number."'
			 AND s.depart_time = TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "schedule_exists";
	} else {
		// insert the record in
		$sql = "INSERT INTO schedule VALUES(TO_TIMESTAMP(:arrival,'YYYY-MM-DD\"T\"HH24:MI:SS'), TO_TIMESTAMP(:departure,'YYYY-MM-DD\"T\"HH24:MI:SS'), :seatNum, :price, :designator, :f_number, :aircraft)";
		/*
		TO_TIMESTAMP('1970-01-01T07:30:00', 'YYYY-MM-DD"T"HH24:MI:SS')
		*/
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':arrival_time', $arrival_time);
		oci_bind_by_name($stid, ':depart_time', $depart_time);
		oci_bind_by_name($stid, ':num_of_seats_avail', $num_of_seats_avail);
		oci_bind_by_name($stid, ':price', $price);
		oci_bind_by_name($stid, ':flight_number', $flight_number);

		
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