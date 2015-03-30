<?php 


	/***************************************************************
	* admin_func_search_flight.php 
	* function : to search through the flights in the database
	* results  : search results
	* echo back rows of data or error messages
	****************************************************************/
	
	$sql = "SELECT * FROM flight f";
	$attributes = array("f.F_NUMBER", "f.ORIGIN", "f.DESTINATION"); // seat_capacity gets separated handling
	$values = array($_POST['f_number'], $_POST['origin'], $_POST['destination']); //, $_POST['seat_min'], $_POST['seat_max'])
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
			
	// add sql code for checking seat capacity 
	if(!empty($_POST['seat_min'])) {
		if($firstTime) {
			$sql = $sql." WHERE "; 
			$firstTime = false;
		} else {
			$sql = $sql." AND ";
		}
		$sql = $sql."SEAT_CAPACITY >= ".$_POST['seat_min'];
	}
	if(!empty($_POST['seat_max'])) {
		if($firstTime) {
			$sql = $sql." WHERE "; 
			$firstTime = false;
		} else {
			$sql = $sql." AND ";
		} 
		$sql = $sql."SEAT_CAPACITY <= ".$_POST['seat_max'];
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
            $output = $output."<td>".$row['F_NUMBER']."</td><td>".$row['ORIGIN']."</td><td>".$row['DESTINATION']."</td><td>".$row['SEAT_CAPACITY']."</td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['F_NUMBER']."\" onclick = \"return forwardToFlightEditDetails('".$row['F_NUMBER']."')\"></span></td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteFlight('".$index."','".$row['F_NUMBER']."')\"></span></td></tr>";
			$index++;
		}
		echo $output;
	}
	
	oci_free_statement($stid);
	ocilogoff($dbh);	
?>