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
              <li class="active"><a href="#"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
              <li><a href="admin_delete_panel.php"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
              <li><a href="admin_edit_panel.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
              <li><a href="admin_search_panel.php"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="user_logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
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
						<option value="member">Member</option>
						<option value="reservation">Reservation</option>
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
						<input id = "admin-name" type="text" class="form-control" placeholder="Name"  required autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-3">Email Address</label>
					<div class="col-xs-9">		
						<input id = "admin-email" type="email" id="inputEmail" class="form-control" placeholder="Email address"  required autofocus="">
						<p id = "adminEmailError" class = "collapse" class='text-danger' data-toggle="false">Oops! The owner of the email is already an administrator.</p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Password</label>
					<div class="col-xs-9">
						<input id = "admin-pwd" class="form-control" placeholder="Password"  required autofocus="">
					</div>
				</div>
				<div class="form-group">
					<div id = "admin-button"  class="col-xs-offset-2 col-xs-10 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddAdmin()">Add Administrator</button>
					</div>
				</div>
			</form>
			<div id = "add-admin-error-result" class = "collapse" data-toggle="false">
				<p id = "add-admin-error-msg"></p>
			</div>
		</div>
		<!-- end for add new admin stuffs -->
		
		
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
						<p id = "airportDesignatorError" class = "collapse" class='text-danger' data-toggle="false">Oops! This airport designator is already recorded. </p>
					</div>
				</div>
				<div class="form-group">
					<div id = "airport-button"  class="col-xs-offset-2 col-xs-10 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddAirport()">Add Airport</button>
					</div>
				</div>
			</form>
			<div id = "add-airport-error-result" class = "collapse" data-toggle="false">
				<p id = "add-airport-error-msg"></p>
			</div>
		</div>
		<!-- end for add new airport stuffs -->			
		
		<!-- add new flight stuffs -->
		<!-- div box for flight -->
		<div id = "flight" class = "collapse" data-toggle="false">
			<form id = "add-flight-form" class="form-horizontal"> 	
				<div class="form-group">
					<label class="control-label col-xs-3">Designator</label>
					<div class="col-xs-9">		
						<input id="flight-designator" type = "text" class = "form-control" placeholder = "Designator" required autofocus=""> 
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-xs-3">Number</label>
					<div class="col-xs-9">		
						<input id = "flight-number" type="number" class="form-control" placeholder="Flight Number"  required autofocus="">
						<p id = "flightDesignatorError" class = "collapse" class='text-danger' data-toggle="false">Oops! This flight is already recorded. </p>
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Origin</label>
					<div class="col-xs-9">		
						<select  id="flight-origin" class = "form-control input-sm"  onchange = "validateFlightRoute()" required> 
						<option selected = "true" disabled>Select Airport</option>
						<?php
							require("config.php");
							$sql = "SELECT a.name, a.designator FROM airport a";
							$stid = oci_parse($dbh, $sql);
							oci_execute($stid, OCI_DEFAULT);
							while($row = oci_fetch_array($stid)){
								echo "<option value=\"".$row["DESIGNATOR"]."\">".$row["NAME"]." (".$row["DESIGNATOR"].")</option><br>";
							}
							oci_free_statement($stid);
						?>
						</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Destination</label>
					<div class="col-xs-9">		
						<select  id="flight-destination" class = "form-control input-sm"  onchange = "validateFlightRoute()" required> 
						<option selected = "true" disabled>Select Airport</option>
						<?php
							require("config.php");
							$sql = "SELECT a.name, a.designator FROM airport a";
							$stid = oci_parse($dbh, $sql);
							oci_execute($stid, OCI_DEFAULT);
							while($row = oci_fetch_array($stid)){
								echo "<option value=\"".$row["DESIGNATOR"]."\">".$row["NAME"]." (".$row["DESIGNATOR"].")</option><br>";
							}
							oci_free_statement($stid);
						?>
						</select>
						<p id = "flightRouteError" class = "collapse" class='text-danger' data-toggle="false">Please do not select same origin and destination.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Duration</label>
					<div class="col-xs-9">		
						<input id = "flight-duration" type="text" class="form-control" placeholder="4.5 Hours etc"  required autofocus="">
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Seat Capacity</label>
					<div class="col-xs-9">		
						<input id = "flight-seat" type="number" class="form-control" placeholder="Number of passenger seats"  required autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<div id = "flight-button"  class="col-xs-offset-2 col-xs-10 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddFlight()">Add Flight</button>
					</div>
				</div>
			</form>
			<div id = "add-flight-error-result" class = "collapse" data-toggle="false">
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
						<select  id="schedule-flight" class = "form-control input-sm" onchange = "validateAircraft()"  required > 
						<option selected = "true" value ="" disabled>Select Flight</option>
						<?php
							require("config.php");
							$sql = "SELECT f.f_number, f.designator, f.origin, f.destination FROM flight f";
							$stid = oci_parse($dbh, $sql);
							oci_execute($stid, OCI_DEFAULT);
							while($row = oci_fetch_array($stid)){
								echo "<option value=\"".$row["DESIGNATOR"]." ".$row["F_NUMBER"]."\">".$row["DESIGNATOR"].$row["F_NUMBER"]." (".$row["ORIGIN"]." to ".$row["DESTINATION"].")</option><br>";
							}
							oci_free_statement($stid);
						?>
						</select>
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-xs-3">Seat Availability</label>
					<div class="col-xs-9">		
						<input id = "schedule-seats" type="number" class="form-control" placeholder="Number of Seats Available"  required autofocus="" onfocusout="validateScheduleSeat()">
						<p id = "scheduleSeatError" class = "collapse" class='text-danger' data-toggle="false"></p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Departure Time</label>
					<div class="col-xs-9">		
						<input id = "schedule-departure" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  required autofocus="">
						<p id = "scheduleTimeError" class = "collapse" class='text-danger' data-toggle="false">Oops! This flight has already been scheduled for this departure time!</p>
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Arrival Time</label>
					<div class="col-xs-9">		
						<input id = "schedule-arrival" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Arrival Time"  required autofocus="">
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-xs-3">Price</label>
					<div class="col-xs-9">		
						<input id = "schedule-price" type="number" class="form-control" placeholder="Air Ticket Price"  required autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<div id = "schedule-button"  class="col-xs-offset-2 col-xs-10 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleAddSchedule()">Add Schedule</button>
					</div>
				</div>
			</form>
			<div id = "add-schedule-error-result" class = "collapse" data-toggle="false">
				<p id = "add-schedule-error-msg"></p>
			</div>
		</div>
		<!-- end for add new schedule stuffs -->			
		<div id = "add-successful-result" class = "collapse" data-toggle="false">
			<p id = "add-successful-msg"></p>
			<a href = "admin_add_panel.php"><button class="btn btn-primary">Add another record</button></a>
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
