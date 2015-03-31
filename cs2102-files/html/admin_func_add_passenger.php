 <?php 
	
	/**************************************************************************************************************
	* admin_func_add_passenger.php 
	* function1 : to add a passenger for an existing booking ($_POST['check'] is empty)
	* results   : adds a new passenger record into the database. if passenger exists, the record is updated.
	*			  adds new record for booking_passenger
	*             deduct 1 from schedule NUM_OF_SEATS_AVAIL
	* 			  echo "successful" implies the expected results are satisfy
	* 			  else an error message is echoed.
	* function1 : to check the passenger details ($_POST['check'] is not empty)
	* results   : echo "new_passenger" if passenger does not exists
	*			  echo "passenger_exists" if passenger has other bookings
	*             echo "passenger_booking_exists" if passenger exists for this booking
	**************************************************************************************************************/
	
	/******************
	* Required Inputs
	*******************/
	$title = $_POST['title'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$passport = $_POST['passport'];
	$id = $_POST['id'];
	$check = $_POST['check'];
	

	require("config.php");	
	/*******************
	* Start of updating
	********************/	
	
	
	
	if(empty($check)) {	
		
		// update the schedule 
		$sql = "UPDATE schedule s SET s.NUM_OF_SEATS_AVAIL = s.NUM_OF_SEATS_AVAIL - 1 WHERE s.NUM_OF_SEATS_AVAIL > 0 ".
				"AND s.DEPART_TIME = (SELECT b.DEPART_TIME FROM booking b WHERE b.ID = '".$id."') ".
				"AND s.FLIGHT_NUMBER = (SELECT b.FLIGHT_NUMBER FROM booking b WHERE b.ID = '".$id."')";
				
		$stid = oci_parse($dbh, $sql);
		$result = oci_execute($stid, OCI_DEFAULT);			
		
		if($result) {
		
			// only one schedule should be updated
			if(oci_num_rows($stid) == 1) {
				// proceed to insert into booking_passenger & passenger
				
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
				oci_bind_by_name($stid, ':id', $id);
				oci_bind_by_name($stid, ':passport', $passport);
				oci_execute($stid, OCI_DEFAULT);	
				
				/************
				* Successful
				*************/
				oci_commit($dbh);
				echo "successful";
				
			} else {
				/**************
				* Unsuccessful
				***************/			
				echo "Error in booking a place on the flight for the passenger<br/>";
			}
			
		} else {
			/**************
			* Unsuccessful
			***************/	
			echo oci_error($stid);
		}
		
	} else {
		// check if passenger exists
		$sql = "SELECT * FROM passenger p WHERE p.PASSPORT_NUMBER = '".$passport."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);

		if($row = oci_fetch_array($stid)) {
			// check if the passenger is already registered under this booking
			$sql = "SELECT * FROM booking_passenger bp WHERE bp.PASSENGER = '".$passport."' AND bp.BOOKING_ID = '".$id."'";
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid, OCI_DEFAULT);
			
			if($row = oci_fetch_array($stid)) {
				echo "passenger_booking_exists"; // passenger is already registered under this booking
			} else {
				echo "passenger_exists"; // passenger exists in records (have other bookings)
			}
		} else {
			echo "new_passenger";
		}	
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
?>