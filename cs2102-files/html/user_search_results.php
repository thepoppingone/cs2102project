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
<?php

/*  
if(!empty($_GET)){
  
  // check login credentials for admin
  $origin = $_GET['origin'];
  $destination = $_GET['destination'];
  
  date_default_timezone_set('Asia/Singapore'); 
  
  $departure_date = date("Y-m-d", strtotime ($_GET['departure_date'])); // format: yyyy-mm-dd
  $today_date = date('Y-m-d');
  
  if($departure_date < $today_date) {
    echo "departure_date is no longer valid";
  } else {
  
    require("config.php");
    
    // carry out sql command
    $sql = "SELECT * FROM schedule s, flight f 
        WHERE s.depart_time >= TO_TIMESTAMP('".$departure_date."', 'YYYY-MM-DD')
        AND f.origin LIKE '%".$origin."%'
        AND f.destination LIKE '%".$destination."%' 
        AND f.f_number = s.flight_number 
        AND f.designator = s.designator";

    $stid = oci_parse($dbh, $sql);

    // without OCI_DEFAULT any changes to the database will be instantly viewable by all other connecgtions
    oci_execute($stid, OCI_DEFAULT); 

     if(empty($rows)) {
    echo "<tr>";
      echo "<td colspan='4'>There were not records</td>";
    echo "</tr>";
  }
  else {
    foreach ($rows as $row) {
      echo "<tr>";
        echo "<td>".$row['employee_id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['telephone']."</td>";
      echo "</tr>";
    }
  }

    while ($row = oci_fetch_array($stid)) 
    {
      echo $row[0];
    }
    
    echo "end of file";
    

    // to free up the resources
    oci_free_statement($stid);
  }
  
}*/
?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <?php 
        echo 'Search Results for: <b id="origin">' . $_GET['origin'] . '</b> to <b id="destination">' . $_GET['destination'] . '</b> on <b id="departure_date">' . $_GET['departure_date'] . '</b>';
        ?>
  <table id="resultTable" class="table table-striped table-hover">
             <thead>
                            <th>Designator</th>
                            <th>Flight Number</th>
                            <th>Departure Time</th>
                            <th>Price</th>
                            
                        </thead>
                        <tbody></tbody>
                    </table>
    
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




    window.onload = function() {
 makeAjaxRequest();
};
 /*   
$("#test").click(function(){
          alert("fuck you");
        });

$('#btnSearch').click(function(){
           alert("The paragraph was clicked.");
          makeAjaxRequest();
          });
*/
  function makeAjaxRequest() {

  var originStr = getUrlVars()["origin"];
  var destinationStr = getUrlVars()["destination"];
  var departure_dateStr = getUrlVars()["departure_date"];

    $.ajax({
        url: 'user_searchFlightSchedule.php',
        type: 'get',
        data: {origin: originStr,destination: destinationStr,departure_date: departure_dateStr},
        success: function(response) {
            $('table#resultTable tbody').html(response);
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