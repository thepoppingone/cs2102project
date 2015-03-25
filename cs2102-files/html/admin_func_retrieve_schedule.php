<?php 
	// this file is specific for getting edit/delete options
	
	$edit =  $_POST['edit'];

	require("config.php");
	$sql = "SELECT s.flight_number, s.arrival_time, s.depart_time, s.num_of_seats_avail, s.price FROM schedule s";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$output = "";
	$index = 0;
	if(empty($edit)) {
		/*
		while($row = oci_fetch_array($stid)) {
			// create a row with reservation id, contact person, contact number, contact email, flight number, delete icon which calls a handleDeleteReservation(rowId, id)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['FLIGHT_NUMBER']."</td>
			<td>".$row['ARRIVAL_TIME']."</td>
			<td>".$row['DEPART_TIME']."</td>
			<td>".$row['NUM_OF_SEATS_AVAIL']."</td>
			<td>".$row['PRICE']."</td>
			<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteReservation('".$index."','".$row['ID']."')\"></span></td></tr>";
			$index++;
		}
		*/
	} else {
		while($row = oci_fetch_array($stid)) {
			// create a row with reservation id, contact person, contact number, contact email, flight number, pencil icon which calls a forwardToReservationEditDetails(id)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['FLIGHT_NUMBER']."</td>
			<td>".$row['ARRIVAL_TIME']."</td>
			<td>".$row['DEPART_TIME']."</td>
			<td>".$row['NUM_OF_SEATS_AVAIL']."</td>
			<td>".$row['PRICE']."</td>
			<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['FLIGHT_NUMBER']."\" onclick = \"return forwardToScheduleEditDetails('".$row['FLIGHT_NUMBER'].", ".$row['DEPART_TIME']."')\"></span></td></tr>";
			$index++;
		}	
	}
		
	echo $output;
?>