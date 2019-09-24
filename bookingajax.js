var xhr = createRequest(); 
var obj;
function createBooking(dataSource, divID, aName, aNumber, aUnit, aStreetNum, aStreetName, aSuburb, aHour, aMinute, aDate)  
{ 
	var returnString = "Ya fucked up boi, invalid input";
	obj = document.getElementById(divID); 
	
	var address = aStreetNum + " " + aStreetName + " ," + aSuburb;
	
	var dateArray = aDate.split("-");
	
	//var time = parseInt(aHour, 10)*3600 + parseInt(aMinute, 10)*60 + XXX GETDATE XXX;
	var newDate = new Date(dateArray[0], dateArray[1]-1, dateArray[2], aHour, aMinute, 0);
		
	if (aUnit !== "")
	{
		address = aUnit + "/" + address;
	}
	var valid = validate(aName, aNumber, aUnit, aStreetNum, aStreetName, aSuburb, newDate);
	if (valid)
	{
		var requestBody = "custName="+encodeURIComponent(aName)+"&custNumber="+encodeURIComponent(aNumber)+"&address="+encodeURIComponent(address)+"&datetime="+encodeURIComponent(newDate.getTime()/1000);
		sendRequest(requestBody, dataSource);
	}
} 

function validate(aName, aNumber, aUnit, aStreetNum, aStreetName, aSuburb, aTime)
{
	var validArray = [];
	var returnString = "";
	var returnVal = false;
	if (aName == "")
	{
		validArray.push("'name not entered'");
	}
	if (aNumber == "")
	{
		validArray.push("'number not entered'");
	}
	if (aStreetNum == "")
	{
		validArray.push("'street number not entered'");
	}
	if (aStreetName == "")
	{
		validArray.push("'street name not entered'");
	}
	
	if (aTime != "")
	{
		if(aTime.getTime() - (new Date).getTime() <= 0)
		{
			validArray.push("'Pickup time cannot be set in the past!'");
		}
	}
	else
	{
		validArray.push("'Time/Date not entered'");
	}
	
	if (validArray.length != 0)
	{		
		returnString += "The following inputs are invalid: ";
		for (var i =0;i<validArray.length;i++)
		{
			returnString += validArray[i] + ", "; 
		}
		obj.innerHTML = returnString;
		returnVal = false;		
	}
	else
	{
		returnString = "All inputs valid";
		returnVal = true;
	}
	
	return returnVal;
}	

function sendRequest(requestBody, dataSource)
{
	xhr.onreadystatechange = sendData; 
	
    xhr.open("POST", dataSource, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(requestBody);	
}

function sendData()
{
    //alert(xhr.readyState);//testing only
	//if xhr object received response
	if (xhr.readyState == 4)
	{
		obj.innerHTML = xhr.responseText;
	}	
}

