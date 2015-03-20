<?php 
	session_start();
    unset($_SESSION['admin']);
    header("location: user_index.php");
?>