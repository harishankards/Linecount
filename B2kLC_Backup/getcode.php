<?php
session_start();
require_once('calendar/classes/tc_calendar.php');
if(!isset($_SESSION['Admin']))
{ 
header("location:index.php"); 
}
else 
header( 'Content-Type: text/html; charset=utf-8' );
include('dbconfig.php');
include('include_dir.php');
include('global.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>B2k Medical Transcription</title>
<meta name="keywords" content="B2k Medical Transcription Linecount" />
<meta name="description" content="B2k Medical Transcription Linecount" />
<link rel="shortcut icon" href="images/shortcut.png" size="32*32" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js" language="javascript"></script>
<script type="text/javascript" src="js/copy.js"></script>
<script type="text/javascript" src="js/RCPCode.js"></script>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>
</head>
<body>
<center>
<br />
<br />
<br />
<br />
<h2>Enter the Code Word</h2>
<form name="code" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
<table><tr><td><input type="password" value="password" size="28" name="code" id="code" onfocus="clearText(this)" onblur="clearText(this)"/></td></tr></table>
</form>
</center>
<?php
if(isset($_POST['code']))
{
	$code=mysql_real_escape_string($_POST['code']);
	if($code=="TADPOLE_ISLAND")
	{
		$_SESSION['CODE']="Access_granted";
		echo "<center><a href=\"cleardb.php\"><input type=\"button\" value=\"GO\" size=\"28\" name=\"code\" id=\"code\" /></a></center>";
	}
	else
	{
		echo "<center><a href=\"codebreach.php\"><input type=\"button\" value=\"GO\" size=\"28\" name=\"code\" id=\"code\" /></a></center>";
	}
}
mysql_close($con);
?>
</body>
</html>
