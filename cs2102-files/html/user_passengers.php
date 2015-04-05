<?php
session_start();
$_SESSION['flight_no'] = $_GET['flight_no'];
$_SESSION['departure_date'] = $_GET['departure_date'];
$_SESSION['price'] = $_GET['price'];
//stores the choices that the user has made.
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
			    <li><a href="user_manage_booking.php">Manage Booking</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right navbar-blue">
                <li><a href="user_login.php">Login</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div><!--/.container-fluid -->
        </nav>

        <!-- Main component for a primary marketing message or call to action -->

        <label class="lead"><strong>Fill in Passenger Details Below:</strong></label> 
        <div class="jumbotron">


          <!-- 
            The following 4 dividends will be hidden by default and will be only shown when the 
            number of adults is determined and number of divs shown will correspond to the number of adults
          --> 

          <form action="user_confirmation&payment.php" method="post">
          <div id="passenger_email_box1" class="form-group">
            <label for="passenger_email1">Contact Email:</label>
            <input id="passenger_email1" name="passenger_email1" type="text" placeholder="Enter your email" class="form-control input-sm" required="">
          </div><!-- end of passenger passport no.-->
           <div id="passenger_contact_box1" class="form-group">
            <label for="passenger_contact1">Contact No:</label>
            <input id="passenger_contact1" name="passenger_contact1" type="text" placeholder="Enter your contact no." class="form-control input-sm" required="">
          </div><!-- end of passenger passport no.-->

          <div id="passenger_booker_box1" class="form-group">
            <label for="passenger_booker1">Contact Name:</label>
            <input id="passenger_booker1" name="passenger_booker1" type="text" placeholder="Enter your name" class="form-control input-sm" required="">
          </div><!-- end of passenger passport no.-->

            <div class='collapse' data-toggle='false' id='passenger1'>
              <label><h4> Passenger 1</h4> </label>
              <div id="passenger_title_box1" class="form-group">
               <label for="passenger_title1">Title</label>
               <select id="passenger_title1" name="passenger_title1" class="form-control input-sm">
                <option>Mr.</option>
                <option>Mrs.</option>
                <option>Miss</option>
              </select>
            </div><!-- end of title -->

            <div id="passenger_first_name_box1" class="form-group">
              <label for="passenger_first_name1">First Name (Given)</label>
              <input id="passenger_first_name1" name="passenger_first_name1" type="text" placeholder="Enter passenger first name" class="form-control input-sm" required="">
            </div><!-- end of passenger first name -->

            <div id="passenger_last_name_box1" class="form-group">
              <label for="passenger_last_name1">Last Name (Surname)</label>
              <input id="passenger_last_name1" name="passenger_last_name1" type="text" placeholder="Enter passenger last name" class="form-control input-sm" required="">
            </div><!-- end of passenger last name -->

            <div id="passenger_passport_no_box1" class="form-group">
             <label for="passenger_passport_no1">Passport No:</label>
             <input id="passenger_passport_no1" name="passenger_passport_no1" type="text" placeholder="Enter your passport number" class="form-control input-sm" required="">
           </div><!-- end of passenger passport no.-->

          <hr style="border-top-color: rgba(0, 0, 0, 0.24)" class="divider">
        </div> <!-- end of passenger1 -->

        <div class='collapse' data-toggle='false' id='passenger2'>
          <label><h4> Passenger 2</h4> </label>
          <div id="passenger_title_box2" class="form-group">
           <label for="passenger_title2">Title</label>
           <select id="passenger_title2" name="passenger_title2" class="form-control input-sm">
            <option>Mr.</option>
            <option>Mrs.</option>
            <option>Miss</option>
          </select>
        </div><!-- end of title -->

        <div id="passenger_first_name_box2" class="form-group">
          <label for="passenger_first_name2">First Name (Given)</label>
          <input id="passenger_first_name2" name="passenger_first_name2" type="text" placeholder="Enter passenger first name" class="form-control input-sm" >
        </div><!-- end of passenger first name -->

        <div id="passenger_last_name_box2" class="form-group">
          <label for="passenger_last_name2">Last Name (Surname)</label>
          <input id="passenger_last_name2" name="passenger_last_name2" type="text" placeholder="Enter passenger last name" class="form-control input-sm" >
        </div><!-- end of passenger last name -->

        <div id="passenger_passport_no_box2" class="form-group">
         <label for="passenger_passport_no2">Passport No:</label>
         <input id="passenger_passport_no2" name="passenger_passport_no2" type="text" placeholder="Enter your passport number" class="form-control input-sm">
       </div><!-- end of passenger passport no.-->

      <hr style="border-top-color: rgba(0, 0, 0, 0.24)" class="divider">  
    </div> <!-- end of passenger2 -->


    <div class='collapse' data-toggle='false' id='passenger3'>
      <label><h4> Passenger 3</h4> </label>
      <div id="passenger_title_box3" class="form-group">
       <label for="passenger_title3">Title</label>
       <select id="passenger_title3" name="passenger_title3" class="form-control input-sm">
        <option>Mr.</option>
        <option>Mrs.</option>
        <option>Miss</option>
      </select>
    </div><!-- end of title -->

    <div id="passenger_first_name_box3" class="form-group">
      <label for="passenger_first_name3">First Name (Given)</label>
      <input id="passenger_first_name3" name="passenger_first_name3" type="text" placeholder="Enter passenger first name" class="form-control input-sm" >
    </div><!-- end of passenger first name -->

    <div id="passenger_last_name_box3" class="form-group">
      <label for="passenger_last_name3">Last Name (Surname)</label>
      <input id="passenger_last_name3" name="passenger_last_name3" type="text" placeholder="Enter passenger last name" class="form-control input-sm" >
    </div><!-- end of passenger last name -->

    <div id="passenger_passport_no_box3" class="form-group">
     <label for="passenger_passport_no3">Passport No:</label>
     <input id="passenger_passport_no3" name="passenger_passport_no3" type="text" placeholder="Enter your passport number" class="form-control input-sm">
   </div><!-- end of passenger passport no.-->


  <hr style="border-top-color: rgba(0, 0, 0, 0.24)" class="divider">
