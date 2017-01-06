<?php include('editortop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
.redalert{
color:#FF0000;}
.greenalert{
color:#0066FF;
}
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
        <h2 style="text-align:left;">Weekly report</h2>
        <form name="sub" id="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <center><p class="show">Choose the Date</p></center>
       <table align="center" width="600" cellpadding="2">
        <tr align="center">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/>                 </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> 
                </td>
                <td class="bold">Choose Vendor</td>
                 <td>:</td>
                 <td>
                     <select name="vendor" id="vendor" class="text ui-widget-content ui-corner-all">
                        <option selected="selected" value="-1">--Show All--</option>
                        <?php
                        $sql=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                        while($row=mysql_fetch_array($sql))
                        {
                        $vend=$row['Vendor_name'];
                        echo '<option value="'.$vend.'">'.$vend.'</option>';
                        }
                        ?>
                	</select>
                </td>
            </tr>
        </table>
        <table align="center" width="300" cellpadding="10">
        <tr align="center">
        <td>
        <input type="submit" value="Search" name="search" id="search">
        </td>
        </tr>
        </table>
	</form>
		<!-- div tag for showing results from jscript-->
<?php 
if(isset($_POST['date1'],$_POST['date2'],$_POST['vendor']))
{
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$vendor_q=mysql_real_escape_string($_POST['vendor']);
	$datediff = floor(strtotime($e_date)/(60*60*24)) - floor(strtotime($s_date)/(60*60*24));
	$datediff=$datediff+1;
	echo "<center><p style=\"color:#000; text-align:center;\"><strong>".$datediff." days from ".$s_date." to ".$e_date."</strong></p></center>";
	$name=$_SESSION['idsileditorname'];
	$uploadby=$name;
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$id." has viewed the Weekly report details in IDSIL / PJO from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	echo "<div style=\"width: 850px; height: 450px; border: 0px groove #3b3a3a; overflow: auto;\">";
	echo "<table border=\"1\" width=\"750\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 12px;\" cellpadding=\"3\" cellspacing=\"0\" align=\"center\" >";
	echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Vendor</th><th>Employee Name</th><th>Target (Non DUP)</th><th>Achieved (Non DUP)</th><th>Difference (Non DUP)</th><th>Target (DUP)</th><th>Achieved (DUP)</th><th>Difference (DUP)</th></tr>";
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
	echo "</table></div>";
	echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
	Print "<br><center><form name=\"xl\" method=\"post\" action=\"weeklyreport.php\">";
	Print "<input type=\"hidden\" Value=\"$s_date\" name=\"date1\" id=\"name\" />";
	Print "<input type=\"hidden\" Value=\"$e_date\" name=\"date2\" id=\"name\" />";
	Print "<input type=\"hidden\" Value=\"$vendor_q\" name=\"vendor\" id=\"query\" />";
	Print "<input type=\"submit\" value=\"Get as Excel\" name=\"Weekly Report\"/>";
	Print "</form></center>";
}
?>
<br />
<br />
<div class="cleaner"></div>
<div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
