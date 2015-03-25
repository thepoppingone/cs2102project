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
	  $sql = "SELECT * FROM schedule s WHERE s.flight_number = '".$_POST['flight']."'AND s.depart_time = '".$_POST['departure']."'";
	 } else{
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
					<label class="control-label col-xs-3">Type</label>
					<div class="col-xs-9">		
						<input id = "passenger-type" type="text" class="form-control" placeholder="Type" required autofocus="" value = "<?php echo $row['TYPE']; ?>">
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
						<input id = "flight-num" type="text" id="inputNum" class="form-control" placeholder="Flight Number"  required autofocus="" name = "<?php echo $row['F_NUMBER']; ?>" value = "<?php echo $row['F_NUMBER']; ?>">
						<p id = "flightNumError" class = "collapse" class="text-danger" data-toggle="false">Oops! A flight with this flight number already exists.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Origin</label>
					<div class="col-xs-9">  
					  <select  id="flight-origin" class = "form-control input-sm"  onchange = "validateFlightRoute()"> 
					  <option selected = "true" disabled>
					  <?php 
						require("config.php");
						$sql = "SELECT a.name FROM airport a WHERE a.designator='".$row['ORIGIN']."'";
						$stid = oci_parse($dbh, $sql);
						oci_execute($stid, OCI_DEFAULT);
						$row2 = oci_fetch_array($stid);
						echo $row2["NAME"]." (".$row['ORIGIN'].")"; 
					  ?>
					  </option>
					  <?php
					   require("config.php");
					   $sql = "SELECT a.name, a.designator FROM airport a";
					   $stid = oci_parse($dbh, $sql);
					   oci_execute($stid, OCI_DEFAULT);
					   while($row2 = oci_fetch_array($stid)){
						echo "<option value=\"".$row2["DESIGNATOR"]."\">".$row2["NAME"]." (".$row2["DESIGNATOR"].")</option><br>";
					   }
					   oci_free_statement($stid);
					  ?>
					  </select>
					  <p id = "flightRouteError" class = "collapse text-danger"   data-toggle="false">Please do not select same origin and destination.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Destination</label>
					<div class="col-xs-9">  
					  <select  id="flight-dest" class = "form-control input-sm"  onchange = "validateFlightRoute()"> 
					  <option selected = "true" disabled>
					  <?php 
						require("config.php");
						$sql = "SELECT a.name FROM airport a WHERE a.designator='".$row['DESTINATION']."'";
						$stid = oci_parse($dbh, $sql);
						oci_execute($stid, OCI_DEFAULT);
						$row2 = oci_fetch_array($stid);
						echo $row2["NAME"]." (".$row['DESTINATION'].")"; 
					  ?>
					  </option>
					  <?php
					   require("config.php");
					   $sql = "SELECT a.name, a.designator FROM airport a";
					   $stid = oci_parse($dbh, $sql);
					   oci_execute($stid, OCI_DEFAULT);
					   while($row2 = oci_fetch_array($stid)){
						echo "<option value=\"".$row2["DESIGNATOR"]."\">".$row2["NAME"]." (".$row2["DESIGNATOR"].")</option><br>";
					   }
					   oci_free_statement($stid);
					  ?>
					  </select>
					  <p id = "flightRouteError" class = "collapse text-danger"   data-toggle="false">Please do not select same origin and destination.</p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Seat Capacity</label>
					<div class="col-xs-9">
						<input id = "flight-seatcapacity" type="text" class="form-control" placeholder="Seat Capacity"  required autofocus="" value = "<?php echo $row['SEAT_CAPACITY']; ?>">
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
						<input id = "schedule-flight" id="inputFlight" type="text" class="form-control" placeholder="Flight Number" required autofocus="" name = "<?php echo $row['FLIGHT_NUMBER']; ?>" value = "<?php echo $row['FLIGHT_NUMBER']; ?>">
					</div>
				</div>
			
				<div class="form-group">
					<label class="control-label col-xs-3">Price</label>
					<div class="col-xs-9">
						<input id = "schedule-price" type="text" class="form-control" placeholder="Price"  required autofocus="" value = "<?php echo $row['PRICE']; ?>">
					</div>
				</div>
				
			</form>
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
