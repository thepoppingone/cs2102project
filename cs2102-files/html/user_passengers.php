<?php
session_start();
$_SESSION['flight_no'] = $_GET['flight_no'];
$_SESSION['departure_date'] = $_GET['departure_date'];
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
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-blue">
        <li><a href="user_login.php">Login</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>


      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        
 <label class="lead control-label col-sm-9"><strong>Passenger Details:</strong></label>
<br/>

<!-- Form Name -->
<label style="margin:5px"class="lead control-label col-sm-6">Passenger 1: Adult</label>
<!-- Select Basic -->
<table class="table">
  <tr>
  <form class="form-inline" action="user_confirmation&payment.php" method="post">
  <td id="passenger_title_box">
  <label for="passenger_title">Title</label>
    <select id="passenger_title" name="passenger_title" class="form-control input-sm">
      <option>Mr.</option>
      <option>Mrs.</option>
      <option>Miss</option>
    </select>
  </td>
    <td id="passenger_first_name_box">
  <label for="passenger_first_name">First Name (Given)</label>
    <input id="passenger_first_name" name="passenger_first_name" type="text" placeholder="Enter passenger first name" class="form-control input-sm" required="">
  </td>
    <td id="passenger_last_name_box">
  <!--  <p class="help-block">Enter your first name</p> -->
  <label for="passenger_last_name">Last Name (Surname)</label>
    <input id="passenger_last_name" name="passenger_last_name" type="text" placeholder="Enter passenger last name" class="form-control input-sm" required="">
  </td>
  <td id="passenger_DOB_box">
     <label for="passenger_DOB">Date of Birth: </label>
      <input id = "passenger_DOB" type = "date" name = "DOB" class="form-control input-sm" placeholder = "DD/MM/YYYY" required>
  </td>
  <tr>
  <td id="passenger_passport_no_box">
     <label for="passenger_passport_no">Passport No:</label>
    <input id="passenger_passport_no" name="passenger_passport_no" type="text" placeholder="Enter your passport number" class="form-control input-sm" required="">
  </td>
  <td id="passenger_email_box">
     <label for="passenger_email">Email:</label>
    <input id="passenger_email" name="passenger_email" type="text" placeholder="Enter your email" class="form-control input-sm" required="">
  </td>
  <td id="passenger_contact_box">
     <label for="passenger_contact">Contact No:</label>
    <input id="passenger_contact" name="passenger_contact" type="text" placeholder="Enter your contact no." class="form-control input-sm" required="">
  </td>
   <td id="passenger_booker_box">
     <label for="passenger_booker">Booker Name:</label>
    <input id="passenger_booker" name="passenger_booker" type="text" placeholder="Enter your name" class="form-control input-sm" required="">
  </td>
</tr>
  <tr><td>
  <button class="btn btn-primary" type="submit">Submit</button>
</td></tr>
</form>
</table>


testing sessions variable
<?php
echo "<br/>".$_GET['flight_no']."  ".$_GET['departure_date']."<br/>";
echo "<br/> Num of adults: ". $_SESSION['adult']."<br/>";
echo "Num of children: ". $_SESSION['child']."<br/>";
?>

    </div>

    <script type="text/javascript">

// Read a page's GET URL variables and return them as an associative array.

// the above function is to make it easy to retrieve values from GET


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