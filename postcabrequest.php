
<?php
	ini_set('display_errors', true);
	error_reporting(E_ALL);

	require_once ("taxidbmanager.php");//Path to Database Manager				

	//set posted variables to local
	$custName = $_POST['custName'];

	$custNumber = $_POST['custNumber'];
	
	$address = $_POST['address'];
	
	$dateTime = $_POST['datetime'];
	
	NewBooking($custName, $custNumber, $address, $dateTime);//call database to create new booking
?>
