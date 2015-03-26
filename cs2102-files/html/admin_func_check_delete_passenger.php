<?php 
	$passport = $_POST['passport'];
	
	// check the bookings affected if passenger is deleted	
	require("config.php");
	
	$sql = "SELECT COUNT(DISTINCT bp.booking_id) AS COUNT FROM booking_passenger bp WHERE bp.passenger = '".$passport."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid);
	$row = oci_fetch_array($stid);
	
	echo "If this passenger is deleted, ".$row['COUNT']." booking(s) will be affected.<br/>";
		
	oci_free_statement($stid);
	ocilogoff($dbh);
?>