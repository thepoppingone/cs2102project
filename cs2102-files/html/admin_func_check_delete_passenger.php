<?php 
	$passport = $_POST['passport'];
	
	// check the bookings affected if passenger is deleted	
	require("config.php");
	
	$sql = "SELECT * FROM booking_passenger bp WHERE bp.passenger = '".$passport."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid);
	
	echo "Upon deleting this passenger, ".oci_num_rows($stid)." bookings will be affected.<br/>";
			
?>