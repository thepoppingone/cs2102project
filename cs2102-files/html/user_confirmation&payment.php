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
          <div class='collapse' data-toggle='false' id="passenger1">
           <label class="lead control-label col-sm-9"><strong>Passenger 1 Details:</strong></label>
           <br/> <!--some how the CSS needs to be put in reverse order-->
           <div class="row">
            <div id='p_title1' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_title1']?></div>
            <div class="col-md-3 col-md-pull-9">Title:</div>
          </div>
          <div class="row">
            <div id='p_first_name1' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_first_name1']?></div>
            <div class="col-md-3 col-md-pull-9">First Name:</div>
          </div>
          <div class="row">
            <div id='p_last_name1' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_last_name1']?></div>
            <div class="col-md-3 col-md-pull-9">Last Name:</div>
          </div>
          <div class="row">
            <div id='p_dob1' class="col-md-9 col-md-push-3"><?php echo $_POST['DOB1']?></div>
            <div class="col-md-3 col-md-pull-9">DOB:</div>
          </div>
          <div class="row">
            <div id='p_passport_no1' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_passport_no1']?></div>
            <div class="col-md-3 col-md-pull-9">Passport No.:</div>
          </div>
          <div class="row">
            <div id='p_email1' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_email1']?></div>
            <div class="col-md-3 col-md-pull-9">Email Address:</div>
          </div>
          <div class="row">
            <div id='p_contact1' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_contact1']?></div>
            <div class="col-md-3 col-md-pull-9">Contact No.:</div>
          </div><div class="row">
          <div id='p_booker1' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_booker1']?></div>
          <div class="col-md-3 col-md-pull-9">Booker name:</div>
        </div>
        <hr style="border-top-color: #EEEEEE" class="divider">
      </div> <!-- end of passenger1-->


      <div class='collapse' data-toggle='false' id="passenger2">
       <label class="lead control-label col-sm-9"><strong>Passenger 2 Details:</strong></label>
       <br/> <!--some how the CSS needs to be put in reverse order-->
       <div class="row">
        <div id='p_title2' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_title2']?></div>
        <div class="col-md-3 col-md-pull-9">Title:</div>
      </div>
      <div class="row">
        <div id='p_first_name2' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_first_name2']?></div>
        <div class="col-md-3 col-md-pull-9">First Name:</div>
      </div>
      <div class="row">
        <div id='p_last_name2' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_last_name2']?></div>
        <div class="col-md-3 col-md-pull-9">Last Name:</div>
      </div>
      <div class="row">
        <div id='p_dob2' class="col-md-9 col-md-push-3"><?php echo $_POST['DOB2']?></div>
        <div class="col-md-3 col-md-pull-9">DOB:</div>
      </div>
      <div class="row">
        <div id='p_passport_no2' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_passport_no2']?></div>
        <div class="col-md-3 col-md-pull-9">Passport No.:</div>
      </div>
      <div class="row">
        <div id='p_email2' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_email2']?></div>
        <div class="col-md-3 col-md-pull-9">Email Address:</div>
      </div>
      <div class="row">
        <div id='p_contact2' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_contact2']?></div>
        <div class="col-md-3 col-md-pull-9">Contact No.:</div>
      </div><div class="row">
      <div id='p_booker2' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_booker2']?></div>
      <div class="col-md-3 col-md-pull-9">Booker name:</div>
    </div>
    <hr class="divider">
  </div> <!-- end of passenger2-->


  <div class='collapse' data-toggle='false' id="passenger3">
   <label class="lead control-label col-sm-9"><strong>Passenger 3 Details:</strong></label>
   <br/> <!--some how the CSS needs to be put in reverse order-->
   <div class="row">
    <div id='p_title3' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_title3']?></div>
    <div class="col-md-3 col-md-pull-9">Title:</div>
  </div>
  <div class="row">
    <div id='p_first_name3' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_first_name3']?></div>
    <div class="col-md-3 col-md-pull-9">First Name:</div>
  </div>
  <div class="row">
    <div id='p_last_name3' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_last_name3']?></div>
    <div class="col-md-3 col-md-pull-9">Last Name:</div>
  </div>
  <div class="row">
    <div id='p_dob3' class="col-md-9 col-md-push-3"><?php echo $_POST['DOB3']?></div>
    <div class="col-md-3 col-md-pull-9">DOB:</div>
  </div>
  <div class="row">
    <div id='p_passport_no3' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_passport_no3']?></div>
    <div class="col-md-3 col-md-pull-9">Passport No.:</div>
  </div>
  <div class="row">
    <div id='p_email3' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_email3']?></div>
    <div class="col-md-3 col-md-pull-9">Email Address:</div>
  </div>
  <div class="row">
    <div id='p_contact3' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_contact3']?></div>
    <div class="col-md-3 col-md-pull-9">Contact No.:</div>
  </div><div class="row">
  <div id='p_booker3' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_booker3']?></div>
  <div class="col-md-3 col-md-pull-9">Booker name:</div>
