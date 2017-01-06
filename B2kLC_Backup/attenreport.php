<?php
session_start();
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
if(!isset($_SESSION['Admin']))
{ 
header("location:index.php"); 
}
else
{ 
	$loginas=$_SESSION['Admin'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_Admin@B2K");
	if($token==$key)
	{ 
		$file_type = "x-msdownload";
		$date=date("Y-F-d");
		$fname="Attendance Report on ".$date;
		$file_ending = "xls";
		HEADER("Content-Type: application/$file_type");
		HEADER("Content-Disposition: attachment; filename=$fname.$file_ending");
	    HEADER("Pragma: no-cache");
		HEADER("Expires: 0");
		include('dbconfig.php');
		include('include_dir.php');
		include('global.php');
	}
	else
	{ 
		header("location:index.php"); 
	}
}
if(isset($_POST['start'],$_POST['end']))
{
	$s_date=mysql_real_escape_string($_POST['start']);
	$e_date=mysql_real_escape_string($_POST['end']);
	print("\t Attendance Report from ".$s_date." to ".$e_date." \r");
	print("S.No. \t Name \t No. of Full days \t No. of Half days \t No. of Days Leave \t No. of Days Double Pay \t No. of Night Shift \r");
	print("\r ");
	$sql=mysql_query("select * from `attn_list`  order by `Name`");
	while($row=mysql_fetch_array($sql))
	{
		$id=$row['No'];
		$full=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Full'");
		$count_full=mysql_num_rows($full);
		$half=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Half'");
		$count_half=mysql_num_rows($half);
		$leave=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Leave'");
		$count_leave=mysql_num_rows($leave);
		$doublepay=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Double_pay`='YES'");
		$count_double=mysql_num_rows($doublepay);
		$night=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Night'");
		$count_night=mysql_num_rows($night);
		$name=$row['Name'];
		print("$no \t $name \t $count_full \t $count_half \t $count_leave \t $count_double \t $count_night \r ");
		$no=$no+1;				
	}
}
$comment=$loginas." has downloaded a Attendance Report";
$fp = fopen($log_dir.$loginas.".txt", "a+");
fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
fclose($fp);
mysql_close($con);
?>
