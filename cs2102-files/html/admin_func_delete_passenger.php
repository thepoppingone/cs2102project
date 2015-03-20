<?php 
	$passport = $_POST['passport'];
	
	require("config.php");
	$sql = "DELETE FROM passenger p WHERE p.passport_number = '".$passport."'";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid);
	
	if(!$result) {
		echo "Error in deleting ".$passport."<br/>".oci_error($stid)."<br/>";
	} else {
		echo "successful";
	}			
?>