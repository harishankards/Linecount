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
	$key=md5($loginas."_B2K");
	if($token==$key)
	{ 
		$file_type = "x-msdownload";
		$date=date("Y-F-d");
		$fname="IDWISE REPORT_".$date;
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

if(isset($_POST['f_query'],$_POST['s_date'],$_POST['e_date']))
{
	$first=stripslashes($_POST['f_query']);
	$s_date=$_POST['s_date'];
	$e_date=$_POST['e_date'];
	print("\t \t \t ID Wise Line Count details from $s_date to $e_date \r  ");
	$a=1;
	$tot_blank_jobs=0;
	$tot_edit_jobs=0;
	$tot_blank=0;
	$tot_edit=0;
	$final_tot=0;
	$file_count=0;
	//For MLS
	print("S.No. \t ID \t No. of Blank Files \t No. of Edit files \t Blank lines \t Edit lines \t Total LineCount \r");
	print("\r");
	
	$sql=mysql_query($first);
	while($row1=mysql_fetch_array($sql))
	{
		$id=$row1['username'];
		$edit=0;
		$edit_job=0;
		$blank=0;
		$blank_job=0;
		$total_lc=0;
		$up_query="SELECT `File_Type`,`Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Platform_id`='$id'";
		$up_result=mysql_query($up_query);
		$up_count=mysql_num_rows($up_result);
		if($up_count!=0)
		{	
			while($uprow=mysql_fetch_array($up_result))
			{		
				$file_count=$file_count+1;		
				if($uprow['File_Type']=="Edit")
				{	
					$edit=$edit+$uprow['Linecount'];
					$edit_job=$edit_job+1;
				}
				if($uprow['File_Type']=="Blank")
				{	
					$blank=$blank+$uprow['Linecount'];
					$blank_job=$blank_job+1;
				}
				$total_lc=$total_lc+$uprow['Linecount'];
			}
			print("$a \t $id \t $blank_job \t $edit_job \t $blank \t $edit \t $total_lc \r");
			$a=$a+1;
		}
		$tot_blank_jobs=$tot_blank_jobs+$blank_job;
		$tot_edit_jobs=$tot_edit_jobs+$edit_job;
		$tot_blank=$tot_blank+$blank;
		$tot_edit=$tot_edit+$edit;
		$final_tot=$final_tot+$total_lc;
	}
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t No. of Files \t  \t $file_count \t  \t  \t  \t  \r");
	print(" \t  \t No. of Edit Files \t  \t $tot_edit_jobs \t  \t  \t  \t\r");
	print(" \t  \t No. of Blank Fiels \t  \t $tot_blank_jobs \t  \t  \t  \t\r");
	print(" \t  \t No. of Edit Lines \t  \t $tot_edit \t  \t  \t  \t \r");
	print(" \t  \t No. of Blank Lines \t  \t $tot_blank \t  \t  \t  \t \r");
	print(" \t  \t Final No. of Lines \t  \t $final_tot \t  \t  \t  \t \r");
	
}
mysql_close($con);
?>
