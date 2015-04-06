<?php 
	$designator = $_POST['designator'];
	
	require("config.php");

	$sql = "DELETE FROM airport a WHERE a.designator = '".$designator."'";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);
	
	// if passenger does not have any other bookings, delete passenger
	$sql = "DELETE FROM passenger p WHERE p.PASSPORT_NUMBER NOT IN (SELECT bp.PASSENGER FROM booking_passenger bp)";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);
	
	if($result) {
		/************
		* Successful
		*************/
		oci_commit($dbh);
		echo "successful";
	} else {
		/**************
		* Unsuccessful
		***************/	
		echo oci_error($stid);				
	}	

	oci_free_statement($stid);
	ocilogoff($dbh);
?>