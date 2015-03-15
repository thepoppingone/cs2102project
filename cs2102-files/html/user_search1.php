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
		<form name = "userSearchForm" class="form form-inline" method="get" onsubmit = "return validateUserSearchForm()">
			<select name="origin" class = "form-control input-sm"> <option value="">Select Origin</option>
			<?php
				require("config.php");
				$sql = "SELECT designator FROM airport";
				$stid = oci_parse($dbh, $sql);
				oci_execute($stid, OCI_DEFAULT);
				while($row = oci_fetch_array($stid)){
					echo "<option value=\"".$row["DESIGNATOR"]."\">".$row["DESIGNATOR"]."</option><br>";
				}
				oci_free_statement($stid);
			?>
			</select>
			<select  name="destination" class = "form-control input-sm"> <option value="">Select Destination</option>
			<?php
				require("config.php");
				$sql = "SELECT designator FROM airport";
				$stid = oci_parse($dbh, $sql);
				oci_execute($stid, OCI_DEFAULT);
				while($row = oci_fetch_array($stid)){
					echo "<option value=\"".$row["DESIGNATOR"]."\">".$row["DESIGNATOR"]."</option><br>";
				}
				oci_free_statement($stid);
			?>
			</select>
			<input id = "departure_date" type = "date" name = "departure_date" class="form-control  input-sm" placeholder = "DD/MM/YYYY">
			<button id="btnSearch" name="formSubmit" class="btn btn-sm btn-primary" type="submit">Search</button>
		
      <div id = "date-alert" class = "alert alert-info collapse" data-toggle="collapse"role="alert">
			  <span>
				<p>Oops! The planes have already departed for that date.</p>
			  </span>
			</div>
		</form>
      <button onclick="return testFunction()" id="test" class="btn btn-sm btn-primary">TEST ONLY</button>
    <script type="text/javascript">
 /*   
$("#test").click(function(){
          alert("fuck you");
        });

$('#btnSearch').click(function(){
           alert("The paragraph was clicked.");
          makeAjaxRequest();
          });
*/
function testFunction() {
  alert("PLEASE LAH!");
  return true;
}
/*
  function makeAjaxRequest() {
  
    $.ajax({
        url: 'user_searchFlightSchedule.php',
        type: 'get',
        data: {origin: $('select.origin').val(),destination: $('select.destination').val(),date: $('input#departure_date').val()},
        success: function(response) {
            $('table#resultTable tbody').html(response);
        }
    });
  }
*/

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