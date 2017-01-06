<?php
session_start();
if(!isset($_SESSION['MLS']))
{ 
header("location:index.php"); 
}
else
{ 
	$loginas=$_SESSION['MLS'];
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
	$name=$_SESSION['EMP_NAME_ID'];
	$uploadby=$name;
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$loginas." has Downloaded a file details in IDSIL / PJO from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	print("$name\r");
	print("\t \t \t Line Count details from $s_date to $e_date \r  ");
	$a=1;
	//For MLS
	$sh_dupb_line=0;
	$sh_dupe_line=0;
	$sh_blank_line=0;
	$sh_edit_line=0;
	$total=0;
	$d_total=0;
	$sql=mysql_query("SELECT `Date`,`Client`,`Hospital`,`File_No`,`File_min`,`File_Type`,`Linecount`,`Upstatus` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'");
	$count=mysql_num_rows($sql);
	if($count!=0)
	{
		print("S.No. \t Date \t Client \t Hospital \t File No \t File Minutes \t Type  \t Upload Type \t Linecount\r \r");
		while($row1=mysql_fetch_array($sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_No'];
			$file_min=$row1['File_min'];
			$type=$row1['File_Type'];
			$lc=$row1['Linecount'];
			$status=$row1['Upstatus'];
			print("$a \t $date \t $client \t $hos \t $file_no \t $file_min \t  $type \t $status \t $lc  \r ");
			$a=$a+1;
			if($row1['Upstatus']!="No DUP")// IF DUP
			{
				if($row1['File_Type']=="Edit")
				{
					$sh_dupe_line=$sh_dupe_line+$row1['Linecount'];
				}
				if($row1['File_Type']=="Blank")
				{
					$sh_dupb_line=$sh_dupb_line+$row1['Linecount'];
				}
			}
			else
			{
				if($row1['File_Type']=="Edit")
				{
					$sh_edit_line=$sh_edit_line+$row1['Linecount'];
				}
				if($row1['File_Type']=="Blank")
				{
					$sh_blank_line=$sh_blank_line+$row1['Linecount'];
				}
			}
		}
		print("\r\t\t\t\t\t\tTotal No. of Blank Lines\t$sh_blank_line\r");
		print("\t\t\t\t\t\tTotal No. of Edit Lines\t$sh_edit_line\r");
		$total=$sh_blank_line+$sh_edit_line;
		print("\t\t\t\t\t\tTotal No. of Lines\t$total\r");
		print("\t\t\t\t\tDUP Details\r");
		print("\t\t\t\t\t\tTotal No. of DUP Blank Lines\t$sh_dupb_line\r");
		print("\t\t\t\t\t\tTotal No. of DUP Edit Lines\t$sh_dupe_line\r");
		$d_total=$sh_dupb_line+$sh_dupe_line;
		print("\t\t\t\t\t\tTotal No. of DUP Lines\t$d_total\r");
		
	}
	
	$a=1;
	$sh_dupb_line=0;
	$sh_dupe_line=0;
	$sh_blank_line=0;
	$sh_edit_line=0;
	$total=0;
	$d_total=0;
	$sh_sql=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'");
	$count=mysql_num_rows($sh_sql);
	if($count!=0)
	{
		print("\rShared Files Details\r");	
		print("S.No. \t Date \t Client \t Hospital \t File No \t Type  \t Upload Type \t Linecount\r");
		while($row1=mysql_fetch_array($sh_sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_no'];
			$type=$row1['File_type'];
			$lc=$row1['Linecount'];
			$status=$row1['Upstatus'];
			print("$a \t $date \t $client \t $hos \t $file_no \t  $type  \t $status \t $lc\r ");
			$a=$a+1;
			if($row1['Upstatus']!="No DUP")// IF DUP
			{
				if($row1['File_type']=="Edit")
				{
					$sh_dupe_line=$sh_dupe_line+$row1['Linecount'];
				}
				if($row1['File_type']=="Blank")
				{
					$sh_dupb_line=$sh_dupb_line+$row1['Linecount'];
				}
			}
			else
			{
				if($row1['File_type']=="Edit")
				{
					$sh_edit_line=$sh_edit_line+$row1['Linecount'];
				}
				if($row1['File_type']=="Blank")
				{
					$sh_blank_line=$sh_blank_line+$row1['Linecount'];
				}
			}
		}
		print("\r\t\t\t\t\t\tTotal No. of Blank Lines\t$sh_blank_line\r");
		print("\t\t\t\t\t\tTotal No. of Edit Lines\t$sh_edit_line\r");
		$total=$sh_blank_line+$sh_edit_line;
		print("\t\t\t\t\t\tTotal No. of Lines\t$total\r\r");
		print("\t\t\t\t\tDUP Details\r");
		print("\t\t\t\t\t\tTotal No. of DUP Blank Lines\t$sh_dupb_line\r");
		print("\t\t\t\t\t\tTotal No. of DUP Edit Lines\t$sh_dupe_line\r");
		$d_total=$sh_dupb_line+$sh_dupe_line;
		print("\t\t\t\t\t\tTotal No. of DUP Lines\t$d_total\r");
	}
	
	$a=1;
	$sh_dupb_line=0;
	$sh_dupe_line=0;
	$sh_blank_line=0;
	$sh_edit_line=0;
	$total=0;
	$d_total=0;
	$sh_sql=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Proofed by`='$name'");
	$count=mysql_num_rows($sh_sql);
	if($count!=0)
	{
		print("\rProofed Files Details\r");	
		print("S.No. \t Date \t Client \t Hospital \t File No \t File Minutes\t Type  \t Upload Type \t Linecount\r");
		while($row1=mysql_fetch_array($sh_sql))
		{
			$date=$row1['Date'];
			$client=$row1['Client'];
			$hos=$row1['Hospital'];
			$file_no=$row1['File_no'];
			$file_min=$row1['File_min'];
			$type=$row1['File_type'];
			$lc=$row1['Linecount'];
			$status=$row1['Upstatus'];
			print("$a \t $date \t $client \t $hos \t $file_no \t $file_min \t  $type  \t $status \t $lc\r ");
			$a=$a+1;
			if($row1['Upstatus']!="No DUP")// IF DUP
			{
				if($row1['File_type']=="Edit")
				{
					$sh_dupe_line=$sh_dupe_line+$row1['Linecount'];
				}
				if($row1['File_type']=="Blank")
				{
					$sh_dupb_line=$sh_dupb_line+$row1['Linecount'];
				}
			}
			else
			{
				if($row1['File_type']=="Edit")
				{
					$sh_edit_line=$sh_edit_line+$row1['Linecount'];
				}
				if($row1['File_type']=="Blank")
				{
					$sh_blank_line=$sh_blank_line+$row1['Linecount'];
				}
			}
		}
		print("\r\t\t\t\t\t\tTotal No. of Blank Lines\t$sh_blank_line\r");
		print("\t\t\t\t\t\tTotal No. of Edit Lines\t$sh_edit_line\r");
		$total=$sh_blank_line+$sh_edit_line;
		print("\t\t\t\t\t\tTotal No. of Lines\t$total\r\r");
		print("\t\t\t\t\tDUP Details\r");
		print("\t\t\t\t\t\tTotal No. of DUP Blank Lines\t$sh_dupb_line\r");
		print("\t\t\t\t\t\tTotal No. of DUP Edit Lines\t$sh_dupe_line\r");
		$d_total=$sh_dupb_line+$sh_dupe_line;
		print("\t\t\t\t\t\tTotal No. of DUP Lines\t$d_total\r");
	}
}
mysql_close($con);
?>
