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
?>
<style>
.ui-widget-header { border: 1px solid #4297d7; background: #5c9ccc; color: #ffffff; font-weight: bold; }
</style>
<?
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
	$non_dup_blank_paise=0.65;
	$non_dup_edit_paise=0.40;
	$dup_blank_paise=1.10;
	$dup_edit_paise=0.80;
	$proofing_paise=0.40;
	$proofing_dup_paise=0.50;
	echo "<center>Line Count details from $s_date to $e_date</center>";
	$a=1;
	//For MLS
	echo "<b>INHOUSE MLS LINECOUNT</b><br>";
	echo "<b>Paise Details</b><br>";
	echo "<table border=\"1\" cellspacing=\"0\" style=\"font-size:12px;\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No</th><th> Particulars </th><th> Paise </th></tr>";	
	echo "<tr><td>01</td><td> Blank </td><td align=\"center\"> $non_dup_blank_paise </td></tr>";
	echo "<tr><td>02</td><td> Edit </td><td align=\"center\"> $non_dup_edit_paise </td></tr>";
	echo "<tr><td>03</td><td> DUP Blank </td><td align=\"center\"> $dup_blank_paise </td></tr>";
	echo "<tr><td>04</td><td> DUP Edit </td><td align=\"center\"> $dup_edit_paise </td></tr>";
	echo "<tr><td>05</td><td> Proofing </td><td align=\"center\"> $proofing_paise </td></tr>";
	echo "<tr><td>06</td><td> Proofing DUP </td><td align=\"center\"> $proofing_dup_paise </td></tr>";
	echo "</table><br>";
	echo "<table border=\"1\" cellspacing=\"0\" style=\"font-size:12px;\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No. </th><th> Name </th><th> Blank </th><th> Edit </th><th> DUP Blank </th><th> Dup Edit </th><th> Total LineCount </th><th> Proofing </th><th> Proofing / DUP </th><th> Proofing Total </th><th> Final Total </th><th> Double pay </th><th> Salary </th><th> Added Salary</th><th>Last Month</th><th>Incentive</th><th>Salary Before PF</th><th>PF</th><th>Salary After PF</th></tr>";
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
				$blanklines_salary=0;
				$editlines_salary = 0;
				$dup_blank_salary = 0;
				$dup_edit_salary = 0;
				$prooflines_salary = 0;
				$proofduplines_salary = 0;
				$total_salary = 0;
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
					$blanklines_salary = $blanklines * $non_dup_blank_paise;
					$editlines_salary = $editlines * $non_dup_edit_paise;
					$dup_blank_salary = $dup_blank * $dup_blank_paise;
					$dup_edit_salary = $dup_edit * $dup_edit_paise;
					$prooflines_salary = $prooflines * $proofing_paise;
					$proofduplines_salary = $proofduplines * $proofing_dup_paise;
					$total_salary = $blanklines_salary + $editlines_salary + $dup_blank_salary + $dup_edit_salary + $prooflines_salary + $proofduplines_salary;
					$total_salary = round($total_salary,$round_value);
					echo "<tr><td>$a </td><td> $name ($cl_name) </td><td> $blanklines </td><td> $editlines </td><td> $dup_blank </td><td> $dup_edit </td><td> $total_lc </td><td> $prooflines </td><td> $proofduplines </td><td> $proof_total </td><td> $final </td><td> $double</td><td>$total_salary </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td></tr>";
					$a=$a+1;
				}
				$final_mls_total=$final_mls_total+$total_lc;
				$final_mls_p_total=$final_mls_p_total+$proof_total;
			}
		}
		$final_mls_f_total=$final_mls_f_total+$final_mls_total+$final_mls_p_total;
	}
	echo "</table><br><br>";

	//For Editors
	echo "<b>INHOUSE EDITOR LINECOUNT</b><br>";
	$editing_paise=0.50;
	$third_editing_paise=0.40;
	$missing_paise=$editing_paise;
	$auditing_paise=0.50;
	$non_dup_blank_paise=0.65;
	$non_dup_edit_paise=0.40;
	$dup_blank_paise=1.20;
	$dup_edit_paise=0.80;
	echo "<b>Paise Details</b><br>";
	echo "<table border=\"1\" cellspacing=\"0\" style=\"font-size:12px;\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No</th><th> Particulars </th><th> Paise </th></tr>";	
	echo "<tr><td>01</td><td> Second Level / Missing </td><td align=\"center\"> $editing_paise </td></tr>";
	echo "<tr><td>02</td><td> Third Level </td><td align=\"center\"> $third_editing_paise </td></tr>";
	echo "<tr><td>03</td><td> Auditing </td><td align=\"center\"> $auditing_paise </td></tr>";
	echo "<tr><td>04</td><td> DUP Blank </td><td align=\"center\"> $dup_blank_paise </td></tr>";
	echo "<tr><td>05</td><td> DUP Edit </td><td align=\"center\"> $dup_edit_paise </td></tr>";
	echo "<tr><td>06</td><td> Non DUP Blank </td><td align=\"center\"> $non_dup_blank_paise </td></tr>";
	echo "<tr><td>07</td><td> Non DUP Edit </td><td align=\"center\"> $non_dup_edit_paise </td></tr>";
	echo "</table><br>";
	echo "<table border=\"1\" cellspacing=\"0\" style=\"font-size:12px;\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No </th><th> Name </th><th> Second Level Editing </th><th> Third Level Editing </th><th> Missing </th><th> Auditing </th><th> DUP (Blank) </th><th> DUP (Edit) </th><th> Non DUP (Blank) </th><th> Non DUP (Edit) </th><th> Total </th><th> EScription </th><th> Double pay </th><th> Salary </th><th> Added Salary </th><th> Last month </th><th> Incentive </th><th> Salary Before PF </th><th> PF </th><th> Salary After PF </th></tr>";
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
				$second_level_salary = 0;
				$third_level_salary = 0;
				$missing_salary = 0;
				$auditing_salary = 0;
				$non_dup_blank_salary = 0; 
				$non_dup_edit_salary = 0;
				$dup_blank_salary = 0;
				$dup_edit_salary = 0;
				$total_salary = 0;
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
					$editing_paise=0.50;
					$third_editing_paise=0.40;
					$missing_paise=$editing_paise;
					$auditing_paise=0.50;
					$non_dup_blank_paise=0.65;
					$non_dup_edit_paise=0.40;
					$dup_blank_paise=1.20;
					$dup_edit_paise=0.80;
					$second_level_salary = $edtr_lines * $editing_paise;
					$third_level_salary = $th_edtr_lines * $third_editing_paise;
					$missing_salary = $missing_lines * $missing_paise;
					$auditing_salary = $audit_lines * $auditing_paise;
					$non_dup_blank_salary = $edtr_ndup_blank * $non_dup_blank_paise; 
					$non_dup_edit_salary = $edtr_ndup_edit * $non_dup_edit_paise;
					$dup_blank_salary = $edtr_dup_blank * $dup_blank_paise;
					$dup_edit_salary = $edtr_dup_edit * $dup_edit_paise;
					$total_salary = $second_level_salary + $third_level_salary + $missing_salary + $auditing_salary + $non_dup_blank_salary + $non_dup_edit_salary + $dup_blank_salary + $dup_edit_salary;
					$total_salary = round($total_salary,2);
					echo "<tr> <td> $c </td><td> $name ($cl_name) </td><td> $edtr_lines </td><td> $th_edtr_lines </td><td> $missing_lines </td><td> $audit_lines </td><td> $edtr_dup_blank </td><td> $edtr_dup_edit </td><td>  $edtr_ndup_blank </td><td> $edtr_ndup_edit </td><td> $total_editor_lines </td><td> </td><td> $double </td><td> $total_salary </td><td> </td><td>  </td><td>  </td><td>  </td><td>  </td><td>  </td></tr>";
					$c=$c+1;
				}			
			}
		}
	}
	echo "</table><br><br>";
	//Administrator
	echo "<b>ADMINISTRATOR </b><br>";
	echo "<table border=\"1\" cellspacing=\"0\" style=\"font-size:12px;\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No </th><th> Name </th><th> Allowed Leave </th><th> Leave Taken </th><th> Remaining Days </th><th> Extra Hours Worked </th><th> Extra Days </th><th> Double Pay days </th><th> Consolidated Pay </th><th> Perday Salary </th><th> Night Shift </th><th> N S Allowance </th><th> Salary Before PF</th><th> PF </th><th> Salary After PF </th></tr>";
	$b=1;
	$a_sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='ADMINISTRATOR' order by `Emp_no`");
	while($arow=mysql_fetch_array($a_sql))
	{
		$no=$arow['Emp_no'];
		$e_name=$arow['Emp_name'];
		$name=$e_name."-".$no;
		$extrahrs=0;
		$doublepay=0;
		$leave_taken=0;
		$remaining_days=0;
		$night_shift_days=0;
		$allowed_leave=6;
		$ad_query=mysql_query("SELECT `Full/Half/Leave`,`Double_pay`,`Extra_hrs` FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$no'");
		$ad_count=mysql_num_rows($ad_query);
		if($ad_count!=0)
		{
			while($adrow=mysql_fetch_array($ad_query))
			{	
				$extrahrs=$extrahrs + $adrow['Extra_hrs'];
				if($adrow['Full/Half/Leave']=="Leave")
				{
					$leave_taken=$leave_taken+1;
				}
				if($adrow['Full/Half/Leave']=="Night")
				{
					$night_shift_days=$night_shift_days+1;
				}
				if($adrow['Double_pay']=="YES")
				{
					$doublepay=$doublepay+1;
				}
			}
			$extra_days=$extrahrs/10;
			$remaining_days=$allowed_leave-$leave_taken;
			
			//echo "<tr><td>$b </td><td> $name </td><td> $extrahrs </td><td> $extra_days </td><td> $doublepay </tr>";
			echo "<tr align=\"center\"><td> $b </td><td align=\"left\"> $name </td><td> $allowed_leave </td><td> $leave_taken </td><td> $remaining_days </td><td> $extrahrs </td><td> $extra_days </td><td> $doublepay </td><td>  </td><td>  </td><td> $night_shift_days </td><td> </td><td> </td><td>  </td><td>  </td></tr>";
			$b=$b+1;
		}
	}
	echo "</table><br><br>";
	echo "<b>TRAINER Details</b>";
	echo "<table border=\"1\" cellspacing=\"0\" style=\"font-size:12px;\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No </th><th> Name </th><th> No of Hours </th><th> Consolidated Pay </th><th> Salary Before PF </th><th> PF </th><th> Salary After PF </th></tr>";
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
		echo "<tr align=\"center\"><td>$d </td><td> $name </td><td> $trainedhrs </td><td> </td><td> </td><td> </td><td> </td></tr>";
		$d=$d+1;
		}
	}
	echo "</table><br><br>";
	
	$final_total_lines=$final_blank_lines+$final_edit_lines+$final_dupblank_lines+$final_dupedit_lines+$final_dup_edtr+$final_ndup_edtr;
	$final_proof_total=$final_total_lines+$final_proof_lines;
	echo "<table border=\"1\" cellspacing=\"0\" style=\"font-size:12px;\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No</th><th>Particulars</th><th>Total Lines</th></tr>";
	echo "<tr><td>1</td><td>Total No. of DUP Blank lines </td><td> $final_dupblank_lines </td></tr>";
	echo "<tr><td>2</td><td>Total No. of DUP Edit lines </td><td> $final_dupedit_lines </td></tr>";
	echo "<tr><td>3</td><td>Total No. of Blank lines </td><td> $final_blank_lines </td></tr>";
	echo "<tr><td>4</td><td>Total No. of Edit lines </td><td> $final_edit_lines </td></tr>";
	echo "<tr><td>5</td><td>Total No. of DUP Lines by Editor </td><td> $final_dup_edtr </td></tr>";
	echo "<tr><td>6</td><td>Total No. of Non DUP Lines by Editor </td><td> $final_ndup_edtr </td></tr>";
	echo "<tr><td>7</td><td>Total No. of lines </td><td> $final_total_lines </td></tr>";
	echo "<tr><td>8</td><td>Total No. of Proofed lines </td><td> $final_proof_lines </td></tr>";
	echo "<tr><td>9</td><td>Final total + Proofing </td><td> $final_proof_total </td></tr>";
	echo "</table>";
	
}
mysql_close($con);
?>
