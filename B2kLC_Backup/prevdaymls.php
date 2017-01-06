<?php
include('dbconfig.php');
echo "<div style=\"width: 850px; height: 450px; border: 0px groove #3b3a3a; overflow: auto;\">";
echo "<table border=\"1\" width=\"750\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 12px;\" cellpadding=\"3\" cellspacing=\"0\" align=\"center\" >";
echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Vendor</th><th>Employee Name</th><th>Target (Non DUP)</th><th>Achieved (Non DUP)</th><th>Difference (Non DUP)</th><th>Target (DUP)</th><th>Achieved (DUP)</th><th>Difference (DUP)</th></tr>";
$a=1;
$emp_q=mysql_query("SELECT `Emp_no`,`Emp_name`,`Vendor` FROM `employee` FORCE INDEX (`Emp_no`) WHERE `Emp_desig`='MLS' OR `Emp_desig`='HT-MLS' order by `Vendor`");
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
	$profile_chk=mysql_query("SELECT `Target_lines`,`DUP_target` FROM `mlsprofile` WHERE `ID`='$e_id'");
	 if(1)
	 {
		 while($p_row=mysql_fetch_array($profile_chk))
		 {
			$non_target=$p_row['Target_lines'];
			$dup_target=$p_row['DUP_target'];
		 }
		$upload_by=$e_row['Emp_name']."-".$e_row['Emp_no'];
		$date=date("Y-m-d", time() - 60 * 60 * 24);
		$lc_q=mysql_query("SELECT `Upstatus`,`Linecount` FROM `file_details` WHERE `Uploadedby`='$upload_by' AND `Date`='$date'");
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
			if($dup_target==0)
			{
				$dup_target="Not Specified";
			}
			echo "<tr align=\"center\"><td>".$a."</td><td>".$vendor."</td><td>".$upload_by."</td><td>".$non_target."</td><td>".$non_lines."</td><td>".$non_diff."</td><td>".$dup_target."</td><td>".$dup_lines."</td><td>".$dup_diff."</td></tr>";
			$a=$a+1;
		
	}
}
echo "</table></div>";
?>