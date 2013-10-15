var AjaxUrl = "../tech/Gateway.inc.php"

function makePOSTRequest(url, post_vars) {
	//Create the XML object
	if (window.XMLHttpRequest) {
	 var http_request = new XMLHttpRequest();
	 if (http_request.overrideMimeType) {
		http_request.overrideMimeType('text/html');
	 }
	} else if (window.ActiveXObject) {
	 try {
		http_request = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
		try {
		   http_request = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {}
	 }
	}

	//Check if the request is finished
	http_request.onreadystatechange = function(){
		if (http_request.readyState == 4) {
			if (http_request.status == 200) {
				//alert(http_request.responseText)
				eval(http_request.responseText)
			}
		} else {
			
			//showWait(waiter)
		}
	}

	//Build the Request
	http_request.open('POST', url, true);
	http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http_request.setRequestHeader("Connection", "close");
	http_request.send(post_vars);
}
