<?php 

	/***************************************************************
	* admin_func_search_booking.php 
	* function : to search through the bookings in the database
	* results  : search results
	* echo back rows of data or error messages
	****************************************************************/

	$sql = "SELECT r.*, TO_CHAR(r.DEPART_TIME, 'DD MON YYYY HH24:MI') AS DEPART_TIME_DISPLAY FROM booking r";
	$attributes = array("r.id", "r.c_person", "r.c_number", "r.c_email", "r.flight_number"); // separate handling for depart_time
	$values = array($_POST['id'], $_POST['c_person'], $_POST['c_number'], $_POST['c_email'], $_POST['flight_number']); // depart_time_min, depart_time_max
	$firstTime = true;
	for ($x = 0; $x < count($attributes); $x++) {
		if(!empty($values[$x])) {
			if($firstTime) {
				$sql = $sql." WHERE "; 
				$firstTime = false;
			} else {
				$sql = $sql." AND ";
			}
			$sql = $sql.$attributes[$x]." LIKE '%".$values[$x]."%'";
		}
	}
	
	// add sql code for checking depart_time
	if(!empty($_POST['depart_time_min'])) {
		if($firstTime) {
			$sql = $sql." WHERE "; 
			$firstTime = false;
		} else {
			$sql = $sql." AND ";
		}
		$sql = $sql."depart_time >= TO_TIMESTAMP('".$_POST['depart_time_min']."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	}
	if(!empty($_POST['depart_time_max'])) {
		if($firstTime) {
			$sql = $sql." WHERE "; 
			$firstTime = false;
		} else {
			$sql = $sql." AND ";
		}
		$sql = $sql."depart_time <= TO_TIMESTAMP('".$_POST['depart_time_max']."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	}

	$sql = $sql." ORDER BY r.ID";
	require("config.php");
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);
	
	if($result) {
		$index = 0;
		while($row = oci_fetch_array($stid)) {
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">";
			$output = $output."<td>".$row['ID']."</td>";
			$output = $output."<td>".$row['C_PERSON']."</td>";
			$output = $output."<td>".$row['C_NUMBER']."</td>";
			$output = $output."<td>".$row['C_EMAIL']."</td>";
			$output = $output."<td>".$row['FLIGHT_NUMBER']."</td>";
			$output = $output."<td>".$row['DEPART_TIME_DISPLAY']."</td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['ID']."\" onclick = \"return forwardToBookingEditDetails('".$row['ID']."')\"></span></td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteBooking('".$index."','".$row['ID']."')\"></span></td></tr>";
			$index++;
		}
		echo $output;	

	} else {
		echo oci_error($stid);
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
?>