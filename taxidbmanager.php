<?php
	$conn;
	
	function Connect ()
	{		
		global $conn;//gets global
		require("conf/taxisettings.php");//Path to settings


		//echo "Connection beginning";//for testing
		$conn = mysqli_connect($host, $user, $pswd, $user) or die("Connect failed: %s\n". $conn -> error);
		//echo "<br>Database uplink: Online<br>";//for testing
	}
	
	
	function NewBooking($custname, $custnumber, $address, $pickuptime)
	{
		global $conn;//gets global
		require("conf/taxisettings.php");//Path to settings

		Connect();//Connects to database using the the global viable $conn
		
		//creates query
		$sqlquery = "INSERT INTO booking (custname, custNumber, pickuptime, address) VALUES('".$custname."', '".$custnumber."', '".$pickuptime."', '".$address."');";
		//echo $sqlquery."<br>";//for testing

		$returnString = "";
		
		Connect();//Connects to database using the the global viable $conn
		if (!mysqli_query($conn, $sqlquery))//performs query
		{
			$returnString = "Table not updated. Error description: " . mysqli_error($conn). "code: ". mysqli_errno($conn);//provides error message if query fails
		}
		else
		{
			$date = date("F d, Y h:i A", $pickuptime); //creates human-readable version of pickup datedate
			$nuQuery = "SELECT MAX(bookingnum) AS bookingno FROM booking";//get booking number
			$result = mysqli_query($conn, $nuQuery);//performs query
			if (!$result)//if booking number not retrieved
			{
				$returnString = "Booking failed. Could not retrieve booking reference. Error description: " . mysqli_error($conn). "code: ". mysqli_errno($conn);//provides error message if query fails
			}
			else
			{
				$refno = "reference not found";
				while($row = mysqli_fetch_assoc($result)) //takes a row out of result and adds it to row as assoc array
				{
					$refno = $row["bookingno"];//get ref number from result
				}
				
				$returnString = ("Thank you! Your booking reference  number  is  ".$refno.".  You  will  be  picked  up  in  front  of  your  provided address  at  ".$date.".");//if successful provides success message
			}			
		}
		Disconnect();		
		
		echo $returnString;
	}
	
	function AssignTaxi ($bookingNumber)
	{
		require("conf/taxisettings.php");//Path to settings

		global $conn;//gets global
		
		$query = "UPDATE booking SET status = 1 WHERE bookingnum = ".$bookingNumber.";";

		$returnString = "";
		
		Connect();//Connects to database using the the global viable $conn
		if (!mysqli_query($conn, $query))//performs query
		{
			$returnString = "Table not updated. Error description: " . mysqli_error($conn). "code: ". mysqli_errno($conn);//provides error message if query fails
		}
		else
		{
			$returnString = "Table Updated. booking assigned";//if successful provides success message
		}
		Disconnect();		
		
		echo $returnString;
	}
	
	function getBookings($timeScale)
	{
		//get from booking where time - current time < 2 hours
		require("conf/taxisettings.php");//Path to settings
		global $conn;//gets global
		Connect();
		
		if (!$conn) //Checks if connection working
		{
			die("Connection failed: " . mysqli_connect_error());//provides error message on connection failure
		}
		
		//seconds into Milliseconds
		$currentTime = time();
		//turn hours into milliseconds
		$newTimeScale = $timeScale * 3600;
				
		$maxTime = $newTimeScale + $currentTime;		

		$sqlquery = ("SELECT * FROM booking WHERE pickuptime > ".$currentTime." AND pickuptime < ".$maxTime.";");//Sets up query
		//echo $sqlquery."<br>";//for testing
		
		$result = mysqli_query($conn, $sqlquery);//Perform query
		if ($result) //checks if there are any rows returned
		{
			echo "Bookings available: ";
			while($row = mysqli_fetch_assoc($result)) //takes a row out of result and adds it to row as assoc array
			{
				//retrieves items in row of assoc array and prints to screen
				echo "<br><br>Booking number: ".$row["bookingnum"];
				echo "<br>Customer name: ".$row["custname"];
				echo "<br>Customer phone number: ".$row["custnumber"];
				$date = date("F d, Y h:i A", $row["pickuptime"]); //creates human-readable version of pickup datedate
				echo "<br>Pickup time: ".$date;
				echo "<br>Status (0=unassigned, 1 = assigned): ".$row["status"];
				echo "<br>Pickup address: ".$row["address"];				
			}
		}
		else//default condition if search unsuccessful
		{
			echo "<br>No bookings found in next ".$timeScale." hours";//prints error message
		}	
		
		Disconnect();
	}
	
	function CheckTable($tableName)
	{
		require("conf/taxisettings.php");//Path to settings
		global $conn;
		Connect();
		
		$retBool = FALSE;
		if (!$conn) //Checks if connection working
		{
			die("Connection failed: " . mysqli_connect_error());//prints error message
		}
		
		$val = mysqli_query($conn, "select 1 from `".$tableName."` LIMIT 1;");// checks table exists
		if($val !== FALSE)
		{
		   $retBool = TRUE;
		}

		
		Disconnect();
		return $val;
	}
	
	function Disconnect ()
	{
		require("conf/taxisettings.php");//Path to settings
		
		global $conn;

		$conn -> close();//Closes connection
		//echo "<br>Database uplink: Offline<br>";//for testing
	}
	
?>
