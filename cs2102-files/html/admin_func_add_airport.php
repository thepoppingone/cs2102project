<?php 
	$name = $_POST['name'];
	$location = $_POST['location'];
	$designator = $_POST['designator'];
	
	require("config.php");
	$sql = "SELECT * FROM airport a WHERE a.designator = '".$designator."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "airport_exists";
	} else {
		// insert the record in
		$sql = "INSERT INTO airport VALUES(:name, :location, :designator)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':name', $name);
		oci_bind_by_name($stid, ':location', $location);
		oci_bind_by_name($stid, ':designator', $designator);
		
		$result = oci_execute($stid);
		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "inserted";
		}
	}
	oci_free_statement($stid);
?>