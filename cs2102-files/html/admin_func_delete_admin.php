<?php 
	$email = $_POST['email'];
	
	require("config.php");
	$sql = "DELETE FROM admin a WHERE a.email = '".$email."'";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid);
	
	if(!$result) {
		echo "Error in deleting ".$email."<br/>".oci_error($stid)."<br/>";
	} else {
		echo "successful";
	}			
	
	oci_free_statement($stid);
	ocilogoff($dbh);
	
?>