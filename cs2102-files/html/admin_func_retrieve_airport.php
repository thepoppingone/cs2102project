<?php 
	// this file is specific for getting edit/delete options
	
	$edit =  $_POST['edit'];

	require("config.php");
	$sql = "SELECT a.name, a.location, a.designator FROM airport a";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$output = "";
	$index = 0;
	if(empty($edit)) {
		while($row = oci_fetch_array($stid)) {
			// create a row with name, location, designator, delete icon which calls a handleDeleteAirport(rowId, designator)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['NAME']."</td>
			<td>".$row['LOCATION']."</td>
			<td>".$row['DESIGNATOR']."</td>
			<td><span class=\"glyphicon glyphicon-remove \" value=\"".$row['DESIGNATOR']."\" onclick = \"return handleDeleteAdmin('".$index."','".$row['DESIGNATOR']."')\"></span></td>
			</tr>";
			$index++;			
		}
	} else {
		while($row = oci_fetch_array($stid)) {
			// create a row with name, location, designator, pencil icon which calls a forwardToAirportEditDetails(designator)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
			<td>".$row['NAME']."</td>
			<td>".$row['LOCATION']."</td>
			<td>".$row['DESIGNATOR']."</td>
			<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['DESIGNATOR']."\" onclick = \"return forwardToAirportEditDetails('".$row['DESIGNATOR']."')\"></span></td>
			</tr>";
			$index++;
		}	
	}
		
	echo $output;
?>