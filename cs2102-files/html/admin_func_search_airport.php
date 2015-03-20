<?php 

	$sql = "SELECT * FROM airport a";
	$attributes = array("name", "location", "designator");
	$values = array($_POST['name'], $_POST['location'], $_POST['designator']);
	$firstTime = true;
	for ($x = 0; $x < count($attributes); $x++) {
		if(!empty($values[$x])) {
			if($firstTime) {
				$sql = $sql." WHERE "; 
				$firstTime = false;
			} else {
				$sql = $sql." AND ";
			}
			$sql = $sql."a.".$attributes[$x]." LIKE '%".$values[$x]."%'";
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
            $output = $output."<td>".$row['NAME']."</td><td>".$row['LOCATION']."</td><td>".$row['DESIGNATOR']."</td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['DESIGNATOR']."\" onclick = \"return forwardToAirportEditDetails('".$row['DESIGNATOR']."')\"></span></td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteAirport('".$index."','".$row['DESIGNATOR']."')\"></span></td></tr>";
			$index++;
		}
		echo $output;
	}
	oci_free_statement($stid);
?>