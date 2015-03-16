<?php 
	$aircraftIds = $_POST['aircraftId'];
	if(empty($aircraftIds)) {
		require("config.php");
		$sql = "SELECT p.aircraft_no, p.model, p.seat_capacity, p.designator FROM plane p";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		$output = "";
		while($row = oci_fetch_array($stid)) {
			$output = $output."<tr><td><input type=\"checkbox\" value=\"".$row['DESIGNATOR']."\" class = \"checked-aircraft\" id = \"".$row['DESIGNATOR']."\"></td>";
			$output = $output."<td>".$row['DESIGNATOR']."</td><td>".$row['AIRCRAFT_NO']."</td>";
			$output = $output."<td>".$row['MODEL']."</td><td>".$row['SEAT_CAPACITY']."</td></tr>";
		}
		echo $output;
	} else {
	
		$aircraftId_tokens = explode(" ", $aircraftIds);
		$message = "";
		$successList = "";
		
		require("config.php");
		for($x = 0; $x < count($aircraftId_tokens)-1; $x++) {
			$aircraftId = $aircraftId_tokens[$x];
			
			$sql = "DELETE FROM plane p WHERE p.aircraft_no = '".$aircraftId."'";
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid, OCI_DEFAULT);
				
			$result = oci_execute($stid);
			if(!$result) {
				$message = $message."Error in deleting ".$aircraftId."<br/>".oci_error($stid)."<br/>";
			} else {
				$successList = $successList.$aircraftId." ";
			}			
			oci_free_statement($stid);
		}
		if(empty($message)) {
			$message = "successful";
		}
		
		echo $message;
		echo " ".$successList;
		$aircraftIds = "";
	}
?>