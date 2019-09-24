<?php
	ini_set('display_errors', true);
	error_reporting(E_ALL);

	require_once ("taxidbmanager.php");//Path to Database Manager
	//set posted variables to local
	$timeScale = $_POST['timeScale'];
	
	echo getBookings($timeScale);//call database manager to get bookings in given timescale
?>
