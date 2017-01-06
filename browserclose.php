<?php
include('dbconfig.php');
include('global.php');
session_start(); 
if(isset($_SESSION['Admin']))
{ 
	$name=$_SESSION['Admin'];
}
elseif(isset($_SESSION['MLS']))
{ 
	$name=$_SESSION['MLS'];
}
elseif(isset($_SESSION['EDITOR']))
{ 
	$name=$_SESSION['EDITOR'];
}
$id=session_id();
$sql="UPDATE `log_file`  SET `Log_out_time`='$datetime' WHERE `Date`='$date_only' AND `Loginas`='$name' AND `Session_Id`='$id'";
$up_status="UPDATE `employee` SET `Log_status`='NO' WHERE `Emp_no`='$name'";
$upstatus=mysqli_query($dbC,$up_status);
$result=mysqli_query($dbC,$sql);
session_unset();
session_destroy(); 
header("location:index.php?msg3=loggedout");
?>
