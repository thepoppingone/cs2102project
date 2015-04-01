<?php 
	
	$originalDesignator = $_POST['originalDesignator'];
	$name = $_POST['name'];
	$location = $_POST['location'];
	$designator = $_POST['designator'];
	
	$continue = true;
	require("config.php");
	
	if(strcmp($originalDesignator, $edesignator) !== 0) {
		// check if the new designator is acceptable
		$sql = "SELECT * FROM airport a WHERE a.designator = '".$designator."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		
		if($row = oci_fetch_array($stid)) {
			$continue = false;
			echo "airport_exists";
		}
	} 
	
	if($continue) {
		// update airport 
		$sql = "UPDATE airport SET designator = '".$designator."', location = '".$location."', name = '".$name."' WHERE designator = '".$originalDesignator."'";
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid, OCI_DEFAULT);
		
		// update affected flights
		$sql = "UPDATE flight SET origin = '".$designator."' WHERE origin = '".$originalDesignator."'";
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid, OCI_DEFAULT);
		
		$sql = "UPDATE flight SET destination = '".$designator."' WHERE destination = '".$originalDesignator."'";
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