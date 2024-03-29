<?php 
	// this file is specific for getting edit/delete options
	
	$edit =  $_POST['edit'];

	require("config.php");
	$sql = "SELECT p.passport_number, p.title, p.first_name, p.last_name FROM passenger p";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$output = "";
	$index = 0;
	if(empty($edit)) {
		while($row = oci_fetch_array($stid)) {
			// create a row with name, location, designator delete icon which calls a handleDeletePassenger(rowId, num)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['PASSPORT_NUMBER']."</td>
			<td>".$row['TITLE']."</td>
			<td>".$row['FIRST_NAME']."</td>
			<td>".$row['LAST_NAME']."</td>
			<td><span class=\"glyphicon glyphicon-remove \" value=\"".$row['PASSPORT_NUMBER']."\" onclick = \"return handleDeletePassenger('".$index."','".$row['PASSPORT_NUMBER']."')\"></span></td>
			</tr>";
			$index++;			
		}
	} else {
		while($row = oci_fetch_array($stid)) {
			// create a row with num, type, title, first_name, last_name, pencil icon which calls a handleEditPassenger(num)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['PASSPORT_NUMBER']."</td>
			<td>".$row['TITLE']."</td>
			<td>".$row['FIRST_NAME']."</td>
			<td>".$row['LAST_NAME']."</td>
			<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['PASSPORT_NUMBER']."\" onclick = \"return forwardToPassengerEditDetails('".$row['PASSPORT_NUMBER']."')\"></span></td>
			</tr>";
			$index++;
		}	
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);		
		
	echo $output;
?>