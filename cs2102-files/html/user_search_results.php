<?php session_start(); ?>
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
  <script type="text/javascript" src="user.js"></script>


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
        <div class="jumbotron"><h3>
          <?php 
          echo 'Displaying Search Results for: <b>' .
          $_GET['origin'] .'</b> to <b>' . 
          $_GET['destination'] .  '</b> on <b>' . 
          $_GET['departure_date'] . '</b> for '.$_GET['adult']. 
          ' adult and '. $_GET['child']. ' child';
          ?>

        </h3>
        <div id="tableDis" class="collapse" data-toggle="false">
          <p class="info">Select your flight below!</p>
          <table id="resultTable" class="table table-striped table-hover">
           <thead>
            <th>#</th>
            <th>Flight Number</th>
            <th>Departure Time</th>
            <th>Arrival Time</th>
            <th>Price</th>
            <th>Duration</th>
            <th></th>
          </thead>
          <tbody></tbody>
        </table>

      </div>
      <div id="no_existing_flights" class="collapse" data-toggle="false">
        <p class='bg-info'> There are no available flights on this date </p>
      </div>
    </div>


    <script type="text/javascript">
//use jquery assign each SELECT button by ID value

window.onload = function() {
 makeAjaxRequest();
};

function createButtonLink(index) {
  window.location= "user_passengers.php?flight_no="+$('#fNumBook'+index).text()+"&departure_date="+$('#departTimeBook'+index).text()+"";
}
function makeAjaxRequest() {

  var originStr = '<?php echo $_GET['origin']; ?>';
  var destinationStr =  '<?php echo $_GET['destination']; ?>';
  var departure_dateStr =  '<?php echo $_GET['departure_date']; ?>';
  var numAdultsStr =  '<?php echo $_GET['adult']; ?>';
  var numChildsStr =  '<?php echo $_GET['child']; ?>';
  //above variables work!

  $.ajax({
    url: 'user_func_searchFlightSchedule.php',
    type: 'get',
    data: {origin: originStr,destination: destinationStr,departure_date: departure_dateStr, numAdults: numAdultsStr, numChilds: numChildsStr},
    success: function(response) {

      if(response=='no_existing_flights')
      { 
        $('#no_existing_flights').collapse('show');
      }
      else{
        $('table#resultTable tbody').html(response);
        $('#tableDis').collapse('show');

        var select_flight_no;
        var select_departure_date;

            //  $('#button'+(i+1)).click(function() {
          //window.location = "user_passengers.php?flight_no="+select_flight_no+"&departure_date="+select_departure_date;

             
          } //close else call
         
        } //close success call
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