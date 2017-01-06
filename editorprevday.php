<?php
include('dbconfig.php');
echo "<div style=\"width: 850px; height: 450px; border: 0px groove #3b3a3a; overflow: auto;\">";
echo "<table border=\"1\" width=\"750\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 12px;\" cellpadding=\"3\" cellspacing=\"0\" align=\"center\" >";
echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Vendor</th><th>Employee Name</th><th>Editing Target</th><th>Achieved</th><th>Difference </th><th>DUP Target</th><th>Achieved</th><th>Difference</th></tr>";
$a=1;
$emp_q=mysql_query("SELECT `Emp_no`,`Emp_name`,`Vendor` FROM `employee` FORCE INDEX (`Emp_no`) WHERE `Emp_desig`='EDITOR' OR `Emp_desig`='HT-EDITOR' order by `Vendor`");
while($e_row=mysql_fetch_array($emp_q))
{
	$edit_lines=0;
	$dup_lines=0;
	$edit_target=0;
	$dup_target=0;
	$edit_diff=0;
	$dup_diff=0;
	$missing_lines=0;
	$lc_count=0;
	$e_lc_count=0;
	$m_lc_count=0;
	$e_id=trim($e_row['Emp_no']);
	$vendor=trim($e_row['Vendor']);
	$profile_chk=mysql_query("SELECT `Edit_target`,`DUP_target` FROM `editor_profile` WHERE `ID`='$e_id'");
	 if(1)
	 {
		 while($p_row=mysql_fetch_array($profile_chk))
		 {
			$edit_target=$p_row['Edit_target'];
			$dup_target=$p_row['DUP_target'];
		 }
		$upload_by=trim($e_row['Emp_name'])."-".trim($e_row['Emp_no']);
		$upload_by=trim($upload_by);
		$date=date("Y-m-d",time()-60*60*24);
		$lc_q=mysql_query("SELECT `Upstatus`,`Linecount` FROM `file_details` WHERE `Uploadedby`='$upload_by' AND `Date`='$date'");
		$lc_count=mysql_num_rows($lc_q);
		$e_lc_q=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Editedby`='$upload_by' AND `Date`='$date'");
		$e_lc_count=mysql_num_rows($e_lc_q);
		$m_lc_q=mysql_query("SELECT `Linecount` FROM `missing_files` WHERE `Edit_by`='$upload_by' AND `Date`='$date'");
		$m_lc_count=mysql_num_rows($m_lc_q);
		if($lc_count!=0)
		{
			while($lc_row=mysql_fetch_array($lc_q))
			{
				$dup_lines=$dup_lines+$lc_row['Linecount'];	
			}
		}
		if($e_lc_count!=0)
		{
			while($e_lc_row=mysql_fetch_array($e_lc_q))
			{
				$edit_lines=$edit_lines+$e_lc_row['Linecount'];	
			}
		}
		if($m_lc_count!=0)
		{
			while($m_lc_row=mysql_fetch_array($m_lc_q))
			{
				$missing_lines=$missing_lines+$m_lc_row['Linecount'];	
			}
		}
		$edit_diff=$edit_target-$edit_lines-$missing_lines;
		$total_edit=$missing_lines+$edit_lines;
		$dup_diff=$dup_target-$dup_lines;
			if($edit_diff<0)
			{
				$edit_diff="<span class=\"greenalert\">".-($edit_diff)."</span>";
			}
			else
			{
				$edit_diff="<span class=\"redalert\"><b>".$edit_diff."</b></span>";
			}
			if($dup_diff<0)
			{
				$dup_diff="<span class=\"greenalert\">".-($dup_diff)."</span>";
			}
			else
			{
				$dup_diff="<span class=\"redalert\"><b>".$dup_diff."</b></span>";
			}
			if($edit_target==0)
			{
				$edit_target="Not Specified";
			}
			if($dup_target==0)
			{
				$dup_target="Not Specified";
			}
			echo "<tr align=\"center\"><td>".$a."</td><td>".$vendor."</td><td>".$upload_by."</td><td>".$edit_target."</td><td>".$total_edit."</td><td>".$edit_diff."</td><td>".$dup_target."</td><td>".$dup_lines."</td><td>".$dup_diff."</td></tr>";
			$a=$a+1;
		
	}
}
echo "</table></div>";
?>