<?php
include('dbconfig.php');
include('global.php');	
$file_type = "x-msdownload";
$date=date("Y-F-d");
$fname="MLS_Line_Count_".$date;
$file_ending = "xls";
HEADER("Content-Type: application/$file_type");
HEADER("Content-Disposition: attachment; filename=$fname.$file_ending");
HEADER("Pragma: no-cache");
HEADER("Expires: 0");
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
	print("\t \t \t MLS Line Count details from $s_date to $e_date \r  ");
	$a=1;
	print("S.No. \t Name \t Blank \t Edit \t DUP Blank \t Dup Edit \t Total LineCount \t Proofing \t Proofing / DUP \t Proofing Total \t Final Total \r");
	print("\r \r \r");
	$sql=mysql_query("select * from `employee` WHERE `Emp_desig`='MLS' order by `Emp_no`");
	while($row1=mysql_fetch_array($sql))
	{
		$no=$row1['Emp_no'];
		$name=getname($no);
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
		$up_query="SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'";
		
		$up_result=mysql_query($up_query);
		
		$up_count=mysql_num_rows($up_result);
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
							$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'");
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
		
		$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name'");
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
		$pr_query="SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Proofed by`='$name'";
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
						$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no'");
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
						$shared=mysql_query("SELECT * FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no'");
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
		$editlines=$editlines+$sh_edit_line;
		$editlines=round($editlines,$round_value);
		$dup_blank=$dup_blank+$sh_dupb_line;
		$dup_blank=round($dup_blank,$round_value);
		$dup_edit=$dup_edit+$sh_dupe_line;
		$dup_edit=round($dup_edit,$round_value);
		$total_lc=$blanklines+$editlines+$dup_blank+$dup_edit;
		$total_lc=round($total_lc,$round_value);
		$prooflines=$prooflines+$sh_pr_lc;
		$prooflines=round($prooflines,$round_value);
		$proofduplines=$proofduplines+$sh_pr_duplc;
		$proofduplines=round($proofduplines,$round_value);
		$proof_total=$prooflines+$proofduplines;
		$proof_total=round($proof_total,$round_value);
		$final=$total_lc+$proof_total;
		$final=round($final,$round_value);
		$final_proof_lines=$final_proof_lines+$proof_total;
		$final_dupblank_lines=$final_dupblank_lines+$dup_blank;
		$final_dupedit_lines=$final_dupedit_lines+$dup_edit;
		$final_blank_lines=$final_blank_lines+$blanklines;
		$final_edit_lines=$final_edit_lines+$editlines;
		
		print("$a \t $name \t $blanklines \t $editlines \t $dup_blank \t $dup_edit \t $total_lc \t $prooflines \t $proofduplines \t $proof_total \t $final \r");
		$a=$a+1;
	}
	
	$final_total_lines=$final_blank_lines+$final_edit_lines+$final_dupblank_lines+$final_dupedit_lines;
	$final_proof_total=$final_total_lines+$final_proof_lines;
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t Total No. of DUP Blank lines \t  \t $final_dupblank_lines\r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t Total No. of DUP Edit lines \t  \t $final_dupedit_lines\r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t Total No. of Blank lines \t  \t $final_blank_lines\r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t Total No. of Edit lines \t  \t $final_edit_lines\r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t Total No. of lines \t  \t $final_total_lines\r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t  \t  \t \r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t Total No. of Proofed lines \t  \t $final_proof_lines\r");
	print(" \t  \t  \t  \t  \t  \t  \t  \t Final total + Proofing \t  \t $final_proof_total\r");
	
}
?>
