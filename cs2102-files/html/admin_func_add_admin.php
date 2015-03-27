<?php 

	/******************************************************************************************************
	* admin_func_add_admin.php 
	* function : to add an administrator
	* results  : adds a non-existing new administrator record into the database. 
	* echo "inserted" implies the expected results are satisfy
	* echo "admin_exists" implies an existing record
	* else an error message is echoed.
	******************************************************************************************************/
	
	
	/******************
	* Required Inputs
	*******************/
	$email = $_POST['email'];
	$name = $_POST['name'];
	$password = $_POST['pwd'];
	
	
	require("config.php");
	/*******************
	* Start of inserting
	********************/		
	
	$sql = "SELECT * FROM admin a WHERE a.EMAIL = '".$email."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	if($row = oci_fetch_array($stid)) {
	
		/***************
		* Record Exists
		****************/	
		echo "admin_exists";
		
	} else {
	
		// insert the record in
		$sql = "INSERT INTO admin VALUES(:name, :email, :password)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':name', $name);
		oci_bind_by_name($stid, ':email', $email);
		oci_bind_by_name($stid, ':password', $password);
		$result = oci_execute($stid, OCI_DEFAULT);
		
		if($result) {
		
			/************
			* Successful
			*************/
			oci_commit($dbh);
			echo "inserted";
			
		} else {

			/**************
			* Unsuccessful
			***************/	
			$error_message = oci_error($stid);
			echo $error_message;
		}
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
?>