<?php 

	$sql = "SELECT * FROM admin a";
	$attributes = array("email", "name", "password");
	$values = array($_POST['email'], $_POST['name'], $_POST['pwd']);
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
		while($row = oci_fetch_array($stid)) {
			$output = $output." <tr><td><input type=\"checkbox\" value=\"".$row['EMAIL']."\" class = \"checked-administrator\" id = \"".$row['EMAIL']."\"></td><td>".$row['NAME']."</td><td>".$row['EMAIL']."</td></tr>";
		}
		echo $output;
	}
	oci_free_statement($stid);
?>