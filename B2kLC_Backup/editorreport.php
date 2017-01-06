<?php
session_start();
if(!isset($_SESSION['EDITOR']))
{ 
header("location:index.php"); 
}
else
{ 
	$loginas=$_SESSION['EDITOR'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2KIDSIL");
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
		header("location:index.php"); 
	}
}
if(isset($_POST['start'],$_POST['end']))
{
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	$s_date=$_POST['start'];
	$e_date=$_POST['end'];
	$name=$_SESSION['idsileditorname'];
	$uploadby=$name;
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$loginas." has Downloaded a file details in IDSIL / PJO from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	
	//Editing Files
	print("$name\r");
	print("\t \t \t Line Count details from $s_date to $e_date \r  ");
	$a=1;
	$sh_dupb_line=0;
	$sh_dupe_line=0;
	$total=0;
	$sql=mysql_query("SELECT `Date`,`Client`,`Hospital`,`File_No`,`File_Type`,`Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Editedby`='$name'");
	$count=mysql_num_rows($sql);
	if($count!=0)
	{
		print("Second Level Editing Details\r");
		print("S.No. \t Date \t Client \t Hospital \t File No \t Type  \t Linecount\r");
		print("\r");
		while($row1=mysql_fetch_array($sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_No'];
			$type=$row1['File_Type'];
			$lc=$row1['Linecount'];
			print("$a \t $date \t $client \t $hos \t $file_no \t  $type \t $lc  \r ");
			$a=$a+1;
			if($row1['File_Type']=="Edit")
			{
				$sh_dupe_line=$sh_dupe_line+$row1['Linecount'];
			}
			if($row1['File_Type']=="Blank")
			{
				$sh_dupb_line=$sh_dupb_line+$row1['Linecount'];
			}
		}
		print("\r\t\t\t\t\t\tTotal No. of Blank Lines\t$sh_dupb_line\r");
		print("\t\t\t\t\t\tTotal No. of Edit Lines\t$sh_dupe_line\r");
		$total=$sh_dupe_line+$sh_dupb_line;
		print("\t\t\t\t\t\tTotal No. of Lines\t$total\r");
	}
	
	//Third level Editing 
	$a=1;
	$sh_dupb_line=0;
	$sh_dupe_line=0;
	$total=0;
	$sh_sql=mysql_query("SELECT `Date`,`Client`,`Hospital`,`File_No`,`File_Type`,`Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Third_Editor`='$name'");
	$count=mysql_num_rows($sh_sql);
	if($count!=0)
	{
		print("Third Level Editing Details\r");	
		print("S.No. \t Date \t Client \t Hospital \t File No \t Type  \t Linecount\r");
		while($row1=mysql_fetch_array($sh_sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_No'];
			$type=$row1['File_Type'];
			$lc=$row1['Linecount'];
			print("$a \t $date \t $client \t $hos \t $file_no \t  $type  \t $lc  \r ");
			$a=$a+1;
			if($row1['File_Type']=="Edit")
			{
				$sh_dupe_line=$sh_dupe_line+$row1['Linecount'];
			}
			if($row1['File_Type']=="Blank")
			{
				$sh_dupb_line=$sh_dupb_line+$row1['Linecount'];
			}
		}
		print("\r\t\t\t\t\t\tTotal No. of Blank Lines\t$sh_dupb_line\r");
		print("\t\t\t\t\t\tTotal No. of Edit Lines\t$sh_dupe_line\r");
		$total=$sh_dupe_line+$sh_dupb_line;
		print("\t\t\t\t\t\tTotal No. of Lines\t$total\r");
	}
	
	//Auditing Files
	$a=1;
	$sh_dupb_line=0;
	$sh_dupe_line=0;
	$total=0;
	$ad_sql=mysql_query("SELECT * FROM `audit_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Audit_by`='$name'");
	$count=mysql_num_rows($ad_sql);
	if($count!=0)
	{
		print("Auditing file Details\r");	
		print("S.No. \t Date \t Client \t Hospital \t File No  \t Linecount\r");
		while($row1=mysql_fetch_array($ad_sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_no'];
			$lc=$row1['Linecount'];
			print("$a \t $date \t $client \t $hos \t $file_no  \t $lc  \r ");
			$a=$a+1;
			$total=$total+$lc;
		}
		print("\t\t\t\t\t\tTotal No. of Audit Lines\t$total\r");
	}
	
	//Missing Files
	$a=1;
	$total=0;
	$ad_sql=mysql_query("SELECT * FROM `missing_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Edit_by`='$name'");
	$count=mysql_num_rows($ad_sql);
	if($count!=0)
	{
		print("Missing file Details\r");	
		print("S.No. \t Date \t Client \t Hospital \t File No  \t Linecount\r");
		while($row1=mysql_fetch_array($ad_sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_no'];
			$lc=$row1['Linecount'];
			print("$a \t $date \t $client \t $hos \t $file_no  \t $lc  \r ");
			$a=$a+1;
			$total=$total+$lc;
		}
		print("\t\t\t\t\t\tTotal No. of Lines\t$total\r");
	}
	
	//DUP Files
	$a=1;
	$sh_dupb_line=0;
	$sh_dupe_line=0;
	$total=0;
	$dup_sql=mysql_query("SELECT `Date`,`Client`,`Hospital`,`File_No`,`File_Type`,`Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'");
	$count=mysql_num_rows($dup_sql);
	if($count!=0)
	{
		print("DUP Details\r");	
		print("S.No. \t Date \t Client \t Hospital \t File No \t Type  \t Linecount\r");
		while($row1=mysql_fetch_array($dup_sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_No'];
			$type=$row1['File_Type'];
			$lc=$row1['Linecount'];
			print("$a \t $date \t $client \t $hos \t $file_no \t  $type  \t $lc  \r ");
			$a=$a+1;
			if($row1['File_Type']=="Edit")
			{
				$sh_dupe_line=$sh_dupe_line+$row1['Linecount'];
			}
			if($row1['File_Type']=="Blank")
			{
				$sh_dupb_line=$sh_dupb_line+$row1['Linecount'];
			}
		}
		print("\r\t\t\t\t\t\tTotal No. of Blank Lines\t$sh_dupb_line\r");
		print("\t\t\t\t\t\tTotal No. of Edit Lines\t$sh_dupe_line\r");
		$total=$sh_dupe_line+$sh_dupb_line;
		print("\t\t\t\t\t\tTotal No. of Lines\t$total\r");
	}
}
mysql_close($con);
?>