</div> <!-- end of passenger3 -->


<div class='collapse' data-toggle='false' id='passenger4'>
  <label><h4> Passenger 4</h4> </label>
  <div id="passenger_title_box4" class="form-group">
   <label for="passenger_title4">Title</label>
   <select id="passenger_title4" name="passenger_title4" class="form-control input-sm">
    <option>Mr.</option>
    <option>Mrs.</option>
    <option>Miss</option>
  </select>
</div><!-- end of title -->
<div id="passenger_first_name_box4" class="form-group">
  <label for="passenger_first_name4">First Name (Given)</label>
  <input id="passenger_first_name4" name="passenger_first_name4" type="text" placeholder="Enter passenger first name" class="form-control input-sm" >
</div><!-- end of passenger first name -->

<div id="passenger_last_name_box4" class="form-group">
  <label for="passenger_last_name4">Last Name (Surname)</label>
  <input id="passenger_last_name4" name="passenger_last_name4" type="text" placeholder="Enter passenger last name" class="form-control input-sm" >
</div><!-- end of passenger last name -->

<div id="passenger_passport_no_box4" class="form-group">
 <label for="passenger_passport_no4">Passport No:</label>
 <input id="passenger_passport_no4" name="passenger_passport_no4" type="text" placeholder="Enter your passport number" class="form-control input-sm">
</div><!-- end of passenger passport no.-->

</div> <!-- end of passenger4 -->

<button type="submit" class="btn btn-default">Submit</button>


</form>


</div>

<?php
echo "<br/>".$_GET['flight_no']."  ".$_GET['departure_date']."<br/>";
echo "<br/> Num of adults: ". $_SESSION['adult']."<br/>";

$priceInt = (int) substr($_SESSION['price'],1);
$numOfPassengersInt = (int) $_SESSION['adult'];
$totalPrice = $priceInt * $numOfPassengersInt;
echo "Total Price: $". $totalPrice."<br/>";
$_SESSION['price']= $totalPrice;
?>

<script type="text/javascript">
window.onload = function(){

  var numOfPassengersStr = <?php echo $_SESSION['adult']; ?> ;
  var numOfPassengers = parseInt(numOfPassengersStr);

  for(i=0;i<numOfPassengers; i++)
  {
    $('#passenger'+(i+1)).collapse('show');
    if(i>0)
    {
      $('#passenger_first_name'+(i+1)).prop("required",true);
      $('#passenger_last_name'+(i+1)).prop("required",true);
      $('#passenger_DOB'+(i+1)).prop("required",true);
      $('#passenger_passport_no'+(i+1)).prop("required",true);
      $('#passenger_email'+(i+1)).prop("required",true);
      $('#passenger_contact'+(i+1)).prop("required",true);
      $('#passenger_booker'+(i+1)).prop("required",true);
    }
  }

};//close onload

</script>

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