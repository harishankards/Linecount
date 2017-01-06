<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http: //www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Google-like AJAX feature</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<script type="text/javascript">
		// Declare our request variable.
		var request = null;
		
		// Declare our function for setting the AJAX
		// XMLHttpRequest to variable request.
		function setAJAX() {
			// Set request variable for most modern
			// browsers.
			if(window.XMLHttpRequest)
			{
				request = new XMLHttpRequest();
				return true;
			}
			// Set request variable for older IE versions.
			else if(window.ActiveXObject)
			{
				request =  new ActiveXObject("Microsoft.XMLHTTP");
				return true;
			}
			// Return false if we cannot set the request
			// variable.
			else {
				return false;
			}
		}
		
		// Declare the function that will run when the user
		// lets up a key.
		function showMonth(text) {
			// Check to see if the request variable can be
			// set and set it.
			if(setAJAX()) {
				// Set our url to 'ajax.php?s=search_string'.
				var url = "search.php?txt=" + text;
				
				// Set the onreadystatechange to find function
				// getData when ready.
				request.onreadystatechange = getData;
				
				// Open and send the request.
				request.open("GET", url, true);
				request.send(null);
			}
			// Alert the user that we cannot do AJAX in their
			// browser.
			else {
				alert('Your browser does not support ajax');
			}
		}
		
		// Retrieve and output the data when it is ready.
		function getData() {
			if(request.readyState == 4 && request.status == 200) {
				document.getElementById("response").innerHTML = request.responseText;
			}
		}
	</script>
</head>
<body>

<form action="" method="post">
	<p>Enter a month:</p>
	<p><input type="text" name="search" value="" class="text" onkeyup="showMonth(this.value);" /></p>
	<p id="response"></p>
	<p><input type="submit" name="submit" value="Submit" class="button" /></p>
</form>

</body>
</html>
