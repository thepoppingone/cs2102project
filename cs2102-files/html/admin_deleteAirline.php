<?php 
	$designators = $_POST['designator'];
	if(empty($designators)) {
		require("config.php");
		$sql = "SELECT a.name, a.designator FROM airline a";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		$output = "";
		while($row = oci_fetch_array($stid)) {
			$output = $output." <tr><td><input type=\"checkbox\" value=\"".$row['DESIGNATOR']."\" class = \"checked-airline\" id = \"".$row['DESIGNATOR']."\"></td><td>".$row['NAME']."</td><td>".$row['DESIGNATOR']."</td></tr>";
		}
		echo $output;
	} else {
	
		$designator_tokens = explode(" ", $designators);
		$message = "";
		$successList = "";
		
		require("config.php");
		for($x = 0; $x < count($designator_tokens)-1; $x++) {
			$designator = $designator_tokens[$x];
			
			$sql = "DELETE FROM airline a WHERE a.designator = '".$designator."'";
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid, OCI_DEFAULT);
				
			$result = oci_execute($stid);
			if(!$result) {
				$message = $message."Error in deleting ".$designator."<br/>".oci_error($stid)."<br/>";
			} else {
				$successList = $successList.$designator." ";
			}			
			oci_free_statement($stid);
		}
		if(empty($message)) {
			$message = "successful";
		}
		
		echo $message;
		echo " ".$successList;
		$designators = "";
	}
?>