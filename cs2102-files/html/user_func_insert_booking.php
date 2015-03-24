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
	$departure_date = $_POST['departure_date'];
	$departure_time = $departure_date;
	date_default_timezone_set('Asia/Singapore'); 
	
	//$departure_time12 = substr_replace($departure_date, '', -10).substr($departure_date, -3) ; // format: yyyy-mm-dd
	//$today_date = date('Y-m-d');
	//	$departure_time24 = date("d/m/Y H:i",strtotime($departure_time12));
	// TRIED ALMOST A 100 TIMES DEBUGGING TO REALIZE THE ORIGINAL STRING WORKS
	//echo '</br>'.$departure_time24;

	require("config.php");

	$sql = "SELECT * FROM passenger p WHERE p.passport_number = '".$passportNo."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	if($row = oci_fetch_array($stid)) {
		echo "passenger exists";
	} else {
		/****************************
		INSERT INTO PASSENGER TABLE
		****************************/
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
			echo "inserted into passenger table";
		}
	}

	//Set default booking id as one, if no entry found then assign it to the new booking
	$bookingId = 1;
	
	$sql = "SELECT COUNT(*) FROM booking";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	while($row = oci_fetch_array($stid)) {
		$bookingId+= $row[0];
	}

	/****************************
	INSERT INTO BOOKING TABLE
	****************************/
    $sql = "INSERT INTO booking VALUES(:id, :booker, :contact, :email, :flightNo, :departure_time)";
		
	$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':id', $bookingId);
		oci_bind_by_name($stid, ':booker', $booker);
		oci_bind_by_name($stid, ':contact', $contact);
		oci_bind_by_name($stid, ':email', $email);
		oci_bind_by_name($stid, ':flightNo', $flightNo);
		oci_bind_by_name($stid, ':departure_time', $departure_time); 

		$result = oci_execute($stid);

		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "<br/>inserted into booking table";
		}

	/************************************
	INSERT INTO BOOKING_PASSENGER TABLE
	************************************/

	$sql = "INSERT INTO booking_passenger VALUES(:id, :passportNo)";
		
	$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':id', $bookingId);
		oci_bind_by_name($stid, ':passportNo', $passportNo);

		$result = oci_execute($stid);

		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			echo "<br/>inserted into booking_passenger table";
		}

		// frees the statement here
	oci_free_statement($stid);


	}
	

?>