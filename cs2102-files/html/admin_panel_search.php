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

    <title>Search - Home Page</title>

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
              <li><a href="admin_panel_edit.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
              <li class="active"><a href="admin_panel_search.php"><span class="glyphicon glyphicon-search"></span> Search</a></li>
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
		<form name = "admin_search_panel_form" class="form-horizontal collapse in" id = "category-form" data-toggle="false">
			<div class="form-group">
				<label class="control-label col-xs-3">Category </label>
				<div class="col-xs-9">
					<select id="search-category" class = "form-control input-sm"  onchange = "searchCategoryChange()" required>
						<option selected = "true" disabled>Select category</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="administrator">Administrator</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="passenger">Passenger</option>
						<option value="reservation">Reservation</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="airport">Airport</option>
						<option value="flight">Flight</option>
						<option value="schedule">Flight Schedule</option>
					</select>
				</div>
			</div>
		</form>
		
		<!-- div box for adminstrator search fields -->
		<div id = "administrator" class = "collapse" data-toggle="false">
			<form id = "search-admin-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "admin-name" type="text" class="form-control" placeholder="Name"  autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-3">Email Address</label>
					<div class="col-xs-9">		
						<input id = "admin-email" type="email" id="inputEmail" class="form-control" placeholder="Email address"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Password</label>
					<div class="col-xs-9">
						<input id = "admin-pwd" class="form-control" placeholder="Password"  autofocus="">
					</div>
				</div>
				<div class="form-group">
					<div id = "admin-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary pull-right" onclick = "return handleSearchAdmin()">Search Administrator</button>
					</div>
				</div>
			</form>
		</div>
		<!-- end for adminstrator-->
		
		<!-- search for passengers -->
		<!-- div box for passenger -->
		<div id = "passenger" class = "collapse" data-toggle="false">
			<form id = "search-passenger-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Title</label>
					<div class="col-xs-9">		
						<input id = "passenger-title" type="text" class="form-control" placeholder="Title (Mr/Ms/Mdm etc)"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">First Name</label>
					<div class="col-xs-9">		
						<input id = "passenger-first-name" type="text" class="form-control" placeholder="First Name"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Last Name</label>
					<div class="col-xs-9">		
						<input id = "passenger-last-name" type="text" class="form-control" placeholder="Last Name"  autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<label class="control-label col-xs-3">Passport Number</label>
					<div class="col-xs-9">		
						<input id = "passenger-passport" type="text" class="form-control" placeholder="Passport Number"  autofocus="">
					</div>
				</div>	
				<!--
				<div class="form-group">
					<label class="control-label col-xs-3">Reservation Id</label>
					<div class="col-xs-9">
						<select  id = "passenger-reservation-id" class = "form-control input-sm"> 
							<option selected = "true" value = "" disabled>Select Reservation Id</option>
							<?php
								require("config.php");
								$sql = "SELECT b.id FROM booking b";
								$stid = oci_parse($dbh, $sql);
								oci_execute($stid, OCI_DEFAULT);
								while($row = oci_fetch_array($stid)){
									echo "<option value=\"".$row["ID"]."\">".$row["ID"]."</option><br>";
								}
								oci_free_statement($stid);
							?>
						</select>
					</div>
				</div>
				-->
				<div class="form-group">
					<div id = "passenger-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary pull-right" onclick = "return handleSearchPassenger()">Search Passenger</button>
					</div>
				</div>
			</form>
			<div id = "search-passenger-error-result"  class = "col-xs-offset-3 col-xs-9 collapse text-danger"   data-toggle="false">
				<p id = "search-passenger-error-msg"></p>
			</div>
		</div>
		<!-- end for passenger -->				
		
		<!-- search for reservations -->
		<!-- div box for reservations -->
		<div id = "reservation" class = "collapse" data-toggle="false">
			<form id = "search-reservation-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Reservation Id</label>
					<div class="col-xs-9">		
						<input id = "reservation-id" type="number" class="form-control" placeholder="Rerservation Id"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Person</label>
					<div class="col-xs-9">		
						<input id = "reservation-name" type="text" class="form-control" placeholder="Name of Contact Person"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Number</label>
					<div class="col-xs-9">		
						<input id = "reservation-number" type="number" class="form-control" placeholder="Contact Number"  autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Email</label>
					<div class="col-xs-9">		
						<input id = "reservation-email" type="email" class="form-control" placeholder="Contact Email"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Flight Number</label>
					<div class="col-xs-9">		
						<input id = "reservation-flight-number" type="text" class="form-control" placeholder="Flight Number"  autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<label class="control-label col-xs-3">Departure Time Range</label>
					<div class="col-xs-4">
						<input id = "reservation-departure-start" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  autofocus="">
					</div>
					<label class="control-label col-xs-1">to</label>
					<div class="col-xs-4">	
						<input id = "reservation-departure-end" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<div id = "reservation-departure-time-error"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<p class = "text-danger"></p>
					</div>
				</div>	
				<div class="form-group">
					<div id = "passenger-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary pull-right" onclick = "return handleSearchReservation()">Search Reservation</button>
					</div>
				</div>
			</form>
			<div id = "search-reservation-error-result"  class = "col-xs-offset-3 col-xs-9 collapse text-danger" data-toggle="false">
				<p id = "search-reservation-error-msg"></p>
			</div>
		</div>
		<!-- end for reservations -->				
		
		<!-- div box for airport search fields -->
		<div id = "airport" class = "collapse" data-toggle="false">
			<form id = "search-airport-form" class="form-horizontal"> 				
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "airport-name" type="text" class="form-control" placeholder="Airport Name"  autofocus="">
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Location</label>
					<div class="col-xs-9">		
						<input id = "airport-location" type="text" class="form-control" placeholder="Airport Location"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Designator</label>
					<div class="col-xs-9">		
						<input id = "airport-designator" type="text" class="form-control" placeholder="Airport Designator"  autofocus="">
					</div>
				</div>
				<div class="form-group">
					<div id = "airport-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary pull-right" onclick = "return handleSearchAirport()">Search Airport</button>
					</div>
				</div>
			</form>
		</div>
		<!-- end for airport -->			
		
		<!-- div box for flight search fields -->
		<div id = "flight" class = "collapse" data-toggle="false">
			<form id = "search-flight-form" class="form-horizontal"> 				
				<div class="form-group">
					<label class="control-label col-xs-3">Flight Number</label>
					<div class="col-xs-9">		
						<input id = "flight-number" type="number" class="form-control" placeholder="Flight Number"  autofocus="">
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Origin</label>
					<div class="col-xs-9">		
						<input id = "flight-origin" type="text" class="form-control" placeholder="Origin"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Destination</label>
					<div class="col-xs-9">		
						<input id = "flight-destination" type="text" class="form-control" placeholder="Destination"  autofocus="">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Seat Capacity</label>
					<div class="col-xs-4">
						<input id = "flight-seat-min" type="number" class="form-control" placeholder="Minimum Seat Capacity"  autofocus="">
					</div>
					<label class="control-label col-xs-1">to</label>
					<div class="col-xs-4">	
						<input id = "flight-seat-max" type="number" class="form-control" placeholder="Maximum Seat Capacity"  autofocus="">
					</div>	
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Duration</label>
					<div class="col-xs-9">		
						<input id = "flight-duration" type="text" class="form-control" placeholder="4.5 Hours etc"  autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<div id = "flight-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary pull-right" onclick = "return handleSearchFlight()">Search Flight</button>
					</div>
				</div>
			</form>
		</div>
		<!-- end for flight -->			
		
		<!-- div box for schedule search fields -->
		<div id = "schedule" class = "collapse" data-toggle="false">
			<form id = "search-schedule-form" class="form-horizontal"> 				
				<div class="form-group">
					<label class="control-label col-xs-3">Flight Number</label>
					<div class="col-xs-9">		
						<input id = "schedule-flight-number" type="number" class="form-control" placeholder="Flight Number"  autofocus="">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Origin</label>
					<div class="col-xs-9">		
						<input id = "schedule-origin" type="text" class="form-control" placeholder="Canada etc"  autofocus="">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Destination</label>
					<div class="col-xs-9">		
						<input id = "schedule-destination" type="text" class="form-control" placeholder="New York etc"  autofocus="">
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-xs-3">Departure Time Range</label>
					<div class="col-xs-4">
						<input id = "schedule-departure-start" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  autofocus="">
					</div>
					<label class="control-label col-xs-1">to</label>
					<div class="col-xs-4">	
						<input id = "schedule-departure-end" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  autofocus="">
					</div>
				</div>			
				<div class="form-group collapse" data-toggle="false" id = "schedule-departure-time-error-div">
					<div class="col-xs-offset-3 col-xs-9">
						<p id = "schedule-departure-time-error" class = "text-danger"></p>
					</div>
				</div>		

				<div class="form-group">
					<label class="control-label col-xs-3">Arrival Time Range</label>
					<div class="col-xs-4">
						<input id = "schedule-arrival-start" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  autofocus="">
					</div>
					<label class="control-label col-xs-1">to</label>
					<div class="col-xs-4">	
						<input id = "schedule-arrival-end" type="datetime-local" value = "<?php date_default_timezone_set('Asia/Singapore'); $today_date = date('Y-m-d'); echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($today_date)) ?>" class="form-control" placeholder="Departure Time"  autofocus="">
					</div>
				</div>			
				<div class="form-group collapse" data-toggle="false" id = "schedule-arrival-time-error-div">
					<div class="col-xs-offset-3 col-xs-9">
						<p id = "schedule-arrival-time-error"  class = "text-danger"></p>
					</div>
				</div>							
				<!--
				<div class="form-group">
					<label class="control-label col-xs-3">Duration</label>
					<div class="col-xs-9">		
						<input id = "schedule-duration" type="text" class="form-control" placeholder="Origin"  autofocus="">
					</div>
				</div>	
				-->
				<div class="form-group">
					<label class="control-label col-xs-3">Available Seat Capacity</label>
					<div class="col-xs-4">
						<input id = "schedule-seat-min" type="number" class="form-control" placeholder="Minimum"  autofocus="">
					</div>
					<label class="control-label col-xs-1">to</label>
					<div class="col-xs-4">	
						<input id = "schedule-seat-max" type="number" class="form-control" placeholder="Maximum"  autofocus="">
					</div>					
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Price Range</label>
					<div class="col-xs-4">		
						<input id = "schedule-price-lowest" type="number" class="form-control" placeholder="Lowest"  autofocus="">
					</div>
					<label class="control-label col-xs-1">to</label>
					<div class="col-xs-4">		
						<input id = "schedule-price-highest" type="number" class="form-control" placeholder="Highest"  autofocus="">
					</div>					
				</div>					
				<div class="form-group">
					<div id = "schedule-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary pull-right" onclick = "return handleSearchSchedule()">Search Flight Schedule</button>
					</div>
				</div>
				
			</form>
		</div>
		<!-- end for schedule -->				

		<!-- search results div box -->
		<div id = "search-results" class = "collapse" data-toggle="false">
		</div>
		
		<div class="modal fade" id="loadingModal" data-toggle="false" data-keyboard = "false" data-backdrop = "static">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div align="center" class="modal-body">
				<img class='img-responsive' src='../../assets/img/loading1.gif'></img>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal-->
		
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
