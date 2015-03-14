<?php
session_start();
if(!empty($_POST)){

	require("config.php");
	
	// check login credentials for admin
	$origin = $_POST['origin'];
	$destination = $_POST['destination'];
	
	// carry out sql command
	$sql = "SELECT * FROM flight f WHERE f.origin = '".$origin."' AND f.destination = '".$destination."'";

	$stid = oci_parse($dbh, $sql);

	// without OCI_DEFAULT any changes to the database will be instantly viewable by all other connecgtions
	oci_execute($stid, OCI_DEFAULT); 

	if ($row = oci_fetch_array($stid)) 
	{	
		header("location:user_search_results.php");
	} else {
		header("location:user_search.php");
	}

	// to free up the resources
	oci_free_statement($stid);
}
?>