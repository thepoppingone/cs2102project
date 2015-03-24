<?php

if(!empty($_POST)){

	$title = $_POST['title'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$dob = $_POST['dob'];
	$passportNo = $_POST['passportNo'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$booker = $_POST['booker'];
	$type = 'adult';
	
	$flightNo = $_POST['flightNo'];
	$departure_date= $_POST['departure_date'];

	date_default_timezone_set('Asia/Singapore'); 
	
	$departure_date = date("Y-m-d", strtotime ($_GET['departure_date'])); // format: yyyy-mm-dd
	$today_date = date('Y-m-d');
	
	require("config.php");

	$sql = "SELECT * FROM passenger p WHERE p.passport_number = '".$passportNo."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "passenger exists";
	} else {
		// insert the record in
		$sql = "INSERT INTO passenger VALUES(:passportNo, :type, :title, :firstName, :lastName)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':passportNo', $passportNo);
		oci_bind_by_name($stid, ':type', $type);
		oci_bind_by_name($stid, ':title', $title);
		oci_bind_by_name($stid, ':firstName', $firstName);
		oci_bind_by_name($stid, ':lastName', $lastName);
		
		$result = oci_execute($stid);
		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "inserted";
		}
	}
	oci_free_statement($stid);

	}
	

?>