<?php

if(!empty($_GET)){

	// check login credentials for admin
	$origin = $_GET['origin'];
	$destination = $_GET['destination'];
	$numAdults = $_GET['numAdults'];
	$numChilds = $_GET['numChilds'];

	date_default_timezone_set('Asia/Singapore'); 
	
	$departure_date = date("Y-m-d", strtotime ($_GET['departure_date'])); // format: yyyy-mm-dd
	$today_date = date('Y-m-d');
	
	if($departure_date < $today_date) {
		echo "departure_date is no longer valid";
	} else {
	
		require("config.php");
		
		// carry out sql command
		$sql = "SELECT * FROM schedule s, flight f 
				WHERE s.depart_time >= TO_TIMESTAMP('".$departure_date."', 'YYYY-MM-DD')
				AND s.depart_time < TO_TIMESTAMP('".$departure_date."', 'YYYY-MM-DD')+1
				AND f.origin LIKE '%".$origin."%'
				AND f.destination LIKE '%".$destination."%' 
				AND f.f_number = s.flight_number";
			// plus one at the date will add a day to the date	

		$stid = oci_parse($dbh, $sql);

		// without OCI_DEFAULT any changes to the database will be instantly viewable by all other connecgtions
		oci_execute($stid, OCI_DEFAULT); 
		
		//counter for cheat if else outcome
		$i = 0;
		$index = 1;
		//FETCH AN ASSOICATIVE ARRAY FOR DATA EXTRACTION
		while ($row = oci_fetch_assoc($stid)) 
		{
			//NOTE THE ASSOCIATIVE ARRAY REACTS ONLY TO CAPITAL LETTERS
			// window.location is compliant to all browsers rather than using document
			echo "<tr>";
				echo "<td>".$index."</td>";
				echo "<td id='fNumBook".$index."'>".$row['FLIGHT_NUMBER']."</td>";
				echo "<td id='departTimeBook".$index."'>".$row['DEPART_TIME']."</td>";
				echo "<td>".$row['ARRIVAL_TIME']."</td>";
				echo "<td>$".$row['PRICE']."</td>";
				echo "<td>".$row['DURATION']."</td>";
				echo "<td><button id=\"button".$index."\" onclick=\"createButtonLink(".$index.")\" class='btn btn-primary'>Select</button></td>";
			echo "</tr>";

			$i++;
			$index++;

		}
	
		//no records found
		//used cheat method simple $i counter to keep check whether there are entries found or not
		if($i == 0)
		{
			echo "no_existing_flights";
			//when inserting code from php USE single quotes!
		//	echo "";
		}else //creates a session
		{
		session_set_cookie_params(3600,"/");
		session_start();
		$_SESSION['adult'] = $numAdults;
		$_SESSION['child'] = $numChilds;
		//$_SESSION['numOfRows'] = $i; //because ++ records the exact number of rows
		}


		}


		// to free up the resources
		oci_free_statement($stid);
	}
	

?>