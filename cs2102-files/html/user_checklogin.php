<?php
	
if(!empty($_POST)){

	require("config.php");
	
	// check login credentials for admin
	$email = $_POST['email'];
	$pwd = $_POST['password'];
	
	// carry out sql command
	$sql = "SELECT * FROM admin a WHERE a.email = '".$email."' AND a.password = '".$pwd."'";

	$stid = oci_parse($dbh, $sql);

	// without OCI_DEFAULT any changes to the database will be instantly viewable by all other connecgtions
	oci_execute($stid, OCI_DEFAULT); 

	if ($row = oci_fetch_array($stid)) 
	{
		header("location:admin_panel.html");
		
	} else {
		header("location:user_login.php");
	}

	// to free up the resources
	oci_free_statement($stid);
}
?>