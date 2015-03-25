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
	$departure_time24 = $departure_date;

	date_default_timezone_set('Asia/Singapore'); 
	
	$departure_time12 = date("d/M/y h:i A", strtotime($departure_time24));
	$departure_time_final =  substr_replace($departure_time12, ':00.000000000 ', -3).substr($departure_time12, -2);
	// NEEDS TO CONVERT BACK TO EXACTLY THE FORMAT THE SQL WANTS FOR INSERTION

	//$departure_time12 = substr_replace($departure_date, '', -10).substr($departure_date, -3) ; // format: yyyy-mm-dd
	//	$departure_time24 = date("d/M/y H:i",strtotime($departure_time12));
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
	$sql = "INSERT INTO booking VALUES(:id, :booker, :contact, :email, :flightNo, :departure_time )";

	$stid = oci_parse($dbh, $sql);
	oci_bind_by_name($stid, ':id', $bookingId);
	oci_bind_by_name($stid, ':booker', $booker);
	oci_bind_by_name($stid, ':contact', $contact);
	oci_bind_by_name($stid, ':email', $email);
	oci_bind_by_name($stid, ':flightNo', $flightNo);
	oci_bind_by_name($stid, ':departure_time', $departure_time_final);

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

	/************************************
	UPDATE FLIGHT SCHEDULE CAPACITY 
	************************************/

	$sql = "SELECT NUM_OF_SEATS_AVAIL FROM schedule s WHERE s.flight_number = '".$flightNo."' AND s.depart_time = '".$departure_time_final."'";
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);
	if(!$result) { //checks for any sql error
		$error_message = oci_error($stid);
		echo $error_message;

	} else {
			//no error, look for seats left
		if($row = oci_fetch_array($stid)) {
			$seatsLeft = (int)$row[0];
			echo "<br/>number of seats before inserting: ".$seatsLeft."<br/>";
			// do seats left validation on search results
			$updatedSeats = ($seatsLeft-1);
			$sql = "UPDATE schedule SET NUM_OF_SEATS_AVAIL = :updatedSeats WHERE flight_number = :flight_number AND depart_time = :departure_time";
			
			$stid = oci_parse($dbh, $sql);
			oci_bind_by_name($stid, ':updatedSeats', $updatedSeats);
			oci_bind_by_name($stid, ':flight_number', $flightNo);
			oci_bind_by_name($stid, ':departure_time', $departure_time_final);
			
			$result = oci_execute($stid);
			//echo oci_num_rows($stid) . " rows updated";
			echo "number of seats now updated. ".($updatedSeats);

			echo "<br/><button id='returnHome' class='btn btn-primary'>Return to Home</button>";
				}
			}
		
	oci_free_statement($stid);


}


?>