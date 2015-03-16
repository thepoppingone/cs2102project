<?php 
	$emails = $_POST['email'];
	if(empty($emails)) {
		require("config.php");
		$sql = "SELECT a.name, a.email FROM admin a";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		$output = "";
		while($row = oci_fetch_array($stid)) {
			$output = $output." <tr><td><input type=\"checkbox\" value=\"".$row['EMAIL']."\" class = \"checked-administrator\" id = \"".$row['EMAIL']."\"></td><td>".$row['NAME']."</td><td>".$row['EMAIL']."</td></tr>";
		}
		echo $output;
	} else {
	
		$email_tokens = explode(" ", $emails);
		$message = "";
		$successList = "";
		
		require("config.php");
		for($x = 0; $x < count($email_tokens)-1; $x++) {
			$email = $email_tokens[$x];
			
			$sql = "DELETE FROM admin a WHERE a.email = '".$email."'";
			$stid = oci_parse($dbh, $sql);
			oci_execute($stid, OCI_DEFAULT);
				
			$result = oci_execute($stid);
			if(!$result) {
				$message = $message."Error in deleting ".$email."<br/>".oci_error($stid)."<br/>";
			} else {
				$successList = $successList.$email." ";
			}			
			oci_free_statement($stid);
		}
		if(empty($message)) {
			$message = "successful";
		}
		
		echo $message;
		echo " ".$successList;
		$emails = "";
	}
?>