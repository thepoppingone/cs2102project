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
              <li class="active"><a href="#">Search</a></li>
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
  <form class="form-inline">
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
    <input id="passenger_first_name" name="passenger_first_name" type="text" placeholder="Enter your first name" class="form-control input-sm" required="">
  </td>
    <td id="passenger_last_name_box">
  <!--  <p class="help-block">Enter your first name</p> -->
  <label for="passenger_last_name">Last Name (Surname)</label>
    <input id="passenger_last_name" name="passenger_last_name" type="text" placeholder="Enter your last name" class="form-control input-sm" required="">
  </td>
  <td id="passenger_DOB_box">
     <label for="passenger_DOB_booking">Date of Birth: </label>
      <input id = "passenger_DOB" type = "date" name = "DOB" class="form-control input-sm" placeholder = "DD/MM/YYYY" required>
  </td>
  <tr><td>
  <button class="btn btn-primary" type="submit">Submit</button>
</td></tr>
</form>
</table>


    </div>
 

    <script type="text/javascript">

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
// the above function is to make it easy to retrieve values from GET

    window.onload = function() {
 makeAjaxRequest();
};
  function makeAjaxRequest() {

  var originStr = getUrlVars()["origin"];
  var destinationStr = getUrlVars()["destination"];
  var departure_dateStr = getUrlVars()["departure_date"];

    $.ajax({
        url: 'user_searchFlightSchedule.php',
        type: 'get',
        data: {origin: originStr,destination: destinationStr,departure_date: departure_dateStr},
        success: function(response) {
          
            if(response=='no_existing_flights')
            { 
              $('#no_existing_flights').collapse('show');
            }
            else{
            $('table#resultTable tbody').html(response);
            $('#tableDis').collapse('show');
          } //close else call
          //close success call
        }
    });
  }

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