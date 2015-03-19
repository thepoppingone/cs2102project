<?php
session_start();
if(empty($_SESSION['admin'])) {
	header("location: user_login.php");
}

// if there is no details posted, go back to the edit panel
if(empty($_POST['selected'])) {
	header("location: admin_panel_edit.php");
} else {
	
	require("config.php");		
	$sql = "";
	if($_POST['selected'] == "airport") {
		$sql = "SELECT * FROM airport a WHERE a.designator = '".$_POST['designator']."'";
	} else {
	}
	if(!empty($sql)) {
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid, OCI_DEFAULT);
		$row = oci_fetch_array($stid);
	}
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

    <title>Edit</title>

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
              <li class="active"><a href="admin_panel_edit.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
              <li><a href="admin_panel_search.php"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="user_logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
	  
		<?php 
		
		if($_POST['selected'] == "airport") {
			

			// to keep track of primary key original values, put it as input name
			echo '
				<!-- div box for airport -->
				<div id = "airport" >
					<form id = "edit-airport-form" class="form-horizontal"> 
						<div class="form-group">
							<label class="control-label col-xs-3">Name</label>
							<div class="col-xs-9">		
								<input id = "airport-name" type="text" class="form-control" placeholder="Name" required autofocus="" value = "'.$row['NAME'].'">
							</div>
						</div>			
						<div class="form-group">
							<label for="inputDesignator" class="control-label col-xs-3" >Designator</label>
							<div class="col-xs-9">		
								<input id = "airport-designator" type="designator" id="inputDesignator" class="form-control" placeholder="Designator"  required autofocus="" name = "'.$row['DESIGNATOR'].'" value = "'.$row['DESIGNATOR'].'">
								<p id = "airportDesignatorError" class = "collapse" class="text-danger" data-toggle="false">Oops! The airport with this designator already exists.</p>
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-xs-3">Location</label>
							<div class="col-xs-9">
								<input id = "airport-location" class="form-control" placeholder="Location"  required autofocus="" value = "'.$row['LOCATION'].'">
							</div>
						</div>
						<div class="form-group">
							<div id = "airport-button"  class="col-xs-offset-3 col-xs-9 collapse in " data-toggle="false">
								<button type="reset" class="btn btn-primary">Reset</button>
								<button type="submit" class="btn btn-primary" onclick = "return handleEditAirport()">Edit Airport</button>
							</div>
						</div>
					</form>
					<div id = "edit-airport-error-result" class = "collapse" data-toggle="false">
						<p id = "edit-airport-error-msg"></p>
					</div>
				</div>
				<!-- end for airport stuffs -->
				';
		}		
		?>
		
		<div id = "edit-successful-result" class ="col-xs-offset-3 collapse" data-toggle="false" >
			<p id = "edit-successful-msg" class = "alert alert-success" role = "alert"></p>
			<a href = "admin_panel_edit.php"><button class="btn btn-primary">Edit another record</button></a>
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
