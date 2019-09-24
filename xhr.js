// file xhr.js. creates xhr objects
 function createRequest() {
    var xhr = false;  //check none exist
    if (window.XMLHttpRequest) {//creates new request
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {//backup functionality for old microsoft browsers
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
} // end function createRequest()
