<?php

if(!empty($_POST)){

	$email = $_POST['email'];
	$contact =(int)	 $_POST['contact'];
	$booker = $_POST['booker'];
	$price = $_POST['price'];
	$passenger_num = (int)$_POST['passenger_num'];

	$flightNo = $_POST['flightNo'];
	$departure_date = $_POST['departure_date'];
	$departure_time24 = $departure_date;

	require("config.php");

	$sql = "UPDATE schedule s SET s.NUM_OF_SEATS_AVAIL = s.NUM_OF_SEATS_AVAIL -:seat_num WHERE s.NUM_OF_SEATS_AVAIL >= :seat_num ".
	"AND s.DEPART_TIME = :depart_time ".
	"AND s.FLIGHT_NUMBER = :flight_number";
	$stid = oci_parse($dbh, $sql);
	oci_bind_by_name($stid, ':seat_num', $passenger_num);
	oci_bind_by_name($stid, ':depart_time', $departure_date);
	oci_bind_by_name($stid, ':flight_number', $flightNo);
	$result = oci_execute($stid, OCI_DEFAULT);	

	if($result) {
	//Set default booking id as one, if no entry found then assign it to the new booking
	$bookingId = 1;
	oci_commit($dbh);

	$sql = "SELECT MAX(ID) FROM booking";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	while($row = oci_fetch_array($stid)) {
		echo $bookingId += $row[0];
	}


	$sql = "INSERT INTO booking VALUES(:id, :booker, :contact, :email, :flightNo, TO_TIMESTAMP(:departure_time,'DD/MM/YYYY HH24:MI:SS') )";

	$stid = oci_parse($dbh, $sql);
	oci_bind_by_name($stid, ':id', $bookingId);
	oci_bind_by_name($stid, ':booker', $booker);
	oci_bind_by_name($stid, ':contact', $contact);
	oci_bind_by_name($stid, ':email', $email);
	oci_bind_by_name($stid, ':flightNo', $flightNo);
	oci_bind_by_name($stid, ':departure_time', $departure_time24);

	$result = oci_execute($stid);

	if(!$result) {
		$error_message = oci_error($stid);
		echo $error_message;
	} else {
		//echo "<br/>inserted into booking table";
		$bookingDone = true;
		oci_commit($dbh);
	}

}

	oci_commit($dbh);
	oci_free_statement($stid);
	oci_close($dbh);


}


?>