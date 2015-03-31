 <?php
	if(empty($_POST)) {
		header("location: user_manage_booking.php");
	} else {
		require("config.php");
		$sql = "SELECT b.*, TO_CHAR(b.DEPART_TIME, 'DD MON YYYY HH24:MI') AS DEPART_TIME_DISPLAY, TO_CHAR(s.ARRIVAL_TIME, 'DD MON YYYY HH24:MI') AS ARRIVAL_TIME_DISPLAY FROM booking b, schedule s WHERE b.FLIGHT_NUMBER = s.FLIGHT_NUMBER AND b.DEPART_TIME = s.DEPART_TIME AND b.ID = '".$_POST['id']."'";
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT); 
		if ($bookingData = oci_fetch_array($stid)) {	
		} else {
			header("location: user_manage_booking.php");
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

    <title>SB Airline Ticketing Agency - View Booking Details</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="user.css" rel="stylesheet">
	<script src="user.js"></script>

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
      <nav class="navbar navbar-default navbar-blue ">
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
            <ul class="nav navbar-nav  navbar-blue">
              <li><a href="user_index.php">Home</a></li>
              <li><a href="user_search.php">Search</a></li>
			  <li class="active"><a href="#">Manage Booking</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-blue">
			  <li><a href="user_login.php">Login</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
		<div id = "booking-view-details" class = "collapse in" data-toggle = "false" >
			<div class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
				<div class = "pull-right">
					<button type="submit" class="btn btn-primary" onclick = "return handleEditBooking()">Edit Contact Details</button>
					<a href="user_index.php"><button type="submit" class="btn btn-primary">Exit</button></a>
					<br/><br/><br/>
				</div>	
			</div>
			<table class="table table-striped table-hover table-bordered">
				<tbody>
					<tr class="info"><th>Booking Id </th><td><?php echo $POST_['ID']; ?></td></tr>
					<tr><th>Flight Number </th><td><?php echo $bookingData['FLIGHT_NUMBER']; ?></td></tr>
					<tr><th>Departure Time </th><td><?php echo $bookingData['DEPART_TIME_DISPLAY']; ?></td></tr>
					<tr><th>Arrival Time </th><td><?php echo $bookingData['ARRIVAL_TIME_DISPLAY']; ?></td></tr>
					<tr><th>Contact Person </th><td><?php echo $bookingData['C_PERSON']; ?></td></tr>
					<tr><th>Contact Number </th><td><?php echo $bookingData['C_NUMBER']; ?></td></tr>
					<tr><th>Contact Email </th><td><?php echo $bookingData['C_EMAIL']; ?></td></tr>
				</tbody>
			</table>	
			<br/>

			<?php
				// retrieve the passengers for this booking
				$sql = "SELECT p.* FROM passenger p, booking_passenger bp WHERE p.PASSPORT_NUMBER = bp.PASSENGER AND bp.BOOKING_ID = '".$bookingData['ID']."'";
				$stid = oci_parse($dbh, $sql);
				oci_execute($stid, OCI_DEFAULT);

				$index = 1;
				while($row = oci_fetch_array($stid)) {
					echo '<table class="table table-striped table-hover table-bordered"><tbody>';
					// put a checkbox and if the box is tick, delete this passenger from this booking	
					echo '<tr class="info"><th rowspan=\"1\">Passenger '.$index.'</th></tr>';
					echo '<tr><th>Passport Number </th><td>'.$row['PASSPORT_NUMBER'].'</td></tr>';
					echo '<tr><th>Title </th><td>'.$row['TITLE'].'</td></tr>';
					echo '<tr><th>Fisrt Name </th><td>'.$row['FIRST_NAME'].'</td></tr>';
					echo '<tr><th>Last Name </th><td>'.$row['LAST_NAME'].'</td></tr>';
					$index++;		
				}
				echo '</tbody></table></br>';
			?>
		</div>
		
		<div id = "edit-booking-details" class = "collapse" data-toggle = "false" >
			<form id = "edit-booking-form" class="form-horizontal"  action="user_manage_booking_details.php" method = "post"> 	
				<div class="form-group">
					<label class="control-label col-xs-3">Booking Id</label>
					<div class="col-xs-9">		
						<input id = "booking-id" type="text" class="form-control" name = "id" value = "<?php echo $bookingData['ID']; ?>" required autofocus="" disabled>
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Email</label>
					<div class="col-xs-9">		
						<input id = "booking-email" type="text" class="form-control" placeholder="Email address" value = "<?php echo $bookingData['C_EMAIL']; ?>" required autofocus="">
						<p id = "bookingEmailError" class = "collapse text-danger"  data-toggle="false">Invalid email format</p>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Name</label>
					<div class="col-xs-9">		
						<input id = "booking-name" type="text" class="form-control" placeholder="Contact Name" value = "<?php echo $bookingData['C_PERSON']; ?>" required autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<label class="control-label col-xs-3">Contact Number</label>
					<div class="col-xs-9">		
						<input id = "booking-number" type="number" class="form-control" placeholder="Contact Number" value = "<?php echo $bookingData['C_NUMBER']; ?>" required autofocus="">
					</div>
				</div>					
				<div class="form-group">
					<div id = "booking-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-primary" onclick = "return editBookingContactDetails()">Edit Booking</button>
					</div>
				</div>			
			</form>
			<div id = "edit-booking-error-result"  class = "collapse text-danger"   data-toggle="false">
				<p id = "edit-booking-error-msg"></p>
			</div>
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