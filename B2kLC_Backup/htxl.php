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
$final_ndup_edtr=0;
if(isset($_POST['start_ht'],$_POST['end_ht'],$_POST['vendor_ht']))
{
	$s_date=mysql_real_escape_string($_POST['start_ht']);
	$e_date=mysql_real_escape_string($_POST['end_ht']);
	$vendor=mysql_real_escape_string($_POST['vendor_ht']);
	print("\t \t \tHT Line Count details from $s_date to $e_date \r  ");
	$a=1;
	//For MLS
	print("\t HT MLS LINECOUNT  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No. \t Name \t Blank \t Edit \t DUP Blank \t Dup Edit \t Total LineCount \t Proofing \t Proofing / DUP \t Proofing Total \t Final Total \r");
	print("\r ");
	if($vendor==-1)
	{
		$query="select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='HT-MLS' order by `Emp_no`";
		$e_query="select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='HT-EDITOR' order by `Emp_no`";
	}
	else
	{
		$query="select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='HT-MLS' AND `Vendor`='$vendor' order by `Emp_no`";
		$e_query="select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='HT-EDITOR' AND `Vendor`='$vendor' order by `Emp_no`";
	}
	$sql=mysql_query($query);
	while($row1=mysql_fetch_array($sql))
	{
		$no=$row1['Emp_no'];
		$e_name=$row1['Emp_name'];
		$name=$e_name."-".$no;
		$name=mysql_real_escape_string($name);
		$final_mls_total=0;
		$final_mls_p_total=0;
		$final_mls_f_total=0;
		
		$cl_query="SELECT `Client_name` FROM `client`";
		
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
				$up_query="SELECT `Upstatus`,`File_Type`,`Linecount`,`Shared` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'";
				
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
							}
							
							//$total_lc=$total_lc+$uprow['Linecount'];
					}
				}
				
				//For Shared Files
				$shared=mysql_query("SELECT `Upstatus`,`File_type`,`Linecount` FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'");
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
				$pr_query="SELECT `Upstatus`,`Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Proofed by`='$name' AND `Client`='$cl_name'";
				$pr_result=mysql_query($pr_query);
				$pr_count=mysql_num_rows($pr_result);
				if($pr_count!=0)
				{	
					while($prrow=mysql_fetch_array($pr_result))
					{				
						if($prrow['Upstatus']!="No DUP")
						{	
							$proofduplines=$proofduplines+$prrow['Linecount'];
						}
						else
						{
							$prooflines=$prooflines+$prrow['Linecount'];
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
				$prooflines=$prooflines;
				$prooflines=round($prooflines,$round_value);
				$proofduplines=$proofduplines;
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
	}
	
	//For Editors
	print("\t HT EDITOR LINECOUNT  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No \t Name \t DUP (Blank) \t DUP (Edit) \t Non DUP (Blank) \t Non DUP (Edit)\t Second Level Editing \t Third Level Editing \t Missing \t Auditing \t Total \t  \t  \t  \t \r");
	$c=1;
	$tc=0;
	$e_sql=mysql_query($e_query);
	while($erow=mysql_fetch_array($e_sql))
	{
		
		$no=$erow['Emp_no'];
		$e_name=$erow['Emp_name'];
		$name=$e_name."-".$no;
		
		$cl_query="SELECT `Client_name` FROM `client`";
		
		$cl_result=mysql_query($cl_query);
		
		$cl_count=mysql_num_rows($cl_result);
		
		if($cl_count!=0)
		{
			while($clrow=mysql_fetch_array($cl_result))
			{	
				$edtr_lines=0;
				$th_edtr_lines=0;
				$audit_lines=0;
				$total_editor_lines=0;
				$edtr_dup_lines=0;
				$edtr_dup_blank=0;
				$edtr_dup_edit=0;
				$edtr_ndup_blank=0;
				$edtr_ndup_edit=0;
				$edtr_ndup_lines=0;			
				$cl_name=$clrow['Client_name'];
				$missing_lines=0;
			
				//For Edited Lines
				$ed_query=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Editedby`='$name' AND `Client`='$cl_name'");
				$ed_count=mysql_num_rows($ed_query);
				if($ed_count!=0)
				{
					while($edrow=mysql_fetch_array($ed_query))
					{		
						$edtr_lines=$edtr_lines + $edrow['Linecount'];
					}
					
				}
				
				//For Third Level
				$th_query=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Third_Editor`='$name' AND `Client`='$cl_name'");
				$th_count=mysql_num_rows($th_query);
				if($th_count!=0)
				{
					while($throw=mysql_fetch_array($th_query))
					{		
						$th_edtr_lines=$th_edtr_lines + $throw['Linecount'];
					}
				}		
				
				//For Auditing Files
				$au_query=mysql_query("SELECT `Linecount` FROM `audit_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Audit_by`='$name' AND `Client`='$cl_name'");
				$au_count=mysql_num_rows($au_query);
				if($au_count!=0)
				{
					while($aurow=mysql_fetch_array($au_query))
					{		
						$audit_lines=$audit_lines + $aurow['Linecount'];
					}
				}	
				
				//For Missing Files
				$mis_query=mysql_query("SELECT `Linecount` FROM `missing_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Edit_by`='$name' AND `Client`='$cl_name'");
				$mis_count=mysql_num_rows($mis_query);
				if($mis_count!=0)
				{
					while($mis_row=mysql_fetch_array($mis_query))
					{		
						$missing_lines=$missing_lines + $mis_row['Linecount'];
					}
				}
				
				//For DUP Lines
				$dup_query=mysql_query("SELECT `Linecount`,`Upstatus`,`File_Type` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'");
				$dup_count=mysql_num_rows($dup_query);
				if($dup_count!=0)
				{
					
					while($duprow=mysql_fetch_array($dup_query))
					{	
						if($duprow['Upstatus']!="No DUP")// IF DUP
						{	
							$edtr_dup_lines=$edtr_dup_lines + $duprow['Linecount'];
							if($duprow['File_Type']=="Edit")
							{
								$edtr_dup_edit=$edtr_dup_edit+$duprow['Linecount'];
							}
							if($duprow['File_Type']=="Blank")
							{
								$edtr_dup_blank=$edtr_dup_blank+$duprow['Linecount'];
							}
						}
						else
						{
							$edtr_ndup_lines=$edtr_ndup_lines + $duprow['Linecount'];
							if($duprow['File_Type']=="Edit")
							{
								$edtr_ndup_edit=$edtr_ndup_edit+$duprow['Linecount'];
							}
							if($duprow['File_Type']=="Blank")
							{
								$edtr_ndup_blank=$edtr_ndup_blank+$duprow['Linecount'];
							}
						}
					}
				}
				
				//final total
				$total_editor_lines=$edtr_lines+$missing_lines+$audit_lines+$th_edtr_lines+$edtr_dup_lines+$edtr_ndup_lines;
				
				if(($ed_count!=0) || ($th_count!=0) || ($au_count!=0) || ($dup_count!=0))	
				{
					print("$c \t $name ($cl_name) \t $edtr_dup_blank \t $edtr_dup_edit \t $edtr_ndup_blank \t $edtr_ndup_edit \t $edtr_lines \t $th_edtr_lines \t $missing_lines \t $audit_lines \t $total_editor_lines \r");
					$c=$c+1;
				}			
			}
		}
		$final_dup_edtr=$final_dup_edtr+$edtr_dup_lines;
		$final_ndup_edtr=$final_ndup_edtr+$edtr_ndup_lines;
	}
	
	$final_total_lines=$final_blank_lines+$final_edit_lines+$final_dupblank_lines+$final_dupedit_lines+$final_dup_edtr+$final_ndup_edtr;
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
	print(" \t  \t  \t  \t Total No. of Non DUP Lines by Editor \t  \t $final_ndup_edtr \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Total No. of DUP Lines by Editor \t  \t $final_dup_edtr \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Total No. of lines \t  \t $final_total_lines \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Total No. of Proofed lines \t  \t $final_proof_lines \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t Final total + Proofing \t  \t $final_proof_total \t  \t  \t  \t \r");
	
}
mysql_close($con);
?>
