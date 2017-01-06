<?php
session_start();
require_once('calendar/classes/tc_calendar.php');
if(!isset($_SESSION['Admin']))
{ 
header("location:index.php?msg4=NotAllowed"); 
}
else
{ 
	$loginas=$_SESSION['Admin'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_Admin@B2K");
	if($token==$key)
	{ 
		header( 'Content-Type: text/html; charset=utf-8' );
		include('dbconfig.php');
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
<style>
/*@page { size 8.5in 11in; margin: 2cm };*/
</style>
</head>
<body onload="window.print()">
<?
if(isset($_POST['start'],$_POST['end']))
{
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	$s_date=$_POST['start'];
	$e_date=$_POST['end'];
	echo "<center><h3> Line Count details from $s_date to $e_date </h3></center>";
	//For MLS
	echo "<table  align=\"center\" border=\"1\" style=\"width:700px; height:600px; font-size: 14px;\" >";
	echo "<th>MLS Name</th><th>Total Linecount</th><th>DUP Blank</th><th>Dup Edit</th><th>NONDUP Blank</th><th>NONDUP Edit</th><th>Proofed</th><th>DUP Evaluation</th>";
	$e_sql=mysql_query("select * from `employee` WHERE `Emp_desig`='MLS' order by `Emp_no`");
	while($row1=mysql_fetch_array($e_sql))
	{
		$NDUP_E=0;
		$NDUP_B=0;
		$DUP_B=0;
		$DUP_E=0;
		$S_NDUP_E=0;
		$S_NDUP_B=0;
		$S_DUP_E=0;
		$S_DUP_B=0;
		$P_LINES=0;
		$total=0;
		$no=$row1['Emp_no'];
		$name=getname($no);
		$no=mysql_real_escape_string($no);
		$name=mysql_real_escape_string($name);
		$f_sql=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'");
		$count=mysql_num_rows($f_sql);
		if($count!=0)
		{
			while($row2=mysql_fetch_array($f_sql))
			{
				$lc=$row2['Linecount'];
				if($row2['Upstatus']!="No DUP")// IF DUP
				{
					if($row2['File_Type']=="Edit")
					{
						$DUP_E=$DUP_E+$row2['Linecount'];
					}
					if($row2['File_Type']=="Blank")
					{
						$DUP_B=$DUP_B+$row2['Linecount'];
					}
					
				}
				else
				{
					if($row2['File_Type']=="Edit")
					{
						$NDUP_E=$NDUP_E+$row2['Linecount'];
					}
					if($row2['File_Type']=="Blank")
					{
						$NDUP_B=$NDUP_B+$row2['Linecount'];
					}
					
				}
			}
			
			
		}
		$sh_sql=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'");
		$count=mysql_num_rows($sh_sql);
		if($count!=0)
		{
			while($row3=mysql_fetch_array($sh_sql))
			{
				
				if($row3['Upstatus']!="No DUP")// IF DUP
				{
					if($row3['File_type']=="Edit")
					{
						$S_DUP_E=$S_DUP_E+$row3['Linecount'];
					}
					if($row3['File_type']=="Blank")
					{
						$S_DUP_B=$S_DUP_B+$row3['Linecount'];
					}
				}
				else
				{
					
					if($row3['File_type']=="Edit")
					{
						$S_NDUP_E=$S_NDUP_E+$row3['Linecount'];
					}
					if($row3['File_type']=="Blank")
					{
						$S_NDUP_B=$S_NDUP_B+$row3['Linecount'];
					}
				}
			}
		}
		$pr_sql=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Proofed by`='$name'");
		$count=mysql_num_rows($pr_sql);
		if($count!=0)
		{
			while($row4=mysql_fetch_array($pr_sql))
			{
				$P_LINES=$P_LINES+$row4['Linecount'];
			}
		}
		$D_balnk=$DUP_B+$S_DUP_B;
		$D_edit=$DUP_E+$S_DUP_E;
		$ND_blank=$NDUP_B+$S_NDUP_B;
		$ND_edit=$NDUP_E+$S_NDUP_E;
		$total=$D_balnk+$D_edit+$ND_blank+$ND_edit;
		echo "<tr align=\"center\"><td style=\"width:120px;\">".$name."</td><td style=\"width:70px;\">".$total."</td><td style=\"width:70px;\">".$D_balnk."</td><td style=\"width:70px;\">".$D_edit."</td><td style=\"width:70px;\">".$ND_blank."</td><td style=\"width:70px;\">".$ND_edit."</td><td style=\"width:70px;\">".$P_LINES."</td><td><textarea name=\"test\" rows=\"3\" cols=\"12\"></textarea></td></tr>";
	}
}
echo "</table>";
mysql_close($con);
?>
</body>
</html>