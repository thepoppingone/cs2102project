<?php 
	// this file is specific for getting edit/delete options
	
	$edit =  $_POST['edit'];

	require("config.php");
	$sql = "SELECT a.name, a.email FROM admin a";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$output = "";
	$index = 0;
	if(empty($edit)) {
		while($row = oci_fetch_array($stid)) {
			// create a row with name, email, delete icon which calls a handleDeleteAdmin(rowId, email)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\"><td>".$row['NAME']."</td><td>".$row['EMAIL']."</td><td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteAdmin('".$index."','".$row['EMAIL']."')\"></span></td></tr>";
			$index++;
		}
	} else {
		while($row = oci_fetch_array($stid)) {
			// create a row with name, email, pencil icon which calls a handleEditAdmin(email)
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\"><td>".$row['NAME']."</td><td>".$row['EMAIL']."</td><td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['EMAIL']."\" onclick = \"return forwardToAdminEditDetails('".$row['EMAIL']."')\"></span></td></tr>";
			$index++;
		}	
	}
		
	echo $output;
?>