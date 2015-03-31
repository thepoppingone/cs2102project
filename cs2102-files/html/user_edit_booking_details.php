<?php

	// if there is no details posted, go back to the edit panel

	 	 require("config.php");  
	 $sql = "";

	  	$sql = "SELECT b.*, TO_CHAR(b.DEPART_TIME, 'DD MON YYYY HH24:MI') AS DEPART_TIME_DISPLAY FROM booking b WHERE b.ID = '".$_POST['bookingID']."'";
	 if(!empty($sql)) {
	  $stid = oci_parse($dbh, $sql);
	  oci_execute($stid, OCI_DEFAULT);
	  $row = oci_fetch_array($stid);
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
	      <li><a href="user_retrieve_booking.php">Retrieve Booking</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-blue">
			  <li class="active"><a href="#">Login</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">		

				
	  
		<!-- edit booking stuffs -->
		<!-- div box for booking -->
		<div id = "booking"  >
			<form id = "user-edit-booking-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Booking Id</label>
					<div class="col-xs-9">		
						<input id = "booking-id" type="text" class="form-control" value = "<?php echo $row['ID']; ?>" disabled>
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
						<p id = "bookingEmailError" class = "collapse text-danger"  data-toggle="false"></p>
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
					<div id = "schedule-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
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
			<a href = "user_retrieve_booking.php"><button class="btn btn-primary">Edit another record</button></a>
		</div>	

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
