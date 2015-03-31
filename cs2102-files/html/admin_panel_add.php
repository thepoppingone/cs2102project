<?php
session_start();
if(empty($_SESSION['admin'])) {
	header("location: user_login.php");
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

    <title>Add - Home Page</title>

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
              <li class="active"><a href="admin_panel_add.php"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
              <li><a href="admin_panel_delete.php"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
              <li><a href="admin_panel_edit.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
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
		<!-- drop down bar for selecting category-->
		<form name = "admin_add_panel_form" class="form-horizontal collapse in" id = "category-form" data-toggle="false">
			<div class="form-group">
				<label class="control-label col-xs-3">Category </label>
				<div class="col-xs-9">
					<select id="add-category" class = "form-control input-sm"  onchange = "addCategoryChange()" required>
						<option selected = "true" disabled>Select category</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="administrator">Administrator</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="booking">Booking</option>
						<option value="passenger">Passenger (add to existing booking)</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="airport">Airport</option>
						<option value="flight">Flight</option>
						<option value="schedule">Flight Schedule</option>
					</select>
				</div>
			</div>
		</form>
		
		<!-- add new admin stuffs -->
		<!-- div box for adminstrator -->
		<div id = "administrator" class = "collapse" data-toggle="false">
			<form id = "add-admin-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "admin-name" type="text" class="form-control" placeholder="Name" required autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<label class="control-label col-xs-3">Email Address</label>
					<div class="col-xs-9">		
						<input id = "admin-email" type="text" class="form-control" placeholder="Email address" required autofocus="">
						<p id = "adminEmailError" class = "collapse text-danger"  data-toggle="false"></p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Password</label>
					<div class="col-xs-9">
						<input id = "admin-pwd" class="form-control" placeholder="Password" required autofocus="">
					</div>
				</div>
				<div class="form-group">
					<div id = "admin-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddAdmin()">Add Administrator</button>
					</div>
				</div>
			</form>
			<div id = "add-admin-error-result"  class = "collapse text-danger"   data-toggle="false">
				<p id = "add-admin-error-msg"></p>
			</div>
		</div>
		<!-- end for add new admin stuffs -->
		
		<!-- add new passenger into existing booking -->
		<!-- div box for passenger -->
		<div id = "passenger" class = "collapse" data-toggle="false">
			<form id = "add-passenger-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Booking Id</label>
					<div class="col-xs-9">
						<select  id = "passenger-booking-id" class = "form-control input-sm" required>
							<?php
								require("config.php");
								$sql = "SELECT b.ID, s.FLIGHT_NUMBER, s.DEPART_TIME FROM booking b, schedule s WHERE b.FLIGHT_NUMBER = s.FLIGHT_NUMBER AND b.DEPART_TIME = s.DEPART_TIME AND s.NUM_OF_SEATS_AVAIL > 0".
										"AND 4 > (SELECT COUNT(*) FROM booking_passenger bp WHERE bp.BOOKING_ID = b.ID)";
								$stid = oci_parse($dbh, $sql);
								oci_execute($stid, OCI_DEFAULT);
								while($row = oci_fetch_array($stid)){
									echo "<option value=\"".$row["ID"]."\">".$row["ID"]." - ".$row["FLIGHT_NUMBER"]." (departing on ".$row["DEPART_TIME"].")</option><br>";
								}
								oci_free_statement($stid);
								ocilogoff($dbh);
							?>
						</select>
					</div>
				</div>			
				<div class="form-group">
					<label class="control-label col-xs-3">Passport Number</label>
					<div class="col-xs-9">		
						<input id = "passenger-passport" type="text" class="form-control" placeholder="Passport Number"  required autofocus="">
						<p id = "passengerPassportError" class = "collapse text-danger"  data-toggle="false"></p>
					</div>
				</div>					
				<div class="form-group">
					<label class="control-label col-xs-3">Title</label>
					<div class="col-xs-9">		
						<select id="passenger-title" class = "form-control input-sm" required>
							<option value="Mr" selected = "true">Mr</option>
							<option value="Ms">Ms</option>
							<option value="Mrs">Mrs</option>
							<option value="airport">Mdm</option>
						</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">First Name</label>
					<div class="col-xs-9">		
						<input id = "passenger-first-name" type="text" class="form-control" placeholder="First Name"  required autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Last Name</label>
					<div class="col-xs-9">		
						<input id = "passenger-last-name" type="text" class="form-control" placeholder="Last Name"  required autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<div id = "passenger-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddPassenger('check')">Add Passenger</button>
					</div>
				</div>
			</form>
			<div id = "add-passenger-error-result"  class = "collapse text-danger"   data-toggle="false">
				<p id = "add-passenger-error-msg"></p>
			</div>
		</div>
		<!-- end for passenger -->		
		
		<!-- add new booking -->
		<!-- div box for booking -->
		<div id = "booking" class = "collapse" data-toggle="false">
			<form id = "add-booking-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Email</label>
					<div class="col-xs-9">		
						<input id = "booking-email" type="text" class="form-control" placeholder="Email address" required autofocus="">
						<p id = "bookingEmailError" class = "collapse text-danger"  data-toggle="false"></p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Name</label>
					<div class="col-xs-9">		
						<input id = "booking-name" type="text" class="form-control" placeholder="Contact Name" required autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Number</label>
					<div class="col-xs-9">		
						<input id = "booking-number" type="number" class="form-control" placeholder="Contact Number" required autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Flight Schedule</label>
					<div class="col-xs-9">		
						<select  id="booking-schedule" class = "form-control input-sm" onchange = "validateSeatRequest()" required >
							<?php
								require("config.php");
								$sql = "SELECT s.*, f.ORIGIN, f.DESTINATION, TO_CHAR(s.DEPART_TIME, 'DD MON YYYY HH24:MI:SS') AS DEPART_TIME_DISPLAY FROM flight f, schedule s WHERE s.FLIGHT_NUMBER = f.F_NUMBER AND s.NUM_OF_SEATS_AVAIL > 0 ORDER BY s.FLIGHT_NUMBER, s.DEPART_TIME ASC";
								$stid = oci_parse($dbh, $sql);
								oci_execute($stid, OCI_DEFAULT);
								$first_value ;
								while($row = oci_fetch_array($stid)){
									if(empty($first_value)) {
										$first_value = $row["NUM_OF_SEATS_AVAIL"];
									}
									echo "<option value=\"".$row["FLIGHT_NUMBER"].";".$row["DEPART_TIME"].";".$row["NUM_OF_SEATS_AVAIL"]."\">".$row["FLIGHT_NUMBER"]." (".$row["ORIGIN"]." to ".$row["DESTINATION"]." departing on ".$row["DEPART_TIME_DISPLAY"].")</option><br>";
								}
								oci_free_statement($stid);
								ocilogoff($dbh);	
							?>
						</select>
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-xs-3">Number of Passengers</label>
					<div class="col-xs-9">
						<select  id="booking-passenger-num" class = "form-control input-sm" onchange = "loadPassengerFields()" required > 
							<?php
								for ($x = 1; $x <= 4 && $x <= $first_value; $x++) {
									echo "<option value=\"".$x."\">".$x."</option><br>";
								}
							?>
						</select>
					</div>
				</div>	
				<!-- passenger 1-->
				<div id = "passenger-1" class = "collapse in" data-toggle = "false">
					<br/>
					<div class="form-group"><label class="control-label col-xs-offset-3 col-xs-9">Passenger 1 Details</label></div>
					<div class="form-group">
						<label class="control-label col-xs-3">Passport Number</label>
						<div class="col-xs-9">		
							<input id = "passenger-passport-1" type="text" class="form-control" placeholder="Passport Number"  required autofocus="">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Title</label>
						<div class="col-xs-9">		
							<select id="passenger-title-1" class = "form-control input-sm" required>
								<option value="Mr" selected = "true">Mr</option>
								<option value="Ms">Ms</option>
								<option value="Mrs">Mrs</option>
								<option value="airport">Mdm</option>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">First Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-first-name-1" type="text" class="form-control" placeholder="First Name"  required autofocus="">
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">Last Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-last-name-1" type="text" class="form-control" placeholder="Last Name"  required autofocus="">
						</div>
					</div>
				</div>		
				<!-- end of passenger 1-->
				<!-- passenger 2-->
				<div id = "passenger-2" class = "collapse" data-toggle = "false">
					<br/>
					<div class="form-group"><label class="control-label col-xs-offset-3 col-xs-9">Passenger 2 Details</label></div>
					<div class="form-group">
						<label class="control-label col-xs-3">Passport Number</label>
						<div class="col-xs-9">		
							<input id = "passenger-passport-2" type="text" class="form-control" placeholder="Passport Number"  required autofocus="">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Title</label>
						<div class="col-xs-9">		
							<select id="passenger-title-2" class = "form-control input-sm" required>
								<option value="Mr" selected = "true">Mr</option>
								<option value="Ms">Ms</option>
								<option value="Mrs">Mrs</option>
								<option value="airport">Mdm</option>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">First Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-first-name-2" type="text" class="form-control" placeholder="First Name"  required autofocus="">
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">Last Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-last-name-2" type="text" class="form-control" placeholder="Last Name"  required autofocus="">
						</div>
					</div>
				</div>	
				<!-- end of passenger 2-->
				<!-- passenger 3-->
				<div id = "passenger-3" class = "collapse" data-toggle = "false">
					<br/>
					<div class="form-group"><label class="control-label col-xs-offset-3 col-xs-9">Passenger 3 Details</label></div>
					<div class="form-group">
						<label class="control-label col-xs-3">Passport Number</label>
						<div class="col-xs-9">		
							<input id = "passenger-passport-3" type="text" class="form-control" placeholder="Passport Number"  required autofocus="">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Title</label>
						<div class="col-xs-9">		
							<select id="passenger-title-3" class = "form-control input-sm" required>
								<option value="Mr" selected = "true">Mr</option>
								<option value="Ms">Ms</option>
								<option value="Mrs">Mrs</option>
								<option value="airport">Mdm</option>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">First Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-first-name-3" type="text" class="form-control" placeholder="First Name"  required autofocus="">
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">Last Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-last-name-3" type="text" class="form-control" placeholder="Last Name"  required autofocus="">
						</div>
					</div>
				</div>	
				<!-- end of passenger 3-->
				<!-- passenger 4-->
				<div id = "passenger-4" class = "collapse" data-toggle = "false">
					<br/>
					<div class="form-group"><label class="control-label col-xs-offset-3 col-xs-9">Passenger 4 Details</label></div>
					<div class="form-group">
						<label class="control-label col-xs-3">Passport Number</label>
						<div class="col-xs-9">		
							<input id = "passenger-passport-4" type="text" class="form-control" placeholder="Passport Number"  required autofocus="">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Title</label>
						<div class="col-xs-9">		
							<select id="passenger-title-4" class = "form-control input-sm" required>
								<option value="Mr" selected = "true">Mr</option>
								<option value="Ms">Ms</option>
								<option value="Mrs">Mrs</option>
								<option value="airport">Mdm</option>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">First Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-first-name-4" type="text" class="form-control" placeholder="First Name"  required autofocus="">
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-xs-3">Last Name</label>
						<div class="col-xs-9">		
							<input id = "passenger-last-name-4" type="text" class="form-control" placeholder="Last Name"  required autofocus="">
						</div>
					</div>
				</div>			
				<!-- end of passenger 4-->
				<div class="form-group">
					<div id = "booking-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<!-- uncompleted work : handleAddReservation() should add the booking and then continue to update the html so that it ask for passenger info -->
						<button type="submit" class="btn btn-primary" onclick = "return handleAddBooking('check')">Add Booking</button>
					</div>
				</div>
			</form>
			<div id = "add-booking-error-result"  class = "collapse text-danger"   data-toggle="false">
				<p id = "add-booking-error-msg"></p>
			</div>
		</div>
		<!-- end for booking -->				
		
		
		<!-- add new airport stuffs -->
		<!-- div box for airport -->
		<div id = "airport" class = "collapse" data-toggle="false">
			<form id = "add-airport-form" class="form-horizontal"> 				
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "airport-name" type="text" class="form-control" placeholder="Airport Name"  required autofocus="">
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Location</label>
					<div class="col-xs-9">		
						<input id = "airport-location" type="text" class="form-control" placeholder="Airport Location"  required autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Designator</label>
					<div class="col-xs-9">		
						<input id = "airport-designator" type="text" class="form-control" placeholder="Airport Designator"  required autofocus="">
						<p id = "airportDesignatorError"  class = "collapse text-danger"   data-toggle="false">Oops! This airport designator is already recorded. </p>
					</div>
				</div>
				<div class="form-group">
					<div id = "airport-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddAirport()">Add Airport</button>
					</div>
				</div>
			</form>
			<div id = "add-airport-error-result" class = "collapse text-danger"   data-toggle="false">
				<p id = "add-airport-error-msg"></p>
			</div>
		</div>
		<!-- end for add new airport stuffs -->			
		
		<!-- add new flight stuffs -->
		<!-- div box for flight -->
		<div id = "flight" class = "collapse" data-toggle="false">
			<form id = "add-flight-form" class="form-horizontal"> 			
				<div class="form-group">
					<label class="control-label col-xs-3">Number</label>
					<div class="col-xs-9">		
						<input id = "flight-number" type="number" class="form-control" placeholder="Flight Number"  required autofocus="">
						<p id = "flightDesignatorError" class = "collapse text-danger"  data-toggle="false">This flight is already recorded. </p>
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Origin</label>
					<div class="col-xs-9">		
						<select  id="flight-origin" class = "form-control input-sm"  onchange = "validateFlightRoute()" required>
						<?php
							require("config.php");
							$sql = "SELECT a.name, a.designator FROM airport a";
							$stid = oci_parse($dbh, $sql);
							oci_execute($stid, OCI_DEFAULT);
							while($row = oci_fetch_array($stid)){
								echo "<option value=\"".$row["DESIGNATOR"]."\">".$row["DESIGNATOR"]." (".$row["NAME"].")</option><br>";
							}
							oci_free_statement($stid);
							ocilogoff($dbh);	
						?>
						</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Destination</label>
					<div class="col-xs-9">		
						<select  id="flight-destination" class = "form-control input-sm"  onchange = "validateFlightRoute()" required> 
						<?php
							require("config.php");
							$sql = "SELECT a.name, a.designator FROM airport a";
							$stid = oci_parse($dbh, $sql);
							oci_execute($stid, OCI_DEFAULT);
							while($row = oci_fetch_array($stid)){
								echo "<option value=\"".$row["DESIGNATOR"]."\">".$row["DESIGNATOR"]." (".$row["NAME"].")</option><br>";
							}
							oci_free_statement($stid);
							ocilogoff($dbh);	
						?>
						</select>
						<p id = "flightRouteError" class = "collapse text-danger"   data-toggle="false">Please do not select same origin and destination.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Seat Capacity</label>
					<div class="col-xs-9">		
						<input id = "flight-seat" type="number" class="form-control" placeholder="Number of passenger seats available" required autofocus="" onchange = "validateSeatCapacity()">
						<p id = "seatCapacityError" class = "collapse text-danger"  data-toggle="false">Seat capacity should be at least 1</p>
					</div>
				</div>					
				<div class="form-group">
					<div id = "flight-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddFlight()">Add Flight</button>
					</div>
				</div>
			</form>
			<div id = "add-flight-error-result" class = "collapse text-danger"   data-toggle="false">
				<p id = "add-flight-error-msg"></p>
			</div>
		</div>
		<!-- end for add new flight stuffs -->		
		
		<!-- add new schedule stuffs -->
		<!-- div box for schedule -->
		<div id = "schedule" class = "collapse" data-toggle="false">
			<form id = "add-schedule-form" class="form-horizontal"> 	
				<div class="form-group">
					<label class="control-label col-xs-3">Flight</label>
					<div class="col-xs-9">		
						<select  id="schedule-flight" class = "form-control input-sm" required > 
						<?php
							require("config.php");
							$sql = "SELECT f.F_NUMBER, f.ORIGIN, f.DESTINATION, f.SEAT_CAPACITY FROM flight f";
							$stid = oci_parse($dbh, $sql);
							oci_execute($stid, OCI_DEFAULT);
							while($row = oci_fetch_array($stid)){
								echo "<option value=\"".$row["F_NUMBER"]."\">".$row["F_NUMBER"]." (".$row["ORIGIN"]." to ".$row["DESTINATION"].", ".$row["SEAT_CAPACITY"]." seats)</option><br>";
							}
							oci_free_statement($stid);
							ocilogoff($dbh);	
						?>
						</select>
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Departure Time</label>
					<div class="col-xs-9">		
						<input id = "schedule-departure" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  required autofocus="">
						<p id = "scheduleExistsError" class = "collapse text-danger"  data-toggle="false">This schedule is already recorded. </p>
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Arrival Time</label>
					<div class="col-xs-9">		
						<input id = "schedule-arrival" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Arrival Time"  required autofocus="">
						<p id = "scheduleTimeError" class = "collapse text-danger"  data-toggle="false">Departure time should be before arrival time</p>
					</div>
				</div>					
				<div class="form-group">
					<label class="control-label col-xs-3">Price</label>
					<div class="col-xs-9">		
						<input id = "schedule-price" type="number" class="form-control" placeholder="Air Ticket Price" required autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<div id = "schedule-button" class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddSchedule()">Add Schedule</button>
					</div>
				</div>
			</form>
			<div id = "add-schedule-error-result" class = "collapse text-danger"  data-toggle="false">
				<p id = "add-schedule-error-msg"></p>
			</div>
		</div>
		<!-- end for add new schedule stuffs -->			
		
		<div id = "add-successful-result" class = "col-xs-offset-3 collapse" data-toggle="false">
			<p id = "add-successful-msg" class = "alert alert-success" role = "alert"></p>
			<a href = "admin_panel_add.php"><button class="btn btn-primary">Add another record</button></a>
		</div>		
		
		<div class="modal fade" id="error-modal" data-toggle="false" data-keyboard = "false" data-backdrop = "static">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Invalid Input</h3>
				</div>
				<div class="modal-body" id="error-modal-content"><!-- contents to be populated by js & php --></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Okay</button>
				</div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal-->			

		<div class="modal fade" id="confirm-modal" data-toggle="false" data-keyboard = "false" data-backdrop = "static">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Continue to add record?</h3>
				</div>
				<div class="modal-body" id="confirm-modal-content"><!-- contents to be populated by js & php --></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button id = "confirm-add-btn" class="btn btn-primary">Continue</button>
				</div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal-->	
		
	 </div>
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
