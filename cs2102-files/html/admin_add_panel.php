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

    <title>Add - Home Page</title>

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
              <li class="active"><a href="#"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
              <li><a href="admin_delete_panel.php"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
              <li><a href="admin_edit_panel.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
              <li><a href="admin_search_panel.php"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="user_logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
		<div class="dropdown">
		    <button id = "addCategoryBtn" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			Choose category to add to
			<span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu addCategoryMenu" role="menu" aria-labelledby="dropdownMenu1">
			<li role="presentation" class="dropdown-header">Account</li>
			<li role="presentation"><a role="menuitem" tabindex="1" href="#">Administrator</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Member</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation" class="dropdown-header">Member</li>
			<li role="presentation"><a role="menuitem" tabindex="4" href="#">Reservation</a></li>			
			<li role="presentation" class="divider"></li>
			<li role="presentation" class="dropdown-header">Aviation</li>
			<li role="presentation"><a role="menuitem" tabindex="2" href="#">Airline</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Aircraft</a></li>	
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Airport</a></li>			
			<li role="presentation" class="divider"></li>
			<li role="presentation" class="dropdown-header">Flight</li>
			<li role="presentation"><a role="menuitem" tabindex="3" href="#">Flight</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Flight Schedule</a></li>
		  </ul>
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
