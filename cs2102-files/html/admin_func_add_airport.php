<?php 

	/***************************************************************************
	* admin_func_add_airport.php 
	* function : to add an airport
	* results  : adds a non-existing new airport record into the database. 
	* echo "inserted" implies the expected results are satisfy
	* echo "airport_exists" implies an existing record
	* else an error message is echoed.
	****************************************************************************/
	
	
	/******************
	* Required Inputs
	*******************/
	$name = $_POST['name'];
	$location = $_POST['location'];
	$designator = $_POST['designator'];
	
	require("config.php");
	/*******************
	* Start of inserting
	********************/
	
	$sql = "SELECT * FROM airport a WHERE a.DESIGNATOR = '".$designator."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	if($row = oci_fetch_array($stid)) {
	
		/***************
		* Record Exists
		****************/
		echo "airport_exists";
		
	} else {
	
		// insert the record in
		$sql = "INSERT INTO airport VALUES(:name, :location, :designator)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':name', $name);
		oci_bind_by_name($stid, ':location', $location);
		oci_bind_by_name($stid, ':designator', $designator);
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