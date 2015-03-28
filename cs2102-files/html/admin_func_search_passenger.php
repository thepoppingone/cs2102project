<?php 

	/***************************************************************
	* admin_func_search_passenger.php 
	* function : to search through the passengers in the database
	* results  : search results
	* echo back rows of data or error messages
	****************************************************************/

	$sql = "SELECT * FROM passenger p";
	$attributes = array("title", "first_name", "last_name", "passport_number");
	$values = array($_POST['title'], $_POST['first_name'], $_POST['last_name'], $_POST['passport_number']);
	$firstTime = true;
	for ($x = 0; $x < count($attributes); $x++) {
		if(!empty($values[$x])) {
			if($firstTime) {
				$sql = $sql." WHERE "; 
				$firstTime = false;
			} else {
				$sql = $sql." AND ";
			}
			$sql = $sql."p.".$attributes[$x]." LIKE '%".$values[$x]."%'";
		}
	}
	
	require("config.php");
	$stid = oci_parse($dbh, $sql);
	$result = oci_execute($stid, OCI_DEFAULT);
	if(!$result) {
			$error_message = oci_error($stid);
			echo $error_message;
	} else {
		$index = 0;
		while($row = oci_fetch_array($stid)) {
			$output = $output." <tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">";
			$output = $output."<td>".$row['TITLE']."</td>";
			$output = $output."<td>".$row['FIRST_NAME']."</td>";
			$output = $output."<td>".$row['LAST_NAME']."</td>";
			$output = $output."<td>".$row['PASSPORT_NUMBER']."</td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['PASSPORT_NUMBER']."\" onclick = \"return forwardToPassengerEditDetails('".$row['PASSPORT_NUMBER']."')\"></span></td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeletePassenger('".$index."','".$row['PASSPORT_NUMBER']."')\"></span></td></tr>";
			$index++;
		}
		echo $output;
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
?>