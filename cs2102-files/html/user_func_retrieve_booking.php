<?php 
	// this file is specific for getting edit/delete options
	
	$bookingID =  $_POST['bookingid'];

	require("config.php");
	$sql = "SELECT b.id, b.c_name, b.C_email, b.c_number FROM booking b where b.id = '".$bookingID"'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$output = "";
	$index = 0;

		if($row = oci_fetch_array($stid)) {
			// create a row with num, type, title, first_name, last_name, pencil icon which calls a handleEditPassenger(num)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['Booking_ID']."</td>
			<td>".$row['Contact_Person']."</td>
			<td>".$row['Contact_Email']."</td>
			<td>".$row['Contact_Number']."</td>
			<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['Booking_ID']."\" onclick = \"return forwardToBookingEditDetails()\"></span></td>
			</tr>";
			$index++;
		}	
	
	
	oci_free_statement($stid);
	ocilogoff($dbh);		
		
	echo $output;
?>