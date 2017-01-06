<?php
session_start();
require_once('calendar/classes/tc_calendar.php');
if(!isset($_SESSION['Admin']))
{ 
header("location:index.php"); 
}
else
{ 
	$loginas=$_SESSION['Admin'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2K");
	if($token==$key)
	{ 
		$file_type = "x-msdownload";
		$date=date("Y-F-d");
		$fname="Newport_Bay_".$date;
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
$final_blank_lines=0;
$final_edit_lines=0;
$final_total_lines=0;
$final_dupblank_lines=0;
$final_dupedit_lines=0;
$final_proof_lines=0;
$final_proof_total=0;
if(isset($_POST['start'],$_POST['end']))
{
	$s_date=$_POST['start'];
	$e_date=$_POST['end'];
	print("\t \t \t Line Count details from $s_date to $e_date \r  ");
	$a=1;
	//For MLS
	print("\t Newportbay File Details  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No. \t Date (YYYY-MM-DD) \t Client \t Hospital \t File No \t Voice No \t Name \t  Upload Type \r");
	print("\r");
	$mls_query=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Client`='PJO'");
	$mls_count=mysql_num_rows($mls_query);
	if($mls_count!=0)
	{
		while($mlsrow=mysql_fetch_array($mls_query))
		{	
			$date=$mlsrow['Date'];
			$client=$mlsrow['Client'];
			$hosital=$mlsrow['Hospital'];
			$type=$mlsrow['Upload_to'];
			$name=$mlsrow['Editedby'];
			$fileno=$mlsrow['File_No'];
			$voiceno=$mlsrow['Voice_No'];
			print("$a \t $date \t $client \t $hosital \t $fileno \t $voiceno \t $name \t $type \r");
			$a=$a+1;
		}
	}
}
mysql_close($con);
?>
