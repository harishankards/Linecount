<html>
<head>
<title>How to enable/disable a textarea using JavaScript</title>
<script type = "text/javascript">

function disable() 
{ 

       var textarea = document.getElementById('textarea');

       textarea.disabled = true; 

       textarea.style.background = "#DDD";

}

function enable() 
{ 

       var textarea = document.getElementById('textarea');

       textarea.disabled = false; 

       textarea.style.background = "#fff";	

}

</script>
</head>
<body>

<textarea id="textarea"></textarea>
<br><br>
<input type="button" value="Disable" onClick="javascript:disable();">
<input type="button" value="Enable" onClick="javascript:enable();">

</body>
</html>