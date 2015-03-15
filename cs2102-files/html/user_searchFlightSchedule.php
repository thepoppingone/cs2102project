<?php
	
if(!empty($_POST)){
	
	// check login credentials for admin
	$origin = $_POST['origin'];
	$destination = $_POST['destination'];
	
	date_default_timezone_set('Asia/Singapore'); 
	
	$departure_date = date("Y-m-d", strtotime ($_POST['departure_date'])); // format: yyyy-mm-dd
	$today_date = date('Y-m-d');
	
	if($departure_date < $today_date) {
		echo "departure_date is no longer valid";
	} else {
	
		require("config.php");
		
		// carry out sql command
		$sql = "SELECT * FROM schedule s, flight f 
				WHERE s.depart_time >= TO_TIMESTAMP('".$departure_date."', 'YYYY-MM-DD')
				AND f.origin LIKE '%".$origin."%'
				AND f.destination LIKE '%".$destination."%' 
				AND f.f_number = s.flight_number 
				AND f.designator = s.designator";

		$stid = oci_parse($dbh, $sql);

		// without OCI_DEFAULT any changes to the database will be instantly viewable by all other connecgtions
		oci_execute($stid, OCI_DEFAULT); 

		while ($row = oci_fetch_array($stid)) 
		{
			echo $row[0];
		}
		
		echo "end of file";
		

		// to free up the resources
		oci_free_statement($stid);
	}
	
}
?>