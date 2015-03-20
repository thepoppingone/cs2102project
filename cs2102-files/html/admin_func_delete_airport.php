<?php 
	$designator = $_POST['designator'];
	
	require("config.php");
	$sql = "DELETE FROM airport a WHERE a.designator = '".$designator."'";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid);
	
	if(!$result) {
		echo "Error in deleting ".$designator."<br/>".oci_error($stid)."<br/>";
	} else {
		echo "successful";
	}			
?>