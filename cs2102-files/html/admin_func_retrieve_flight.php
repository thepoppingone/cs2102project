<?php 
	// this file is specific for getting edit/delete options
	
	$edit =  $_POST['edit'];

	require("config.php");
	$sql = "SELECT f.f_number, f.origin, f.destination, f.seat_capacity FROM flight f";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$output = "";
	$index = 0;
	if(empty($edit)) {
		while($row = oci_fetch_array($stid)) {
			// create a row with flight number, origin, destination, seat capacity, delete icon which calls a handleDeleteFlight(rowId, f_number)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['F_NUMBER']."</td>
			<td>".$row['ORIGIN']."</td>
			<td>".$row['DESTINATION']."</td>
			<td>".$row['SEAT_CAPACITY']."</td>
			<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteFlight('".$index."','".$row['F_NUMBER']."')\"></span></td></tr>";
			$index++;
		}
	} else {
		while($row = oci_fetch_array($stid)) {
			// create a row with flight number, origin, destination, seat capacity, pencil icon which calls a forwardToFlightEditDetails(f_number)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['F_NUMBER']."</td>
			<td>".$row['ORIGIN']."</td>
			<td>".$row['DESTINATION']."</td>
			<td>".$row['SEAT_CAPACITY']."</td>
			<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['F_NUMBER']."\" onclick = \"return forwardToFlightEditDetails('".$row['F_NUMBER']."')\"></span></td></tr>";
			$index++;
		}	
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);
	
	echo $output;
?>