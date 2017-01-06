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
		$fname="HT_Line_Count_".$date;
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
$final_edt_dup_total=0;
$final_dup_edtr=0;
if(isset($_POST['start_ht'],$_POST['end_ht']))
{
	$s_date=mysql_real_escape_string($_POST['start_ht']);
	$e_date=mysql_real_escape_string($_POST['end_ht']);
	print("\t \t \tHT Line Count details from $s_date to $e_date \r  ");
	$a=1;
	//For MLS
	print("\t HT MLS LINECOUNT  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No. \t Name \t Blank \t Edit \t DUP Blank \t Dup Edit \t Total LineCount \t Proofing \t Proofing / DUP \t Proofing Total \t Final Total \r");
	print("\r ");
		$sql=mysql_query("select * from `employee` WHERE `Emp_desig`='HT-MLS' order by `Emp_no`");
	while($row1=mysql_fetch_array($sql))
	{
		$no=$row1['Emp_no'];
		$name=getname($no);
		$name=mysql_real_escape_string($name);
		$final_mls_total=0;
		$final_mls_p_total=0;
		$final_mls_f_total=0;
		
		$cl_query="SELECT * FROM `client`";
		
		$cl_result=mysql_query($cl_query);
		
		$cl_count=mysql_num_rows($cl_result);
		
		if($cl_count!=0)
		{
			while($clrow=mysql_fetch_array($cl_result))
			{				
				$cl_name=mysql_real_escape_string($clrow['Client_name']);
				$blanklines=0;
				$editlines=0;
				$dup_blank=0;
				$dup_edit=0;
				$prooflines=0;
				$proofduplines=0;
				$sh_dupb_line=0;
				$sh_dupe_line=0;
				$sh_blank_line=0;
				$sh_edit_line=0;
				$sh_pr_lc=0;
				$sh_pr_duplc=0;
				$total_lc=0;
				$up_query="SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'";
				
				$up_result=mysql_query($up_query);
				
				$up_count=mysql_num_rows($up_result);
				
				// MLS Uploaded Files
				if($up_count!=0)
				{	
					while($uprow=mysql_fetch_array($up_result))
					{				
							if($uprow['Upstatus']!="No DUP")// IF DUP
							{	
								if($uprow['File_Type']=="Edit")
								{	
									$dup_edit=$dup_edit+$uprow['Linecount'];
								}
								if($uprow['File_Type']=="Blank")
								{	
									$dup_blank=$dup_blank+$uprow['Linecount'];
								}
							}
							else
							{
								if($uprow['File_Type']=="Edit") // IF NO DUP
								{	
									
									$editlines=$editlines+$uprow['Linecount'];
								}
								if($uprow['File_Type']=="Blank")
								{	
									$blanklines=$blanklines+$uprow['Linecount'];
								}
								if($uprow['Shared']=="YES")
								{
									$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'");
									while($shrow=mysql_fetch_array($shared))
									{
										if($shrow['File_type']=="Edit")
										{
											$sh_edit_line=$sh_edit_line+$shrow['Linecount'];
										}
										if($shrow['File_type']=="Blank")
										{
											$sh_blank_line=$sh_blank_line+$shrow['Linecount'];
										}
									}
								}
							}
							
							//$total_lc=$total_lc+$uprow['Linecount'];
					}
				}
				
				//For Shared Files
				$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'");
				$sh_count=mysql_num_rows($shared);
				if($sh_count!=0)
				{
					while($shrow=mysql_fetch_array($shared))
					{	
							if($shrow['Upstatus']!="No DUP")// IF DUP
							{
								if($shrow['File_type']=="Edit")
								{
									$sh_dupe_line=$sh_dupe_line+$shrow['Linecount'];
								}
								if($shrow['File_type']=="Blank")
								{
									$sh_dupb_line=$sh_dupb_line+$shrow['Linecount'];
								}
							}
							else
							{
								if($shrow['File_type']=="Edit")
								{
									$sh_edit_line=$sh_edit_line+$shrow['Linecount'];
								}
								if($shrow['File_type']=="Blank")
								{
									$sh_blank_line=$sh_blank_line+$shrow['Linecount'];
								}
							}
					}
				}
				
				//For Proofing files
				$pr_query="SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Proofed by`='$name' AND `Client`='$cl_name'";
				$pr_result=mysql_query($pr_query);
				$pr_count=mysql_num_rows($pr_result);
				if($pr_count!=0)
				{	
					while($prrow=mysql_fetch_array($pr_result))
					{				
						if($prrow['Upstatus']!="No DUP")
						{	
							if($prrow['Shared']=="YES")
							{
								$f_no=$prrow['File_No'];
								$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no' AND `Client`='$cl_name'");
								while($shrow_dup_p=mysql_fetch_array($shared))
								{
									$sh_pr_duplc=$sh_pr_duplc+$shrow_dup_p['Linecount'];
									//echo $sh_pr_duplc;
								}
							}
							else
							{
								$proofduplines=$proofduplines+$prrow['Linecount'];
							}
						}
						else
						{
							if($prrow['Shared']=="YES")
							{
								$f_no=$prrow['File_No'];
								$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no' AND `Client`='$cl_name'");
								while($shrow_p=mysql_fetch_array($shared))
								{
									$sh_pr_lc=$sh_pr_lc+$shrow_p['Linecount'];
								}
							}
							else
							{
								$prooflines=$prooflines+$prrow['Linecount'];
							}
						}
					}
				}
				$blanklines=$blanklines+$sh_blank_line;
				$blanklines=round($blanklines,$round_value);
				$editlines=$editlines + $sh_edit_line;
				$editlines=round($editlines,$round_value);
				$dup_blank=$dup_blank + $sh_dupb_line;
				$dup_blank=round($dup_blank,$round_value);
				$dup_edit=$dup_edit + $sh_dupe_line;
				$dup_edit=round($dup_edit,$round_value);
				$total_lc=$blanklines + $editlines+$dup_blank+$dup_edit;
				$total_lc=round($total_lc,$round_value);
				$prooflines=$prooflines + $sh_pr_lc;
				$prooflines=round($prooflines,$round_value);
				$proofduplines=$proofduplines + $sh_pr_duplc;
				$proofduplines=round($proofduplines,$round_value);
				$proof_total=$prooflines + $proofduplines;
				$proof_total=round($proof_total,$round_value);
				$final=$total_lc + $proof_total;
				$final=round($final,$round_value);
				$final_proof_lines=$final_proof_lines + $proof_total;
				$final_dupblank_lines=$final_dupblank_lines + $dup_blank;
				$final_dupedit_lines=$final_dupedit_lines + $dup_edit;
				$final_blank_lines=$final_blank_lines + $blanklines;
				$final_edit_lines=$final_edit_lines + $editlines;
				
				if(($up_count!=0) || ($pr_count!=0) || ($sh_count!=0))
				{
				print("$a \t $name($cl_name) \t $blanklines \t $editlines \t $dup_blank \t $dup_edit \t $total_lc \t $prooflines \t $proofduplines \t $proof_total \t $final \r");
				$a=$a+1;
				}
				$final_mls_total=$final_mls_total+$total_lc;
				$final_mls_p_total=$final_mls_p_total+$proof_total;
			}
		}
		$final_mls_f_total=$final_mls_f_total+$final_mls_total+$final_mls_p_total;
		if(($up_count!=0) || ($pr_count!=0) || ($sh_count!=0))
		{
			//print(" \t  \t \t  \t  \t  \t \t \t \t  \t \t  Total + Proofing \t $final_mls_f_total \r");
			//print(" \t  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
		}
		
	}
	
	//For Editors
	print("\t HT EDITOR LINECOUNT  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No \t Name \t DUP Lines\t Second Level Editing \t Third Level Editing \t Auditing \t Total \t  \t  \t  \t \r");
	$c=1;
	$e_sql=mysql_query("select * from `employee` WHERE `Emp_desig`='HT-EDITOR' order by `Emp_no`");
	while($erow=mysql_fetch_array($e_sql))
	{
		$no=$erow['Emp_no'];
		$name=getname($no);
		
		$cl_query="SELECT * FROM `client`";
		
		$cl_result=mysql_query($cl_query);
		
		$cl_count=mysql_num_rows($cl_result);
		
		if($cl_count!=0)
		{
			while($clrow=mysql_fetch_array($cl_result))
			{	
							
				$cl_name=$clrow['Client_name'];
				$edtr_lines=0;
				$th_edtr_lines=0;
				$audit_lines=0;
				$total_editor_lines=0;
				$edtr_dup_lines=0;
				//For Edited Lines
				$ed_query=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Editedby`='$name' AND `Client`='$cl_name'");
				$ed_count=mysql_num_rows($ed_query);
				if($ed_count!=0)
				{
					while($edrow=mysql_fetch_array($ed_query))
					{		
						$edtr_lines=$edtr_lines + $edrow['Linecount'];
					}
					
				}
				
				//For Third Level
				$th_query=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Third_Editor`='$name' AND `Client`='$cl_name'");
				$th_count=mysql_num_rows($th_query);
				if($th_count!=0)
				{
					while($throw=mysql_fetch_array($th_query))
					{		
						$th_edtr_lines=$th_edtr_lines + $throw['Linecount'];
					}
				}		
				
				//For Auditing Files
				$au_query=mysql_query("SELECT * FROM `audit_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Audit_by`='$name' AND `Client`='$cl_name'");
				$au_count=mysql_num_rows($au_query);
				if($au_count!=0)
				{
					while($aurow=mysql_fetch_array($au_query))
					{		
						$audit_lines=$audit_lines + $aurow['Linecount'];
					}
				}	
				
				//For DUP Lines
				$dup_query=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'");
				$dup_count=mysql_num_rows($dup_query);
				if($dup_count!=0)
				{
					while($duprow=mysql_fetch_array($dup_query))
					{		
						$edtr_dup_lines=$edtr_dup_lines + $duprow['Linecount'];
					}
					
				}
				$final_dup_edtr=$final_dup_edtr+$edtr_dup_lines;	
				//final total
				$total_editor_lines=$edtr_lines+$audit_lines+$th_edtr_lines+$edtr_dup_lines;
				
				if(($ed_count!=0) || ($th_count!=0) || ($au_count!=0))	
				{
				print("$c \t $name ($cl_name) \t $edtr_dup_lines \t $edtr_lines \t $th_edtr_lines \t $audit_lines \t $total_editor_lines \r");
				$c=$c+1;
				}			
			}
		}
		
	}
	
	$final_total_lines=$final_blank_lines+$final_edit_lines+$final_dupblank_lines+$final_dupedit_lines;
	$final_proof_total=$final_total_lines+$final_proof_lines;
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Total No. of DUP Blank lines \t  \t $final_dupblank_lines\t  \t  \t  \t  \r");
	print(" \t  \t  \t  \t Total No. of DUP Edit lines \t  \t $final_dupedit_lines \t  \t  \t  \t\r");
	print(" \t  \t  \t  \t Total No. of Blank lines \t  \t $final_blank_lines \t  \t  \t  \t\r");
	print(" \t  \t  \t  \t Total No. of Edit lines \t  \t $final_edit_lines \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Total No. of DUP Lines by Editor \t  \t $final_dup_edtr \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Total No. of lines \t  \t $final_total_lines \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Total No. of Proofed lines \t  \t $final_proof_lines \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Final total + Proofing \t  \t $final_proof_total \t  \t  \t  \t \r");
	
}
mysql_close($con);
?>
