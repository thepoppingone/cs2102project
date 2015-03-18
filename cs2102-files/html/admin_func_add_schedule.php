<?php 
	
	date_default_timezone_set('Asia/Singapore');
	
	$designator = $_POST['designator'];
	$f_number = $_POST['f_number'];
	$aircraft = $_POST['aircraft'];
	$seatNum = $_POST['seatNum'];
	$price = $_POST['price'];
	$arrival = $_POST['arrival'];
	$departure =  $_POST['departure'];
	
	require("config.php");
	$sql = "SELECT * FROM schedule s WHERE s.flight_number = '".$f_number."'
			 AND s.depart_time = TO_TIMESTAMP('".$departure."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
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
		oci_bind_by_name($stid, ':arrival', $arrival);
		oci_bind_by_name($stid, ':departure', $departure);
		oci_bind_by_name($stid, ':seatNum', $seatNum);
		oci_bind_by_name($stid, ':price', $price);
		oci_bind_by_name($stid, ':designator', $designator);
		oci_bind_by_name($stid, ':f_number', $f_number);
		oci_bind_by_name($stid, ':aircraft', $aircraft);
		
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