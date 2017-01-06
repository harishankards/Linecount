<?php
session_start();
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
require_once('calendar/classes/tc_calendar.php');
if(!isset($_SESSION['Super_Admin']))
{ 
header("location:index.php?msg4=NotAllowed"); 
}
else
{ 
	$loginas=$_SESSION['Super_Admin'];
	$token=$_SESSION['token_sa'];
	$key=md5($loginas."_B2KSA");
	if($token==$key)
	{ 
		header( 'Content-Type: text/html; charset=utf-8' );
		include('dbconfig.php');
		include('global.php');
		include('include_dir.php');
	}
	else
	{ 
		header("location:index.php?msg4=NotAllowed");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>B2k Medical Transcription</title>
<meta name="keywords" content="B2klinecount, B2k Medical Transcription , Erode" />
<meta name="description" content="B2klinecount, B2k Medical Transcription, Erode" />
<link rel="shortcut icon" href="images/shortcut.png" size="32*32" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/fisheye.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/menu.css" rel="stylesheet" />
<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="cal/jsDatePick_ltr.css" />
<script src="js/jquery-1.3.1.min.js" language="javascript"></script>
<script type="text/javascript" src="js/staticlogo.js"></script>
<script src="js/menu.js" language="javascript"></script>
<script type="text/javascript" language="javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="cal/jsDatePick.full.1.3.js"></script>
<script type="text/javascript" src='codebase/message.js'></script>
<link rel="stylesheet" type="text/css" href="codebase/themes/message_growl_dark.css">
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
function call()
{
if(document.getElementById('check').checked==true)
{
	document.getElementById('detail').style.display = 'none';
	document.getElementById('share_detail').style.display = 'none';
}
else
{
	document.getElementById('detail').style.display='';
	document.getElementById('share_detail').style.display='';
}
}

function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=250,left = 147,top = 214');");
}

function highlight_row(the_element, checkedcolor) 
{
	
	if(the_element.parentNode.parentNode.style.backgroundColor != checkedcolor) 
	{
		the_element.parentNode.parentNode.style.backgroundColor = checkedcolor;
		
	}
	else 
	{
		the_element.parentNode.parentNode.style.backgroundColor = '';
	} 
	confirmDelete();
}
function show()
{
	dhtmlx.message('Searching please wait...');
}
function save()
{
	dhtmlx.message('Saving please wait...');
}
function del()
{
	dhtmlx.message('Removing please wait...');
}
</script>
