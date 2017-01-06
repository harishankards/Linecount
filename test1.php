<html>
<head>
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#submit").click(function(){
var year = $(#year option:selected).val();
if(year == "")
{
$("#msg").html("Please select a year");
return false;
}
});
});
</script>
</head>
<body>
<div id="msg"></div>
<form method="post" action="">
<select id="year">
<option>1990 </option>
<option>1991 </option>
<option>1992 </option>
<option>1993 </option>
<option>1994 </option>
<option>1995 </option>
</select>

<input type="submit" name="submit" id="submit">
</form>
</body>
<div> </html</div>