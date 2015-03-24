<?php
session_start();
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

  <title>SB Airline Ticketing Agency Search</title>

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
                <li class="active"><a href="user_search.php">Search</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right navbar-blue">
                <li><a href="user_login.php">Login</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div><!--/.container-fluid -->
        </nav>


        <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron">

         <label class="lead control-label col-sm-9"><strong>Passenger 1 Details:</strong></label>
         <br/> <!--some how the CSS needs to be put in reverse order-->
         <div class="row">
          <div id='p_title' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_title']?></div>
          <div class="col-md-3 col-md-pull-9">Title:</div>
        </div>
        <div class="row">
          <div id='p_first_name' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_first_name']?></div>
          <div class="col-md-3 col-md-pull-9">First Name:</div>
        </div>
        <div class="row">
          <div id='p_last_name' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_last_name']?></div>
          <div class="col-md-3 col-md-pull-9">Last Name:</div>
        </div>
        <div class="row">
          <div id='p_dob' class="col-md-9 col-md-push-3"><?php echo $_POST['DOB']?></div>
          <div class="col-md-3 col-md-pull-9">DOB:</div>
        </div>
        <div class="row">
          <div id='p_passport_no' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_passport_no']?></div>
          <div class="col-md-3 col-md-pull-9">Passport No.:</div>
        </div>
        <div class="row">
          <div id='p_email' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_email']?></div>
          <div class="col-md-3 col-md-pull-9">Email Address:</div>
        </div>
        <div class="row">
          <div id='p_contact' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_contact']?></div>
          <div class="col-md-3 col-md-pull-9">Contact No.:</div>
        </div><div class="row">
        <div id='p_booker' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_booker']?></div>
        <div class="col-md-3 col-md-pull-9">Booker name:</div>
      </div>
    </br>
    <label class="lead control-label col-sm-9">Flight Details:</label>
    <div class="row">
      <div id='p_flight_no' class="col-md-9 col-md-push-3"><?php echo $_SESSION['flight_no'] ?></div>
      <div class="col-md-3 col-md-pull-9">Flight No.:</div>
    </div>
    <div class="row">
      <div id='p_departure_date' class="col-md-9 col-md-push-3"><?php echo $_SESSION['departure_date'] ?></div>
      <div class="col-md-3 col-md-pull-9">Departure Time & Date:</div>
    </div>
    <br/>
    <button id='confirmBooking' class="btn btn-primary" data-toggle="modal" data-target="#loadingModal" type="submit">Confirm Booking</button>

    <div class="modal fade" id="loadingModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Please hold on while the booking is being made...</h4>
          </div>
          <div align="center" class="modal-body">
            <img class='img-responsive' src='../../assets/img/loading1.gif'></img>
          </div>
          <div id='phpReply' class="modal-footer">

          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal-->

    <script type="text/javascript">
//important for window onload 
//in order to ensure the functions all run when page is done loading
window.onload = function() {
  $('#confirmBooking').click(function() {

    //passenger details variables
    var titleStr = $('#p_title').text();
    var firstNameStr = $('#p_first_name').text();
    var lastNameStr = $('#p_last_name').text();
    var dobStr = $('#p_dob').text();
    var passportNoStr = $('#p_passport_no').text();
    var emailStr = $('#p_email').text();
    var contactStr = $('#p_contact').text();
    var bookerStr = $('#p_booker').text();

    //flight details variable
    var flightNoStr = $('#p_flight_no').text();
    var departure_dateStr = $('#p_departure_date').text();

    $.ajax({
      url: 'user_func_insert_booking.php',
      type: 'post',
      data: {title: titleStr, firstName: firstNameStr, lastName: lastNameStr, dob: dobStr, passportNo: passportNoStr, 
       email: emailStr, contact: contactStr, booker: bookerStr, flightNo: flightNoStr , departure_date: departure_dateStr,},
      success: function(response) {
        $('#phpReply').html(response);

  } //close success call

}); //close ajax

  
  }); //close click
}; //close onload
</script>

</div><!-- /jumbotron -->



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