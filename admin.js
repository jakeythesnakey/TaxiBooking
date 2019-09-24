var xhr = createRequest(); 
var obj;

function getCurrentPickups(dataSource, divID, timeScale)
{
	/*For each found request, the
	booking reference number, customer name, contact phone, pick-up suburb, destination
	suburb, and pick-up date/time are required to return to the client*/
	
	obj = document.getElementById(divID); 
	
	var requestBody = "timeScale="+encodeURIComponent(timeScale);
	sendRequest(requestBody, dataSource);
}

function assignTaxi(dataSource, divID, bookingNumber)
{
	/*change the status of the
	booking request that matches the given booking reference number from “unassigned” to
	“assigned”, and return confirmation information to the client*/
	obj = document.getElementById(divID); 
	
	var requestBody = "bookingNumber="+encodeURIComponent(bookingNumber);
	sendRequest(requestBody, dataSource);
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






