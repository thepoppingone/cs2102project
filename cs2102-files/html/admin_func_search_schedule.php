<?php 

	/***************************************************************
	* admin_func_search_schedule.php 
	* function : to search through the schedules in the database
	* results  : search results
	* echo back rows of data or error messages
	****************************************************************/
	
	$sql = "SELECT s.*, f.*, TO_CHAR(s.DEPART_TIME, 'DD MON YYYY HH24:MI') AS DEPART_TIME_DISPLAY, TO_CHAR(s.ARRIVAL_TIME, 'DD MON YYYY HH24:MI') AS ARRIVAL_TIME_DISPLAY  FROM schedule s, flight f WHERE s.FLIGHT_NUMBER = f.F_NUMBER";
	$attributes = array("s.FLIGHT_NUMBER", "f.ORIGIN", "f.DESTINATION");
	// f.num_of_seats_available, f.arrival_time, f.depart_time, f.price gets separated handling
	$values = array($_POST['f_number'], $_POST['origin'], $_POST['destination']); 
	//$_POST['depart_time_min'], $_POST['depart_time_max'], $_POST['arrival_time_min'], $_POST['arrival_time_max'], $_POST['seat_min'], $_POST['seat_max'], $_POST['price_min'], $_POST['price_max'], 

	for ($x = 0; $x < count($attributes); $x++) {
		if(!empty($values[$x])) {
			$sql = $sql." AND ".$attributes[$x]." LIKE '%".$values[$x]."%'";
		}
	}
	
	// add sql code for checking depart_time
	if(!empty($_POST['depart_time_min'])) {
		$sql = $sql." AND s.DEPART_TIME >= TO_TIMESTAMP('".$_POST['depart_time_min']."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	}
	if(!empty($_POST['depart_time_max'])) {
		$sql = $sql." AND s.DEPART_TIME <= TO_TIMESTAMP('".$_POST['depart_time_max']."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	}	
	
	// add sql code for checking arrival_time
	if(!empty($_POST['arrival_time_min'])) {
		$sql = $sql." AND s.ARRIVAL_TIME >= TO_TIMESTAMP('".$_POST['arrival_time_min']."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	}
	if(!empty($_POST['arrival_time_max'])) {
		$sql = $sql." AND s.ARRIVAL_TIME <= TO_TIMESTAMP('".$_POST['arrival_time_max']."', 'YYYY-MM-DD\"T\"HH24:MI:SS')";
	}		
	
	// add sql code for checking price
	if(!empty($_POST['price_min'])) {
		$sql = $sql." AND s.PRICE >= ".$_POST['price_min'];
	}
	if(!empty($_POST['price_max'])) {
		$sql = $sql." AND s.PRICE <= ".$_POST['price_max'];
	}
	
	// add sql code for checking seat capacity 
	if(!empty($_POST['seat_min'])) {
		$sql = $sql." AND s.NUM_OF_SEATS_AVAIL >= ".$_POST['seat_min'];
	}
	if(!empty($_POST['seat_max'])) {
		$sql = $sql." AND s.NUM_OF_SEATS_AVAIL <= ".$_POST['seat_max'];
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
            $output = $output."<td>".$row['F_NUMBER']."</td><td>".$row['ORIGIN']."</td><td>".$row['DESTINATION']."</td><td>".$row['DEPART_TIME_DISPLAY']."</td><td>".$row['ARRIVAL_TIME_DISPLAY']."</td><td>".$row['NUM_OF_SEATS_AVAIL']."</td><td>".$row['PRICE']."</td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-pencil \" value=\"".$row['F_NUMBER']."\" onclick = \"return forwardToScheduleEditDetails('".$row['F_NUMBER']."','".$row['DEPART_TIME']."')\"></span></td>";
            $output = $output."<td><span class=\"glyphicon glyphicon-remove \" onclick = \"return handleDeleteSchedule('".$index."','".$row['F_NUMBER']."','".$row['DEPART_TIME'].")\"></span></td></tr>";
			$index++;
		}
		echo $output;
	}
	oci_free_statement($stid);
?>