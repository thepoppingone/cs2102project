<?php
	session_start();
	if(empty($_SESSION['admin'])) {
		header("location: user_login.php");
	}

	// if there is no details posted, go back to the edit panel
	if(empty($_POST['selected'])) {
	 header("location: admin_panel_edit.php");
	} else {
	 
	 require("config.php");  
	 $sql = "";
	 if($_POST['selected'] == "administrator") {
	  $sql = "SELECT * FROM admin a WHERE a.email = '".$_POST['email']."'";
	 } else if ($_POST['selected'] == "airport") {
	  $sql = "SELECT * FROM airport a WHERE a.designator = '".$_POST['designator']."'";
	 } else if ($_POST['selected'] == "passenger") {
	  $sql = "SELECT * FROM passenger p WHERE p.passport_number = '".$_POST['num']."'";
	 } else if ($_POST['selected'] == "flight") {
	  $sql = "SELECT * FROM flight f WHERE f.f_number = '".$_POST['num']."'";
	 } else if ($_POST['selected'] == "schedule") {
	  $sql = "SELECT s.*, TO_CHAR(s.DEPART_TIME, 'YYYY-MM-DD\"T\"HH24:MI:SS') AS DEPART_TIME_DISPLAY, TO_CHAR(s.ARRIVAL_TIME, 'YYYY-MM-DD\"T\"HH24:MI:SS') AS ARRIVAL_TIME_DISPLAY FROM schedule s WHERE s.flight_number = '".$_POST['flight']."'AND s.depart_time = '".$_POST['departure']."'";
	 } else if ($_POST['selected'] == "booking"){
	  $sql = "SELECT b.*, TO_CHAR(b.DEPART_TIME, 'DD MON YYYY HH24:MI') AS DEPART_TIME_DISPLAY FROM booking b WHERE b.ID = '".$_POST['id']."'";
	 }
	 if(!empty($sql)) {
	  $stid = oci_parse($dbh, $sql);
	  oci_execute($stid, OCI_DEFAULT);
	  $row = oci_fetch_array($stid);
	 }
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Edit - Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="admin.css" rel="stylesheet">
	<script src="admin.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="admin_panel.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
              <li><a href="admin_panel_add.php"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
              <li><a href="admin_panel_delete.php"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
              <li class="active"><a href="admin_panel_edit.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
              <li><a href="admin_panel_search.php"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="admin_func_logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">		
	  
		<!-- div box for adminstrator -->
		<div id = "administrator" <?php if ($_POST['selected'] != "administrator") { echo 'class = "collapse" data-toggle = "false"';}?> > 
			<form id = "edit-admin-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "admin-name" type="text" class="form-control" placeholder="Name" required autofocus="" value = "<?php echo $row['NAME']; ?>">
					</div>
				</div>			
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-3" >Email Address</label>
					<div class="col-xs-9">		
						<input id = "admin-email" type="email" id="inputEmail" class="form-control" placeholder="Email address"  required autofocus="" name = "<?php echo $row['EMAIL']; ?>" value = "<?php echo $row['EMAIL']; ?> ">
						<p id = "adminEmailError" class = "collapse" class="text-danger" data-toggle="false">Oops! The owner of the email is already an administrator.</p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Password</label>
					<div class="col-xs-9">
						<input id = "admin-pwd" class="form-control" placeholder="Password"  required autofocus="" value = "<?php echo $row['PASSWORD']; ?>">
					</div>
				</div>
				<div class="form-group">
					<div id = "admin-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-primary" onclick = "return handleEditAdmin()">Edit Administrator</button>
					</div>
				</div>
			</form>
			<div id = "edit-admin-error-result" class = "collapse" data-toggle="false">
				<p id = "edit-admin-error-msg"></p>
			</div>
		</div>
		<!-- end for admin stuffs -->
		
		<!-- edit airport stuffs -->
		<!-- div box for airport -->
		<div id = "airport" <?php if ($_POST['selected'] != "airport") { echo 'class = "collapse" data-toggle = "false"';}?> >
			<form id = "edit-airport-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "airport-name" type="text" class="form-control" placeholder="Name" required autofocus="" value = "<?php echo $row['NAME']; ?>">
					</div>
				</div>			
				<div class="form-group">
					<label for="inputDesignator" class="control-label col-xs-3" >Designator</label>
					<div class="col-xs-9">		
						<input id = "airport-designator" type="designator" id="inputDesignator" class="form-control" placeholder="Designator"  required autofocus="" name = "<?php echo $row['DESIGNATOR']; ?>" value = "<?php echo $row['DESIGNATOR']; ?>">
						<p id = "airportDesignatorError" class = "collapse" class="text-danger" data-toggle="false">Oops! An airport with this designator already exists.</p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Location</label>
					<div class="col-xs-9">
						<input id = "airport-location" class="form-control" placeholder="Location"  required autofocus="" value = "<?php echo $row['LOCATION']; ?>">
					</div>
				</div>
				<div class="form-group">
					<div id = "airport-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-primary" onclick = "return handleEditAirport()">Edit Airport</button>
					</div>
				</div>
			</form>
			<div id = "edit-airport-error-result" class = "collapse" data-toggle="false">
				<p id = "edit-airport-error-msg"></p>
			</div>
		</div>
		<!-- end for airport stuffs -->	
		
		<!-- edit passenger into existing reservation -->
		<!-- div box for passenger -->
		<div id = "passenger" <?php if ($_POST['selected'] != "passenger") { echo 'class = "collapse" data-toggle = "false"';}?> >
			<form id = "edit-passenger-form" class="form-horizontal"> 			
				<div class="form-group">
					<label for="inputNum" class="control-label col-xs-3" >Passport Number</label>
					<div class="col-xs-9">		
						<input id = "passenger-num" type="text" id="inputNum" class="form-control" placeholder="Passport Number"  required autofocus="" name = "<?php echo $row['PASSPORT_NUMBER']; ?>" value = "<?php echo $row['PASSPORT_NUMBER']; ?>">
						<p id = "passengerNumError" class = "collapse" class="text-danger" data-toggle="false">Oops! A passenger with this passport number already exists.</p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Title</label>
					<div class="col-xs-9">
						<input id = "passenger-title" class="form-control" placeholder="Title"  required autofocus="" value = "<?php echo $row['TITLE']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">First Name</label>
					<div class="col-xs-9">
						<input id = "passenger-firstname" class="form-control" placeholder="First Name"  required autofocus="" value = "<?php echo $row['FIRST_NAME']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Last Name</label>
					<div class="col-xs-9">
						<input id = "passenger-lastname" class="form-control" placeholder="Last Name"  required autofocus="" value = "<?php echo $row['LAST_NAME']; ?>">
					</div>
				</div>
				<div class="form-group">
					<div id = "passenger-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-primary" onclick = "return handleEditPassenger()">Edit Passenger</button>
					</div>
				</div>
			</form>
			<div id = "edit-passenger-error-result" class = "collapse" data-toggle="false">
				<p id = "edit-passenger-error-msg"></p>
			</div>
		</div>
		<!-- end for passenger stuffs -->	
		
		<!-- edit flight stuffs -->
		<!-- div box for flight -->
		<div id = "flight" <?php if ($_POST['selected'] != "flight") { echo 'class = "collapse" data-toggle = "false"';}?> >
			<form id = "edit-flight-form" class="form-horizontal"> 			
				<div class="form-group">
					<label for="inputNum" class="control-label col-xs-3" >Flight Number</label>
					<div class="col-xs-9">		
						<input id = "flight-num" type="number" id="inputNum" class="form-control" placeholder="Flight Number"  required autofocus="" name = "<?php echo $row['F_NUMBER']; ?>" value = "<?php echo substr($row['F_NUMBER'],2); ?>">
						<p id = "flightNumError" class = "collapse" class="text-danger" data-toggle="false">Oops! A flight with this flight number already exists.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Origin</label>
					<div class="col-xs-9">  
					  <select  id="flight-origin" class = "form-control input-sm"  onchange = "validateFlightRoute()"> 
						<?php
							if ($_POST['selected'] == "flight") {
								require("config.php");
								$sql = "SELECT a.name, a.designator FROM airport a";
								$stid = oci_parse($dbh, $sql);
								oci_execute($stid, OCI_DEFAULT);
								while($row2 = oci_fetch_array($stid)){
									if($row2["DESIGNATOR"] == $row['ORIGIN']) {
										echo "<option selected = \"true\" value=\"".$row2["DESIGNATOR"]."\">".$row2["NAME"]." (".$row2["DESIGNATOR"].")</option><br>";
									} else {
										echo "<option value=\"".$row2["DESIGNATOR"]."\">".$row2["NAME"]." (".$row2["DESIGNATOR"].")</option><br>";
									}
								}
								oci_free_statement($stid);
							}
						?>
					  </select>
					  <p id = "flightRouteError" class = "collapse text-danger"   data-toggle="false">Please do not select same origin and destination.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Destination</label>
					<div class="col-xs-9">  
					  <select  id="flight-destination" class = "form-control input-sm"  onchange = "validateFlightRoute()"> 
						<?php
							if ($_POST['selected'] == "flight") {
								require("config.php");
								$sql = "SELECT a.name, a.designator FROM airport a";
								$stid = oci_parse($dbh, $sql);
								oci_execute($stid, OCI_DEFAULT);
								while($row2 = oci_fetch_array($stid)){
									if($row2["DESIGNATOR"] == $row['DESTINATION']) {
										echo "<option selected = \"true\" value=\"".$row2["DESIGNATOR"]."\">".$row2["NAME"]." (".$row2["DESIGNATOR"].")</option><br>";
									} else {
										echo "<option value=\"".$row2["DESIGNATOR"]."\">".$row2["NAME"]." (".$row2["DESIGNATOR"].")</option><br>";
									}
								}
								oci_free_statement($stid);
							}
						?>
					  </select>
					  <p id = "flightRouteError" class = "collapse text-danger"   data-toggle="false">Please do not select same origin and destination.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Seat Capacity</label>
					<div class="col-xs-9">
						<input id = "flight-seat-capacity" type="text" class="form-control" placeholder="Seat Capacity"  required autofocus="" value = "<?php echo $row['SEAT_CAPACITY']; ?>">
					</div>
				</div>
				<div class="form-group">
					<div id = "flight-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-primary" onclick = "return handleEditFlight()">Edit Flight</button>
					</div>
				</div>
			</form>
			<div id = "edit-flight-error-result" class = "collapse" data-toggle="false">
				<p id = "edit-flight-error-msg"></p>
			</div>
		</div>
		<!-- end for flight stuffs -->
				
		<!-- edit schedule stuffs -->
		<!-- div box for schedule -->
		<div id = "schedule" <?php if ($_POST['selected'] != "schedule") { echo 'class = "collapse" data-toggle = "false"';}?> >
			<form id = "edit-schedule-form" class="form-horizontal"> 			
				<div class="form-group">
					<label for="inputFlight" class="control-label col-xs-3" >Flight Number</label>
					<div class="col-xs-9">		
						<input id = "schedule-flight" id="inputFlight" type="text" class="form-control" placeholder="Flight Number" required autofocus="" name = "<?php echo $row['FLIGHT_NUMBER']; ?>" disabled value = "<?php echo $row['FLIGHT_NUMBER']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Departure Time</label>
					<div class="col-xs-9">		
						<input id = "schedule-departure" type="datetime-local" class="form-control" placeholder="Departure Time"  required autofocus=""name = "<?php echo $row['DEPART_TIME']; ?>" value = "<?php echo $row['DEPART_TIME_DISPLAY']; ?>">
						<p id = "scheduleError" class = "collapse text-danger"   data-toggle="false">Oops! There is another schedule with similar depart time for this flight.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Arrival Time</label>
					<div class="col-xs-9">		
						<input id = "schedule-arrival" type="datetime-local" class="form-control" placeholder="Arrival Time"  required autofocus="" name = "<?php echo $row['ARRIVAL_TIME']; ?>" value = "<?php echo $row['ARRIVAL_TIME_DISPLAY']; ?>">
						<p id = "scheduleTimeError" class = "collapse text-danger"  data-toggle="false">Departure time should be before arrival time</p></div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Price</label>
					<div class="col-xs-9">
						<input id = "schedule-price" type="text" class="form-control" placeholder="Price"  required autofocus="" value = "<?php echo $row['PRICE']; ?>">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-xs-3">Number Of Seats Available </label>
					<div class="col-xs-9">
						<input id = "schedule-seats" type="text" class="form-control" placeholder="Number Of Seats Available"  required autofocus="" value = "<?php echo $row['NUM_OF_SEATS_AVAIL']; ?>">
					</div>
				</div>
				<div class="form-group">
					<div id = "schedule-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-primary" onclick = "return handleEditSchedule()">Edit Schedule</button>
					</div>
				</div>
			</form>
			<div id = "edit-schedule-error-result" class = "collapse" data-toggle="false">
				<p id = "edit-schedule-error-msg"></p>
			</div>	
			</form>
      </div>
	  
		<!-- edit booking stuffs -->
		<!-- div box for booking -->
		<div id = "booking" <?php if ($_POST['selected'] != "booking") { echo 'class = "collapse" data-toggle = "false"';}?> >
			<form id = "edit-booking-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Booking Id</label>
					<div class="col-xs-9">		
						<input id = "booking-id" type="text" class="form-control" value = "<?php echo $_POST['id']; ?>" disabled>
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-xs-3">Flight</label>
					<div class="col-xs-9">		
						<input id = "booking-flight" type="text" class="form-control" value = "<?php echo $row['FLIGHT_NUMBER']; ?>" disabled>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Departure Time</label>
					<div class="col-xs-9">		
						<input id = "booking-depart-time" type="text" class="form-control" name = "<?php echo $row['DEPART_TIME']; ?>" value = "<?php echo $row['DEPART_TIME_DISPLAY']; ?>" disabled>
					</div>
				</div>					
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Email</label>
					<div class="col-xs-9">		
						<input id = "booking-email" type="text" class="form-control" placeholder="Email address" name = "<?php echo $row['C_EMAIL']; ?>" value = "<?php echo $row['C_EMAIL']; ?>" required autofocus="">
						<p id = "bookingEmailError" class = "collapse text-danger"  data-toggle="false">Invalid email format</p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Name</label>
					<div class="col-xs-9">		
						<input id = "booking-name" type="text" class="form-control" placeholder="Contact Name" value = "<?php echo $row['C_PERSON']; ?>" required autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Number</label>
					<div class="col-xs-9">		
						<input id = "booking-number" type="number" class="form-control" placeholder="Contact Number" value = "<?php echo $row['C_NUMBER']; ?>" required autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<div id = "booking-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-primary" onclick = "return handleEditBooking()">Edit Booking</button>
					</div>
				</div>			
			</form>
			<div id = "edit-booking-error-result"  class = "collapse text-danger"   data-toggle="false">
				<p id = "edit-booking-error-msg"></p>
			</div>
		</div>
		<!-- end for booking -->	
		
		<div id = "edit-successful-result" class = "col-xs-offset-3 collapse" data-toggle="false">
			<p id = "edit-successful-msg" class = "alert alert-success" role = "alert"></p>
			<a href = "admin_panel_edit.php"><button class="btn btn-primary">Edit another record</button></a>
		</div>	
		
		<!-- passenger table for booking -->
		<?php
			if ($_POST['selected'] == "booking") {
				echo '<br/><br/>';
				// retrieve the passengers for this booking
				$sql = "SELECT p.* FROM passenger p, booking_passenger bp WHERE p.PASSPORT_NUMBER = bp.PASSENGER AND bp.BOOKING_ID = '".$_POST['id']."'";
				$stid = oci_parse($dbh, $sql);
				oci_execute($stid, OCI_DEFAULT);
				
				$rowData = "";
				$index = 0;
				while($passenger = oci_fetch_array($stid)) {
					// put a checkbox and if the box is tick, delete this passenger from this booking	
					$rowData = $rowData."<tr id = \"".$index."\" class = \"collapse in\" data-toggle = \"false\">
					<td>".$passenger['PASSPORT_NUMBER']."</td>
					<td>".$passenger['TITLE']."</td>
					<td>".$passenger['FIRST_NAME']."</td>
					<td>".$passenger['LAST_NAME']."</td>
					<td><span class=\"glyphicon glyphicon-remove \" value=\"".$row['PASSPORT_NUMBER']."\" onclick = \"return handleDeletePassengerFromBooking('".$index."','".$_POST['id']."','".$passenger['PASSPORT_NUMBER']."','".$row['FLIGHT_NUMBER']."','".$row['DEPART_TIME']."')\"></span></td>
					</tr>";	
					$index++;		
				}
				echo '<table id="passenger-table" class="table table-striped table-hover"><thead><th>Passport</th><th>Title</th><th>First Name</th><th>Last Name</th></thead><tbody>'.$rowData.'</tbody></table>';
				echo '<form><div class="form-group"><label class="control-label col-xs-offset-3 col-xs-9">To remove passenger(s) from the booking, click on the delete icon.<br/> Note: The last remaining passenger cannot be removed.</label></div></form>';
			}
		?>	
		<!-- end -->

		<!-- alert modal -->
		<div class="modal fade" id="alert-modal" data-toggle="false" data-keyboard = "false" data-backdrop = "static">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id = "alert-modal-title"></h3>
				</div>
				<div class="modal-body" id="alert-modal-content"></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal-->
		<!-- end of alert modal -->
		
    </div> 
	<!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
