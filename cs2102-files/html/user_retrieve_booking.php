<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>SB Airline Ticketing Agency Login</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="user.css" rel="stylesheet">

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
      <div class="jumbotron" id="booking-box">
		  <form class="form-signin" action="user_validate_retrieve_booking_inputs.php" method="post">
			<h2 class="form-signin-heading">View Booking details</h2> <br/>
			
			<h3 label class="control-label col-xs-3">Booking ID</label></h3>
			<label for="inputBookingID" class="sr-only">BookingID</label>  
			<input name = "bookingid" type="id" id="inputbookingid" class="form-control input-lg" placeholder="Booking ID" required="" autofocus="">
			<br/>
			<h3 label class="control-label col-xs-3">Email</label></h3>
			<label for="inputEmail" class="sr-only">Email</label>
			<input name = "email" type="password" id="inputEmail" class="form-control input-lg" placeholder="Email of Contact Person" required="">
			<br/>
			<button class="btn btn-lg btn-primary btn-block" type="retrieve_booking">Retrieve My Booking</button>
			<br/>
		  </form>
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