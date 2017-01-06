<?php
include('dbconfig.php');
echo "<div style=\"width: 850px; height: 450px; border: 0px groove #3b3a3a; overflow: auto;\">";
$leave_q=mysql_query("SELECT `S.No`,`Employee_ID`,`Employee_Name`,`Leave_Date`,`Purpose`,`Timings`,`Permission_status` FROM  `leave_request`");
$count_leave=mysql_num_rows($leave_q);
if($count_leave!=0)
{
	$a=1;
	$leave_req=0;
	echo "<table border=\"1\" cellpadding=\"3\" cellspacing=\"0\" class=\"ui-widget ui-widget-content ui-corner-all\" align=\"center\" width=\"750\">";
	echo "<tr class=\"ui-widget-header\"><th>S.No</th><th>Leave Date</th><th>Name-ID</th><th>Purpose</th><th>Timings</th><th>Status</th></tr>";
	while($c_row=mysql_fetch_array($leave_q))
	{
		if($c_row['Permission_status']=="Pending")
		{
			$leave_req=$leave_req+1;
		}
		else
		{
			echo "<tr>";
			echo "<td align=\"center\">
				<table><tr><td>".$a."</td><td style=\"border:0px;\"><img src=\"menu/notes.png\" title=\"Edit file details\" height=\"20\" width=\"20\"  style=\"cursor:pointer;\" onclick=\"update('".$c_row['S.No']."');\"></td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$c_row['S.No']."');\"></td></tr></table>
				</td> "; 
			echo "<td align=\"center\">".$c_row['Leave_Date']."</td>";
			echo "<td align=\"center\">".$c_row['Employee_Name']."-".$c_row['Employee_ID']."</td>";
			echo "<td align=\"center\">".$c_row['Timings']."</td>";
			echo "<td align=\"center\" style=\"width:200px;\">".$c_row['Purpose']."</td>";
			echo "<td align=\"center\">".$c_row['Permission_status']."</td>";
			echo "</tr>";
			$a=$a+1;
		}
	}
	echo "</table>";
	if($leave_req!=0)
	{
		echo '<p style="padding-top:10px; padding-left:30px; text-align:left;"><span class="ui-icon ui-icon-check" style="float: left; margin-right: .3em;"></span>';
		echo "<strong>Today ".$leave_req." Members have requested Leave <a href=\"confirmleave.php\">Click here</a> to see that</strong></p>";
	}
	else
	{
		echo '<p style="padding-top:10px; padding-left:50px; text-align:left;"><span class="ui-icon ui-icon-check" style="float: left; margin-right: .3em;"></span>';
		echo "<strong>No Request has received</strong></p>";
	}
}
else
{
	echo "<p>No request received</p>";
}
echo "</div>";
?>