</div>
<hr class="divider">
</div> <!-- end of passenger3-->


<div class='collapse' data-toggle='false' id="passenger4">
 <label class="lead control-label col-sm-9"><strong>Passenger 4 Details:</strong></label>
 <br/> <!--some how the CSS needs to be put in reverse order-->
 <div class="row">
  <div id='p_title4' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_title4']?></div>
  <div class="col-md-3 col-md-pull-9">Title:</div>
</div>
<div class="row">
  <div id='p_first_name4' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_first_name4']?></div>
  <div class="col-md-3 col-md-pull-9">First Name:</div>
</div>
<div class="row">
  <div id='p_last_name4' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_last_name4']?></div>
  <div class="col-md-3 col-md-pull-9">Last Name:</div>
</div>
<div class="row">
  <div id='p_dob4' class="col-md-9 col-md-push-3"><?php echo $_POST['DOB4']?></div>
  <div class="col-md-3 col-md-pull-9">DOB:</div>
</div>
<div class="row">
  <div id='p_passport_no4' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_passport_no4']?></div>
  <div class="col-md-3 col-md-pull-9">Passport No.:</div>
</div>
<div class="row">
  <div id='p_email4' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_email4']?></div>
  <div class="col-md-3 col-md-pull-9">Email Address:</div>
</div>
<div class="row">
  <div id='p_contact4' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_contact4']?></div>
  <div class="col-md-3 col-md-pull-9">Contact No.:</div>
</div><div class="row">
<div id='p_booker4' class="col-md-9 col-md-push-3"><?php echo $_POST['passenger_booker4']?></div>
<div class="col-md-3 col-md-pull-9">Booker name:</div>
</div>

</div> <!-- end of passenger4-->

<hr style="border-top-color: rgba(0, 0, 0, 0.24)" class="divider">

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

<div class="modal fade " data-keyboard = "false" data-backdrop = "static" id="loadingModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Please hold on while the booking is being made...</h4>
      </div>
      <div align="center" class="modal-body">
        <img id='bookingStatus' class='img-responsive' src='../../assets/img/loading1.gif'></img>
      </div>
      <div id='phpReply' class="modal-footer"></div>
      <div id='phpButton' class="modal-footer"></div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal-->

<script type="text/javascript">
//important for window onload 
//in order to ensure the functions all run when page is done loading
window.onload = function() {

  var numOfPassengersStr = <?php echo $_SESSION['adult']; ?> ;
  var numOfPassengers = parseInt(numOfPassengersStr);

for (i=0;i<numOfPassengers;i++)
    {
      $('#passenger'+(i+1)).collapse('show');
    }

  $('#confirmBooking').click(function() {

    for (i=0;i<numOfPassengers;i++)
    {
      $('#passenger'+(i+1)).collapse('show');
    //passenger details variables
    var titleStr = $('#p_title'+(i+1)).text();
    var firstNameStr = $('#p_first_name'+(i+1)).text();
    var lastNameStr = $('#p_last_name'+(i+1)).text();
    var dobStr = $('#p_dob'+(i+1)).text();
    var passportNoStr = $('#p_passport_no'+(i+1)).text();
    var emailStr = $('#p_email'+(i+1)).text();
    var contactStr = $('#p_contact'+(i+1)).text();
    var bookerStr = $('#p_booker'+(i+1)).text();

    //flight details variable
    var flightNoStr = $('#p_flight_no').text();
    var departure_dateStr = $('#p_departure_date').text();

    $.ajax({
      url: 'user_func_insert_booking.php',
      type: 'post',
      data: {title: titleStr, firstName: firstNameStr, lastName: lastNameStr, dob: dobStr, passportNo: passportNoStr, 
       email: emailStr, contact: contactStr, booker: bookerStr, flightNo: flightNoStr , departure_date: departure_dateStr,},
       success: function(response) {
        $('#phpReply').append(response);
        $('#bookingStatus').attr('src','../../assets/img/confirmed.png');

        $('#returnHome').click(function() {
          window.location= "user_index.php";
        });



  } //close success call

}); //close ajax



  } //close for loop
var btn = document.createElement("BUTTON");        // Create a <button> element
var t = document.createTextNode("Return to Home");       // Create a text node
btn.setAttribute("id","returnHome");
btn.setAttribute("class","btn btn-primary");
btn.appendChild(t);   
     $('#phpButton').append(btn);
      
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