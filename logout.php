<?php
include('dbconfig.php');
include('global.php');
include('include_dir.php');
session_start(); 
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
$proxy=@getRealIpAddr();
$host =$proxy;
if(isset($_SESSION['Admin']))
{ 
	$name=$_SESSION['Admin'];
	$uploadby=$name;
}
elseif(isset($_SESSION['Vendor_Admin']))
{ 
	$name=$_SESSION['Vendor_Admin'];
	$uploadby=$name;
}
elseif(isset($_SESSION['MLS']))
{ 
	$name=$_SESSION['MLS'];
	$uploadby=getname($name);
}
elseif(isset($_SESSION['EDITOR']))
{ 
	$name=$_SESSION['EDITOR'];
	$uploadby=getname($name);
}
elseif(isset($_SESSION['ES-MLS']))
{ 
	$name=$_SESSION['ES-MLS'];
	$uploadby=getname($name);
}
elseif(isset($_SESSION['ES-EDITOR']))
{ 
	$name=$_SESSION['ES-EDITOR'];
	$uploadby=getname($name);
}
$fp = fopen($log_dir.$uploadby.".txt", "at");
$comment=$name." has logged out from the Linecount Software Using the System ".$host;
fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
fclose($fp);
$id=session_id();
//$sql="UPDATE `log_file`  SET `Log_out_time`='$datetime' WHERE `Date`='$date_only' AND `Loginas`='$name' AND `Session_Id`='$id'";
$up_status="UPDATE `employee` SET `Log_status`='NO' WHERE `Emp_no`='$name'";
$upstatus=mysqli_query($dbC,$up_status);
//$result=mysqli_query($dbC,$sql);
session_unset();
session_destroy(); 
header("location:index.php?msg2=loggedout");
?>