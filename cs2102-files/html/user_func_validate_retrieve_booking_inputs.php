<?php 

	$bookingID = $_POST['inputBookingID'];
	$email = $_POST['inputEmail'];
	
	require("config.php");
	$sql = "SELECT * FROM booking b WHERE b.c_email = '".$email."' and b.id = '".$bookingID."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
	
echo 'booking_found';
	} else {
		

echo 'booking_not_exists';
		
	}
	oci_free_statement($stid);

?>