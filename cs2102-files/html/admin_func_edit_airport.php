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
		// update the record 
		$sql = "UPDATE airport SET designator = '".$designator."', location = '".$location."', name = '".$name."' WHERE designator = '".$originalDesignator."'";
		
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