<?php
session_start();
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
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
		$file_type = "x-msdownload";
		$date=date("Y-F-d");
		$fname="INHOUSE_Line_Count_".$date;
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
		header("location:index.php?msg4=NotAllowed"); 
	}
}
$final_blank_lines=0;
$final_edit_lines=0;
$final_total_lines=0;
$final_dupblank_lines=0;
$final_dupedit_lines=0;
$final_proof_lines=0;
$final_proof_total=0;
$final_dup_edtr=0;
$final_ndup_edtr=0;
if(isset($_POST['start'],$_POST['end']))
{
	$s_date=$_POST['start'];
	$e_date=$_POST['end'];
	print("\t \t \t Line Count details from $s_date to $e_date \r  ");
	$a=1;
	//For MLS
	print("\t INHOUSE MLS LINECOUNT  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No. \t Name \t Blank \t Edit \t DUP Blank \t Dup Edit \t Total LineCount \t Proofing \t Proofing / DUP \t Proofing Total \t Final Total \t Double pay \r");
	print("\r");
	$sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='MLS' order by `Emp_no`");
	while($row1=mysql_fetch_array($sql))
	{
		$no=$row1['Emp_no'];
		$e_name=$row1['Emp_name'];
		$name=$e_name."-".$no;
		$no=mysql_real_escape_string($no);
		$name=mysql_real_escape_string($name);
		$final_mls_total=0;
		$final_mls_p_total=0;
		$final_mls_f_total=0;
		$flag=0;
		if($flag==0)
		{
			$doublepay=0;
			$mls_query=mysql_query("SELECT `Double_pay` FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$no'");
			$mls_count=mysql_num_rows($mls_query);
			if($mls_count!=0)
			{
				while($mlsrow=mysql_fetch_array($mls_query))
				{	
					if($mlsrow['Double_pay']=="YES")
					{
						$doublepay=$doublepay+1;
						$flag=1;
					}
				}
			}
		}
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
				//$doublepay=0;
				$up_query="SELECT `Upstatus`,`File_Type`,`Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'";
				
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
				$pr_query="SELECT `Upstatus`,`Shared`,`File_No`,`Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Proofed by`='$name' AND `Client`='$cl_name'";
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
								$shared=mysql_query("SELECT `Linecount` FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no' AND `Client`='$cl_name'");
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
								$shared=mysql_query("SELECT `Linecount` FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no' AND `Client`='$cl_name'");
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
					if($flag==1)
					{
						$double=$doublepay;
						$flag=0;
					}				
					else
					{
						$double='';
					}
					print("$a \t $name ($cl_name) \t $blanklines \t $editlines \t $dup_blank \t $dup_edit \t $total_lc \t $prooflines \t $proofduplines \t $proof_total \t $final \t $double\r");
					$a=$a+1;
				}
				$final_mls_total=$final_mls_total+$total_lc;
				$final_mls_p_total=$final_mls_p_total+$proof_total;
			}
		}
		$final_mls_f_total=$final_mls_f_total+$final_mls_total+$final_mls_p_total;
		/*if(($up_count!=0) || ($pr_count!=0) || ($sh_count!=0))
		{
			print(" \t  \t \t  \t  \t  \t \t \t \t  Total + Proofing \t $final_mls_f_total \r");
			print(" \t  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
		}
		*/
		
	}
	
	//For Editors
	print("\t \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("\t INHOUSE EDITOR LINECOUNT  \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No \t Name \t Second Level Editing \t Third Level Editing \t Missing \t Auditing \t DUP (Blank) \t DUP (Edit) \t Non DUP (Blank) \t Non DUP (Edit) \t Total \t Double pay \t  \t  \t \r");
	$c=1;
	$e_sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='EDITOR' order by `Emp_no`");
	while($erow=mysql_fetch_array($e_sql))
	{
		$no=$erow['Emp_no'];
		$e_name=$erow['Emp_name'];
		$name=$e_name."-".$no;
		$flag=0;
		if($flag==0)
		{
			$doublepay=0;
			$edt_query=mysql_query("SELECT `Double_pay` FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$no'");
			$edt_count=mysql_num_rows($edt_query);
			if($edt_count!=0)
			{
				while($edtrow=mysql_fetch_array($edt_query))
				{	
					if($edtrow['Double_pay']=="YES")
					{
						$doublepay=$doublepay+1;
						$flag=1;
					}
				}
			}
		}
		
		$cl_query="SELECT `Client_name` FROM `client`";
		
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
				$missing_lines=0;
				$total_editor_lines=0;
				$edtr_dup_lines=0;
				$edtr_dup_blank=0;
				$edtr_dup_edit=0;
				$edtr_ndup_blank=0;
				$edtr_ndup_edit=0;
				$edtr_ndup_lines=0;
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
				$final_dup_edtr=$final_dup_edtr+$edtr_dup_lines;	
				$final_ndup_edtr=$final_ndup_edtr+$edtr_ndup_lines;	
				//final total
				$total_editor_lines=$edtr_lines+$missing_lines+$audit_lines+$th_edtr_lines+$edtr_dup_lines+$edtr_ndup_lines;
				
				if(($ed_count!=0) || ($th_count!=0) || ($au_count!=0) || ($dup_count!=0))	
				{
					if($flag==1)
					{
						$double=$doublepay;
						$flag=0;
					}				
					else
					{
						$double='';
					}
					print("$c \t $name ($cl_name) \t $edtr_lines \t $th_edtr_lines \t $missing_lines \t $audit_lines \t $edtr_dup_blank \t $edtr_dup_edit \t  $edtr_ndup_blank \t $edtr_ndup_edit \t $total_editor_lines \t $double\r");
					$c=$c+1;
				}			
			}
		}
		
	}
	print("\t \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("\t ADMINISTRATOR \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No \t Name \t Extra Hours Worked \t Extra Days \t Double Pay days \t  \t  \t  \t  \t \r");
	$b=1;
	$a_sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='ADMINISTRATOR' order by `Emp_no`");
	while($arow=mysql_fetch_array($a_sql))
	{
		$no=$arow['Emp_no'];
		$e_name=$arow['Emp_name'];
		$name=$e_name."-".$no;
		$extrahrs=0;
		$doublepay=0;
		$ad_query=mysql_query("SELECT `Double_pay`,`Extra_hrs` FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$no'");
		$ad_count=mysql_num_rows($ad_query);
		if($ad_count!=0)
		{
			while($adrow=mysql_fetch_array($ad_query))
			{	
				$extrahrs=$extrahrs + $adrow['Extra_hrs'];
				if($adrow['Double_pay']=="YES")
				{
					$doublepay=$doublepay+1;
				}
			}
			print("$b \t $name \t $extrahrs \t \t $doublepay \r");
			$b=$b+1;
		}
	}
	
	print("\t \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("\t TRAINER Details \t \t  \t  \t  \t  \t  \t  \t  \t \r");
	print("S.No \t Name \t No of Hours \t \t  \t  \t  \t  \t \r");
	$d=1;
	$t_sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` order by `Emp_no`");
	while($trow=mysql_fetch_array($t_sql))
	{
		$no=$trow['Emp_no'];
		$e_name=$trow['Emp_name'];
		$name=$e_name."-".$no;
		$trainedhrs=0;
		$tr_query=mysql_query("SELECT `No_of_hours` FROM `training` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Trainee_name`='$name'");
		$tr_count=mysql_num_rows($tr_query);
		if($tr_count!=0)
		{
			while($trrow=mysql_fetch_array($tr_query))
			{	
				$trainedhrs=$trainedhrs + $trrow['No_of_hours'];
			}
		print("$d \t $name \t $trainedhrs \r");
		$d=$d+1;
		}
	}
	
	
	$final_total_lines=$final_blank_lines+$final_edit_lines+$final_dupblank_lines+$final_dupedit_lines+$final_dup_edtr+$final_ndup_edtr;
	$final_proof_total=$final_total_lines+$final_proof_lines;
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t Total No. of DUP Blank lines \t  \t $final_dupblank_lines\t  \t  \t  \t  \r");
	print(" \t  \t Total No. of DUP Edit lines \t  \t $final_dupedit_lines \t  \t  \t  \t\r");
	print(" \t  \t Total No. of Blank lines \t  \t $final_blank_lines \t  \t  \t  \t\r");
	print(" \t  \t Total No. of Edit lines \t  \t $final_edit_lines \t  \t  \t  \t \r");
	print(" \t  \t Total No. of DUP Lines by Editor \t  \t $final_dup_edtr \t  \t  \t  \t \r");
	print(" \t  \t Total No. of Non DUP Lines by Editor \t  \t $final_ndup_edtr \t  \t  \t  \t \r");
	print(" \t  \t Total No. of lines \t  \t $final_total_lines \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t Total No. of Proofed lines \t  \t $final_proof_lines \t  \t  \t  \t \r");
	print(" \t  \t Final total + Proofing \t  \t $final_proof_total \t  \t  \t  \t \r");
	
}
mysql_close($con);
?>
