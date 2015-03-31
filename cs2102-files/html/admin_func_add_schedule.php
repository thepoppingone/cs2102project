<?php 
	
	/*********************************************************************************
	* admin_func_add_schedule.php 
	* function : to add a schedule
	* results  : adds a non-existing new schedule record into the database. 
	* echo "inserted" implies the expected results are satisfy
	* echo "schedule_exists" implies an existing record
	* else an error message is echoed.
	**********************************************************************************/
	
	//date_default_timezone_set('Asia/Singapore');
	
	/******************
	* Required Inputs
	*******************/
	$flight_number = $_POST['flight_number'];
	$depart_time = $_POST['depart_time'];
	$arrival_time = $_POST['arrival_time'];	
	$price = $_POST['price'];			

	
	require("config.php");	
	/*******************
	* Start of inserting
	********************/		
	
	$sql = "SELECT * FROM schedule s WHERE s.FLIGHT_NUMBER = '".$flight_number."'
			 AND s.DEPART_TIME = TO_TIMESTAMP('".$depart_time."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	if($row = oci_fetch_array($stid)) {
	
		/***************
		* Record Exists
		****************/	
		echo "schedule_exists";
		
	} else {
		// retrieve the number of seats capacity
		$sql = "SELECT f.SEAT_CAPACITY FROM flight f WHERE f.F_NUMBER = '".$flight_number."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);		
		$num_of_seats_avail = oci_fetch_array($stid)['SEAT_CAPACITY'];
		
		
		// insert the record in
		$sql = "INSERT INTO schedule VALUES(TO_TIMESTAMP(:arrival_time,'YYYY-MM-DD\"T\"HH24:MI:SS'), TO_TIMESTAMP(:depart_time,'YYYY-MM-DD\"T\"HH24:MI:SS'), :num_of_seats_avail, :price, :flight_number)";
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':arrival_time', $arrival_time);
		oci_bind_by_name($stid, ':depart_time', $depart_time);
		oci_bind_by_name($stid, ':num_of_seats_avail', $num_of_seats_avail);
		oci_bind_by_name($stid, ':price', $price);
		oci_bind_by_name($stid, ':flight_number', $flight_number);
		$result = oci_execute($stid, OCI_DEFAULT);
		
		if($result) {
		
			/************
			* Successful
			*************/
			oci_commit($dbh);
			echo "inserted";
			
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