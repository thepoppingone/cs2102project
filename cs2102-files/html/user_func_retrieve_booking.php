 <?php
 
	$id = $_POST['id'];
	$c_email = $_POST['c_email'];

	require("config.php");
	
	$sql = "SELECT * FROM booking b WHERE b.ID = '".$id."' AND b.C_EMAIL = '".$c_email."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT); 

	if ($row = oci_fetch_array($stid)) {
		echo "retrieved";	
	} else {
		echo "error";
	}

	// to free up the resources
	oci_free_statement($stid);
?>