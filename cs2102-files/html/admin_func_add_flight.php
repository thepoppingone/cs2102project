<?php 

	/***************************************************************************
	* admin_func_add_flight.php 
	* function : to add a flight
	* results  : adds a non-existing new flight record into the database. 
	* echo "inserted" implies the expected results are satisfy
	* echo "flight_exists" implies an existing record
	* else an error message is echoed.
	****************************************************************************/	
	
	$f_number = 'SB'.$_POST['f_number'];
	$destination = $_POST['destination'];
	$origin = $_POST['origin'];	
	$seat_capacity = $_POST['seat_capacity'];		
	
	require("config.php");
	$sql = "SELECT * FROM flight f WHERE f.F_NUMBER ='".$f_number."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	if($row = oci_fetch_array($stid)) {
	
		/***************
		* Record Exists
		****************/	
		echo "flight_exists";
		
	} else {
	
		// insert the record in
		$sql = "INSERT INTO flight VALUES(:f_number, :destination, :origin, :seat_capacity)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':f_number', $f_number);
		oci_bind_by_name($stid, ':destination', $destination);
		oci_bind_by_name($stid, ':origin', $origin);
		oci_bind_by_name($stid, ':seat_capacity', $seat_capacity);
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