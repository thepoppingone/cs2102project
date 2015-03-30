<?php 
	$email = $_POST['email'];
	
	require("config.php");
	$sql = "DELETE FROM admin a WHERE a.email = '".$email."'";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);
	
	if($result) {
		/************
		* Successful
		*************/
		oci_commit($dbh);
		echo "successful";
	} else {
		/**************
		* Unsuccessful
		***************/	
		echo oci_error($stid);				
	}		
	
	oci_free_statement($stid);
	ocilogoff($dbh);
	
?>