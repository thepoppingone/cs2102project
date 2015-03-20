<?php 

	$sql = "SELECT * FROM admin a";
	$attributes = array("email", "name", "password");
	$values = array($_POST['email'], $_POST['name'], $_POST['password']);
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
            $output = $output."<td>".$row['NAME']."</td><td>".$row['EMAIL']."</td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['EMAIL']."\" onclick = \"return forwardToAdminEditDetails('".$row['EMAIL']."')\"></span></td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteAdmin('".$index."','".$row['EMAIL']."')\"></span></td></tr>";
			$index++;
		}
		echo $output;
	}
	oci_free_statement($stid);
?>