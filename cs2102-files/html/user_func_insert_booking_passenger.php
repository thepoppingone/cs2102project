<?php

if(!empty($_POST)){

	//status variables
	
	$bookingPassengerDone = false;
	$passengerDone = false;
	$updateSeatsDone = false;

	$title = $_POST['title'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$passportNo = $_POST['passportNo'];
	$email = $_POST['email'];
	$index = (int) $_POST['index'];
	$limit = (int) $_POST['limit'];

	$price = $_POST['price'];

	$bookingId = (int) $_POST['bookingId'];
	
	$flightNo = $_POST['flightNo'];
	$departure_date = $_POST['departure_date'];
	$departure_time24 = $departure_date;

	date_default_timezone_set('Asia/Singapore'); 
	
	$departure_time12 = date("d/m/y h:i A", strtotime($departure_time24));
	//$departure_time_final =  substr_replace($departure_time12, ':00.000000000 ', -3).substr($departure_time12, -2);
	// NEEDS TO CONVERT BACK TO EXACTLY THE FORMAT THE SQL WANTS FOR INSERTION

	//departure_time12 = substr_replace($departure_date, '', -10).substr($departure_date, -3) ; // format: yyyy-mm-dd
	//$departure_time24 = date("d/M/y H:i",strtotime($departure_time12));
	//TRIED ALMOST A 100 TIMES DEBUGGING TO REALIZE THE ORIGINAL STRING WORKS

	/************************************
	UPDATE FLIGHT SCHEDULE CAPACITY 
	************************************/
	
	//echo '</br>'.$departure_time12;

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
		$sql = "INSERT INTO passenger VALUES(:passportNo, :title, :firstName, :lastName)";
		
		$stid = oci_parse($dbh, $sql);
		oci_bind_by_name($stid, ':passportNo', $passportNo);
		oci_bind_by_name($stid, ':title', $title);
		oci_bind_by_name($stid, ':firstName', $firstName);
		oci_bind_by_name($stid, ':lastName', $lastName);
		
		$result = oci_execute($stid);
		if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
		} else {
			//echo "inserted into passenger table";
			$passengerDone = true;
		}
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
		echo "booking id: ".$bookingId;
	} else {
		//echo "<br/>inserted into booking_passenger table";
	}

	if(($index+1) == $limit)
	{
		echo "<br/>";
		echo "<strong> Your booking ID is: ".$bookingId."</strong><br/> ";
		echo "<strong> Your booking is made under the email: ".$email."</strong><br/> ";
		echo "Payment of $".$price." made. <br/>";
		echo "Booking is successful!<br/>";
		echo "You can retrieve your booking with your email address and booking ID.<br/>";
		echo "<strong>Please save the above details! (in bold)</strong><br/>";
	}


	oci_commit($dbh);
	oci_free_statement($stid);
	oci_close($dbh);


}


?>