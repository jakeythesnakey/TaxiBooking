<?php
	ini_set('display_errors', true);
	error_reporting(E_ALL);

	require_once ("taxidbmanager.php");//Path to Database Manager

	//set posted variables to local
	$bookingNumber = $_POST['bookingNumber'];
	
	echo AssignTaxi($bookingNumber);//ask database manger to find bookings within timetable
?>
