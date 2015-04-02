 <?php 
	
	/**************************************************************************************************************
	* admin_func_add_booking.php 
	* function1 : to add a booking for an existing schedule and also add passengers
	* results   : deduct number of passengers from schedule NUM_OF_SEATS_AVAIL
	*			  add new booking record into database
	*			  adds a new passenger record into the database. if passenger exists, the record is updated.
	*			  adds new record for booking_passenger for every passenger
	* 			  echo "successful" implies the expected results are satisfy
	* 			  else an error message is echoed.
	**************************************************************************************************************/
	
	/******************
	* Required Inputs
	*******************/
	$p_email = $_POST['contactEmail'];
	$p_name = $_POST['contactName'];
	$p_number = $_POST['contactNumber'];
	$flight_number = $_POST['flight_number'];
	$depart_time = $_POST['depart_date'];
	$passenger_num = $_POST['numOfPassenger'];

	require("config.php");	
	/*******************
	* Start of updating
	********************/	
	
	// book the seats first by updating the schedule 
	$sql = "UPDATE schedule s SET s.NUM_OF_SEATS_AVAIL = s.NUM_OF_SEATS_AVAIL - :seat_num WHERE s.NUM_OF_SEATS_AVAIL >= :seat_num ".
			"AND s.DEPART_TIME = :depart_time ".
			"AND s.FLIGHT_NUMBER = :flight_number";
	$stid = oci_parse($dbh, $sql);
	oci_bind_by_name($stid, ':seat_num', $passenger_num);
	oci_bind_by_name($stid, ':depart_time', $depart_time);
	oci_bind_by_name($stid, ':flight_number', $flight_number);
	$result = oci_execute($stid, OCI_DEFAULT);			

	if($result) {
		// only one schedule should be updated
		if(oci_num_rows($stid) == 1) {
			
			// 1. calculate the booking id 
			//Set default booking id as one, if no entry found then assign it to the new booking
			$bookingId = 1;
			
			$sql = "SELECT MAX(*) FROM booking";
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid, OCI_DEFAULT);
			
			if($row = oci_fetch_array($stid)) {
				$bookingId += $row[0];
			}			
			
			// 2. insert the booking
			$sql = "INSERT INTO booking VALUES(:bookingId, :p_name, :p_number, :p_email, :flight_number, :depart_time )";
			$stid = oci_parse($dbh, $sql);
			oci_bind_by_name($stid, ':bookingId', $bookingId);
			oci_bind_by_name($stid, ':p_name', $p_name);
			oci_bind_by_name($stid, ':p_number', $p_number);
			oci_bind_by_name($stid, ':p_email', $p_email);
			oci_bind_by_name($stid, ':flight_number', $flight_number);
			oci_bind_by_name($stid, ':depart_time', $depart_time);
			oci_execute($stid, OCI_DEFAULT);
			
			// insert/update all passenger
			for($p = 1; $p <= $passenger_num; $p++) {
				$passport = $_POST['passport'.$p];
				$title = $_POST['title'.$p];
				$firstName = $_POST['first'.$p];
				$lastName = $_POST['last'.$p];
				
				// insert/update passenger
				$sql = "SELECT * FROM passenger p WHERE p.PASSPORT_NUMBER = '".$passport."'";
				$stid = oci_parse($dbh, $sql);
				oci_execute($stid, OCI_DEFAULT);	
				
				if($row = oci_fetch_array($stid)) {
					// passenger exists, do a update
					$sql = "UPDATE passenger p SET p.TITLE = '".$title."', p.FIRST_NAME = '".$firstName."', p.LAST_NAME = '".$lastName."' WHERE p.PASSPORT_NUMBER = '".$passport."'";
					$stid = oci_parse($dbh, $sql);
					oci_execute($stid, OCI_DEFAULT);	
				} else {
					// insert into the table 
					$sql = "INSERT INTO passenger VALUES(:passport, :title, :first_name, :last_name)";
					$stid = oci_parse($dbh, $sql);
					oci_bind_by_name($stid, ':passport', $passport);
					oci_bind_by_name($stid, ':title', $title);
					oci_bind_by_name($stid, ':first_name', $firstName);
					oci_bind_by_name($stid, ':last_name', $lastName);
					oci_execute($stid, OCI_DEFAULT);	
				}	
				
				// insert into booking_passenger
				$sql = "INSERT INTO booking_passenger VALUES(:id, :passport)";
				$stid = oci_parse($dbh, $sql);
				oci_bind_by_name($stid, ':id', $bookingId);
				oci_bind_by_name($stid, ':passport', $passport);
				oci_execute($stid, OCI_DEFAULT);			
			}
			
			/************
			* Successful
			*************/
			oci_commit($dbh);
			echo "successful ".$bookingId;
		}
	} else {
		/**************
		* Unsuccessful
		***************/	
		echo oci_error($stid);
	}

	oci_free_statement($stid);
	ocilogoff($dbh);
?>