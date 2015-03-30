<?php 

	$designator = $_POST['designator'];
	
	// check the flight, schedule, booking and passengers affected if airport is deleted	
	
	require("config.php");
	
	$sql = "SELECT COUNT(*) AS COUNT FROM flight f WHERE f.ORIGIN = '".$designator."' OR f.DESTINATION = '".$designator."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	$output = "not_affected";
	
	$row = oci_fetch_array($stid);
	if($row['COUNT'] > 0) {
		$output = "If this airport is deleted, ".$row['COUNT']." flight(s) will be deleted. </br>All related schedule(s), booking(s), and passenger(s) records with no other booking(s) will be deleted too.</br>";
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
	
	echo $output;
?>