 <?php 
	
	/**************************************************************************************************************
	* admin_func_verify_passenger.php 
	* function  : to check the passenger details 
	* results   : echo "new_passenger" if passenger does not exists
	*			  echo a long output for displaying if the passenger exists
	**************************************************************************************************************/
	
	/******************
	* Required Inputs
	*******************/
	$numOfPassenger = $_POST['numOfPassenger'];
	
	$output = "";
	
	require("config.php");
	for ($x = 1; $x <= $numOfPassenger; $x++) {
		$passport = $_POST['passport'.$x];
		$sql = "SELECT * FROM passenger p WHERE p.PASSPORT_NUMBER = '".$passport."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		if($row = oci_fetch_array($stid)) {
			if(!empty($output)) {
				$output = $output.",";
			}
			// passenger exists
			$output = $output." ".$x;
		}
	}
	
	if(empty($output)) {
		echo "new_passenger";
	} else {
		echo "Passenger ".$output."is already recorded in the database.";
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
?>