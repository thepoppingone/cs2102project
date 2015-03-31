<?php 
	// this file is specific for getting edit/delete options
	
	$edit =  $_POST['edit'];

	require("config.php");
	$sql = "SELECT s.*, TO_CHAR(s.DEPART_TIME, 'DD MON YYYY HH24:MI') AS DEPART_TIME_DISPLAY, TO_CHAR(s.ARRIVAL_TIME, 'DD MON YYYY HH24:MI') AS ARRIVAL_TIME_DISPLAY FROM schedule s";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	
	$output = "";
	$index = 0;
	if(empty($edit)) {
		while($row = oci_fetch_array($stid)) {
			// create a row with flight number, departure time, arrival time, seats availability, price, delete icon which calls a handleDeleteSchedule(id, flight_number, depart_time)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['FLIGHT_NUMBER']."</td>
			<td>".$row['DEPART_TIME_DISPLAY']."</td>
			<td>".$row['ARRIVAL_TIME_DISPLAY']."</td>
			<td>".$row['NUM_OF_SEATS_AVAIL']."</td>
			<td>".$row['PRICE']."</td>
			<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteSchedule('".$index."','".$row['FLIGHT_NUMBER']."','".$row['DEPART_TIME']."')\"></span></td></tr>";
			$index++;
		}			
		
	} else {
		while($row = oci_fetch_array($stid)) {
			// create a row with flight number, departure time, arrival time, seats availability, price, pencil icon which calls a forwardToReservationEditDetails(flight_number, depart_time)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['FLIGHT_NUMBER']."</td>
			<td>".$row['DEPART_TIME_DISPLAY']."</td>
			<td>".$row['ARRIVAL_TIME_DISPLAY']."</td>
			<td>".$row['NUM_OF_SEATS_AVAIL']."</td>
			<td>".$row['PRICE']."</td>
			<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['FLIGHT_NUMBER']."\" onclick = \"return forwardToScheduleEditDetails('".$row['FLIGHT_NUMBER']."','".$row['DEPART_TIME']."')\"></span></td></tr>";
			$index++;
		}	
	}
		
	echo $output;
?>