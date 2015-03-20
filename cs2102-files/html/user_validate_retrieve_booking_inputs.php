<?php 
	$bookingid = $_POST['bookingid'];
	$email = $_POST['email'];
	
	require("config.php");
	$sql = "SELECT * FROM booking b WHERE b.c_email = '".$email."' and b.id = '".$bookingid."";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "booking_found";
		
	} else {
		echo "booking_not_exists";
		
	}
	oci_free_statement($stid);
?>