<?php 
	// this file is specific for getting edit/delete options
	
	$edit =  $_POST['edit'];

	require("config.php");
	$sql = "SELECT b.*, TO_CHAR(b.DEPART_TIME, 'DD MON YYYY HH24:MI') AS DEPART_TIME_DISPLAY FROM booking b ORDER BY b.ID";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$output = "";
	$index = 0;
	if(empty($edit)) {
		while($row = oci_fetch_array($stid)) {
			// create a row with reservation id, contact person, contact number, contact email, flight number, delete icon which calls a handleDeleteReservation(rowId, id)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['ID']."</td>
			<td>".$row['C_PERSON']."</td>
			<td>".$row['C_NUMBER']."</td>
			<td>".$row['C_EMAIL']."</td>
			<td>".$row['FLIGHT_NUMBER']."</td>
			<td>".$row['DEPART_TIME_DISPLAY']."</td>
			<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteBooking('".$index."','".$row['ID']."')\"></span></td></tr>";
			$index++;
		}
	} else {
		while($row = oci_fetch_array($stid)) {
			// create a row with reservation id, contact person, contact number, contact email, flight number, pencil icon which calls a forwardToReservationEditDetails(id)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['ID']."</td>
			<td>".$row['C_PERSON']."</td>
			<td>".$row['C_NUMBER']."</td>
			<td>".$row['C_EMAIL']."</td>
			<td>".$row['FLIGHT_NUMBER']."</td>
			<td>".$row['DEPART_TIME_DISPLAY']."</td>
			<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['EMAIL']."\" onclick = \"return forwardToBookingEditDetails('".$row['ID']."')\"></span></td></tr>";
			$index++;
		}	
	}
		
	echo $output;
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
?>