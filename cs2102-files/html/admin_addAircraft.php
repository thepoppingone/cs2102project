<?php 
	$id = $_POST['id'];
	$model = $_POST['model'];
	$seatCapacity = $_POST['seatCapacity'];
	$designator = $_POST['designator'];
	
	require("config.php");
	$sql = "SELECT * FROM plane p WHERE p.aircraft_no = '".$id."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "aircraft_exists";
	} else {
		// insert the record in
		$sql = "INSERT INTO plane VALUES(:id, :model, :seatCapacity, :designator)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':id', $id);
		oci_bind_by_name($stid, ':model', $model);
		oci_bind_by_name($stid, ':seatCapacity', $seatCapacity);
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