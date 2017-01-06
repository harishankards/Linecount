<html>
<body>
<style>
#displayDiv{
background-color: #ffeeaa;
width: 200;
}
</style>
<script type="text/javascript">
function ajaxFunction(str)
{
var httpxml;
try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateChanged() 
{
if(httpxml.readyState==4)
{
document.getElementById("displayDiv").innerHTML=httpxml.responseText;

}
}
var url="search.php";
url=url+"?txt="+str;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateChanged;
httpxml.open("GET",url,true);
httpxml.send(null);
}
</script>
</head>
<body> 
<form name="myForm">
<input type="text"
onkeyup="ajaxFunction(this.value);" name="username" autocomplete="off" />
<select name="search" >
<option id="displayDiv"></option></select>

</form>

</body>
</html>