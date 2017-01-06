<?php
session_start();
if(!isset($_SESSION['ES-MLS']))
{ 
header("location:index.php?msg4=NotAllowed"); 
}
else
{ 
	$loginas=$_SESSION['ES-MLS'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2KES");
	if($token==$key)
	{ 
		$file_type = "x-msdownload";
		$date=date("Y-F-d");
		$fname="Linecount_Details of ".$loginas;
		$file_ending = "xls";
		HEADER("Content-Type: application/$file_type");
		HEADER("Content-Disposition: attachment; filename=$fname.$file_ending");
		HEADER("Pragma: no-cache");
		HEADER("Expires: 0");
	}
	else
	{ 
		header("location:index.php?msg4=NotAllowed"); 
	}
}
if(isset($_POST['start'],$_POST['end']))
{
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	$s_date=$_POST['start'];
	$e_date=$_POST['end'];
	$name=getname($loginas);
	print("$name\r");
	print("\t \t \t Line Count details from $s_date to $e_date \r  ");
	$a=1;
	$editlines=0;
	$blanklines=0;
	$dupeditlines=0;
	$dupblanklines=0;
	$conv=0;
	$result=mysql_query("SELECT `Date`,`Hospital`,`Platform_ID`,`File_No`,`File_type`,`DSP/NONDSP`,`Linecount` FROM `escript_filedetails` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `MT`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{
		print("S.No. \t Date \t Hospital \t ID \t File No \t File Type \t Upload Type \t LineCount \r \r");
		while($row1=mysql_fetch_array($result))
		{
			$date=$row1['Date'];
			$hos=$row1['Hospital'];
			$p_id=$row1['Platform_ID'];
			$file_no=$row1['File_No'];
			$type=$row1['File_type'];
			$lc=$row1['Linecount'];
			$status=$row1['DSP/NONDSP'];
			print("$a \t $date \t $hos \t $p_id \t $file_no \t $type \t $status \t $lc  \r ");
			$a=$a+1;
			if($row1['DSP/NONDSP']=="NON-DSP")
			{
				if($row1['File_type']=="Edit")
				{	
					$editlines=$editlines+$row1['Linecount'];
				}
				if($row1['File_type']=="Trans")
				{	
					$blanklines=$blanklines+$row1['Linecount'];
				}
			}
			else
			{
				if($row1['File_type']=="Edit")
				{	
					$dupeditlines=$dupeditlines+$row1['Linecount'];
				}
				if($row1['File_type']=="Trans")
				{	
					$dupblanklines=$dupblanklines+$row1['Linecount'];
				}
			}
		}
		print("\r\t\t\t\t\t\tTotal No. of NON DSP Trans Lines\t$blanklines\r");
		print("\t\t\t\t\t\tTotal No. of NON DSP Edit Lines\t$editlines\r");
		print("\t\t\t\t\t\tTotal No. of DSP Trans Lines\t$dupblanklines\r");
		print("\t\t\t\t\t\tTotal No. of DSP Edit Lines\t$dupeditlines\r");
		$conv=(2*$dupblanklines)+(2*$blanklines)+$dupeditlines+$editlines;
		print("\t\t\t\t\t\tConverted Lines\t$conv\r");
	}
}
mysql_close($con);
?>
