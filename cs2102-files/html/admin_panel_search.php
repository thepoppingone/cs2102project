<?php
session_start();
if(empty($_SESSION['admin'])) {
	header("location: user_login.php");
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

    <title>Search - Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="admin.css" rel="stylesheet">
	<script src="admin.js"></script>

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
      <nav class="navbar navbar-default">
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
            <ul class="nav navbar-nav">
              <li><a href="admin_panel.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
              <li><a href="admin_panel_add.php"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
              <li><a href="admin_panel_delete.php"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
              <li><a href="admin_panel_edit.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
              <li class="active"><a href="#"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="user_logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <!-- drop down bar for selecting category-->
		<form name = "admin_search_panel_form" class="form-horizontal collapse in" id = "category-form" data-toggle="false">
			<div class="form-group">
				<label class="control-label col-xs-3">Category </label>
				<div class="col-xs-9">
					<select id="search-category" class = "form-control input-sm"  onchange = "searchCategoryChange()" required>
						<option selected = "true" disabled>Select category</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="administrator">Administrator</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="member">Passenger</option>
						<option value="reservation">Reservation</option>
						<option class="select-dash" disabled="disabled">----</option>
						<option value="airport">Airport</option>
						<option value="flight">Flight</option>
						<option value="schedule">Flight Schedule</option>
					</select>
				</div>
			</div>
		</form>
		
		<!-- div box for adminstrator search fields -->
		<div id = "administrator" class = "collapse" data-toggle="false">
			<form id = "search-admin-form" class="form-horizontal"> 
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "admin-name" type="text" class="form-control" placeholder="Name"  autofocus="">
					</div>
				</div>			
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-3">Email Address</label>
					<div class="col-xs-9">		
						<input id = "admin-email" type="email" id="inputEmail" class="form-control" placeholder="Email address"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Password</label>
					<div class="col-xs-9">
						<input id = "admin-pwd" class="form-control" placeholder="Password"  autofocus="">
					</div>
				</div>
				<div class="form-group">
					<div id = "admin-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleSearchAdmin()">Search Administrator</button>
					</div>
				</div>
			</form>
		</div>
		<!-- end for adminstrator-->
		
		
		<!-- div box for airport search fields -->
		<div id = "airport" class = "collapse" data-toggle="false">
			<form id = "search-airport-form" class="form-horizontal"> 				
				<div class="form-group">
					<label class="control-label col-xs-3">Name</label>
					<div class="col-xs-9">		
						<input id = "airport-name" type="text" class="form-control" placeholder="Airport Name"  autofocus="">
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-xs-3">Location</label>
					<div class="col-xs-9">		
						<input id = "airport-location" type="text" class="form-control" placeholder="Airport Location"  autofocus="">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-xs-3">Designator</label>
					<div class="col-xs-9">		
						<input id = "airport-designator" type="text" class="form-control" placeholder="Airport Designator"  autofocus="">
					</div>
				</div>
				<div class="form-group">
					<div id = "airport-button"  class="col-xs-offset-3 col-xs-9 collapse in" data-toggle="false">
						<button type="submit" class="btn btn-primary" onclick = "return handleSearchAirport()">Search Airport</button>
					</div>
				</div>
			</form>
		</div>
		<!-- end for airport -->			

		<!-- search results div box -->
		<div id = "search-results" class = "collapse" data-toggle="false">
		</div>
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
