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
if(isset($_POST['date1'],$_POST['date2'],$_POST['vendor']))
{
	include('dbconfig.php');
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$vendor_q=mysql_real_escape_string($_POST['vendor']);
	$datediff = floor(strtotime($e_date)/(60*60*24)) - floor(strtotime($s_date)/(60*60*24));
	$datediff=$datediff+1;
	echo "<center><p style=\"color:#000; text-align:center;\"><strong>".$datediff." days from ".$s_date." to ".$e_date."</strong></p></center>";
	echo "<table border=\"1\" width=\"750\" style=\"font-size: 12px;\" cellpadding=\"3\" cellspacing=\"0\" align=\"center\" >";
	echo "<tr><th>S.No.</th><th>Vendor</th><th>Employee Name</th><th>Target (Non DUP)</th><th>Achieved (Non DUP)</th><th>Difference (Non DUP)</th><th>Target (DUP)</th><th>Achieved (DUP)</th><th>Difference (DUP)</th></tr>";
	$a=1;
	if($vendor_q=='-1')
	{
		$query="SELECT `Emp_no`,`Emp_name`,`Vendor`,`Emp_desig` FROM `employee` ORDER BY `Vendor`";
	}
	else
	{
		$query="SELECT `Emp_no`,`Emp_name`,`Vendor`,`Emp_desig` FROM `employee` WHERE `Vendor`='$vendor_q' ORDER BY `Vendor`";
	}
	
	$emp_q=mysql_query($query);
	while($e_row=mysql_fetch_array($emp_q))
	{
		$non_lines=0;
		$dup_lines=0;
		$non_target=0;
		$dup_target=0;
		$non_diff=0;
		$dup_diff=0;
		$e_id=$e_row['Emp_no'];
		$vendor=$e_row['Vendor'];
		$desig=$e_row['Emp_desig'];
		if(($desig=="MLS") || ($desig=="HT-MLS"))
		{
			$profile_chk=mysql_query("SELECT `Target_lines`,`DUP_target` FROM `mlsprofile` WHERE `ID`='$e_id'");
			 if(1)
			 {
				 while($p_row=mysql_fetch_array($profile_chk))
				 {
					$non_target=$p_row['Target_lines'];
					$dup_target=$p_row['DUP_target'];
				 }
				$upload_by=$e_row['Emp_name']."-".$e_row['Emp_no'];
				$date=date("Y-m-d");
				$lc_q=mysql_query("SELECT `Upstatus`,`Linecount` FROM `file_details` WHERE `Uploadedby`='$upload_by' AND `Date` BETWEEN '$s_date' AND '$e_date'");
				$lc_count=mysql_num_rows($lc_q);
					while($lc_row=mysql_fetch_array($lc_q))
					{
						if($lc_row['Upstatus']=="No DUP")
						{
							$non_lines=$non_lines+$lc_row['Linecount'];
						}
						else
						{
							$dup_lines=$dup_lines+$lc_row['Linecount'];	
						}
					}
					$non_target=$non_target*$datediff;
					$dup_target=$dup_target*$datediff;
					$non_diff=$non_target-$non_lines;
					$dup_diff=$dup_target-$dup_lines;
					if($non_diff<0)
					{
						$non_diff="<span class=\"greenalert\">".-($non_diff)."</span>";
					}
					else
					{
						$non_diff="<span class=\"redalert\"><b>".$non_diff."</b></span>";
					}
					if($dup_diff<0)
					{
						$dup_diff="<span class=\"greenalert\">".-($dup_diff)."</span>";
					}
					else
					{
						$dup_diff="<span class=\"redalert\"><b>".$dup_diff."</b></span>";
					}
					if($non_target==0)
					{
						$non_target="Not Specified";
					}
					else
					{
						$non_target=$non_target."<br>(".$datediff." days )";
					}
					if($dup_target==0)
					{
						$dup_target="Not Specified";
					}
					else
					{
						$dup_target=$dup_target."<br>(".$datediff." days )";
					}
					echo "<tr align=\"center\"><td>".$a."</td><td>".$vendor."</td><td>".$upload_by."</td><td>".$non_target."</td><td>".$non_lines."</td><td>".$non_diff."</td><td>".$dup_target."</td><td>".$dup_lines."</td><td>".$dup_diff."</td></tr>";
					$a=$a+1;
				
			}
		}
	}
	echo "</table>";
}
?>