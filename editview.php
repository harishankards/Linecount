<?php include('editortop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
#holder 
{
	height: 260px;
	margin-left:-40px;
	width: 820px;
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
        <h2>Edited File Details </h2>
        <form name="sub" id="sub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <center>
        <table align="center" width="400" cellpadding="5">
        <tr align="center">
        <td class="show">Choose the Date to See the Edited files</td>
		</tr>
        </table>
        </center>
        <table align="center" width="500" cellpadding="2">
        <tr align="center">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
            </tr>
        </table>
        <table align="center" width="400" cellpadding="10">
        <tr align="center">
        <td>
        <input type="submit" value="Search" name="search" id="search">
        </td>
        </tr>
        </table>
	</form>
		<!-- div tag for showing results from jscript-->
<?php 
if(isset($_POST['date1'],$_POST['date2']))
{

	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$name=$_SESSION['idsileditorname'];
	$uploadby=$name;
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$id." has viewed the Edited file details in IDSIL/PJO from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$c=1;
	$r=0;
	$lc=0;
	$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`File_Type`,`Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND	`Editedby`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{	echo "<center><p class=\"show\">Search Results from $s_date to $e_date</p>";
		echo "<p style=\"text-align:left; padding-left:70px; color:#000; font-size:16px;\">Productivity Chart</p>";
		$datediff = floor(strtotime($e_date)/(60*60*24)) - floor(strtotime($s_date)/(60*60*24));
		?>
		<table id="data">
            <tfoot>
                <tr>
                    <?
					$start_date=$s_date;
					for($i=0;$i<=$datediff;$i++)
					{
					   $start_d=explode("-",$start_date);
					   echo "<th>".$start_d[2]."</th>";
						//echo $dat;
						$t_lines=0;
						$graph_q=mysql_query("SELECT `Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date`='$start_date' AND	`Editedby`='$name'");
						while($c_row=mysql_fetch_array($graph_q))
						{
							$t_lines=$t_lines+$c_row['Linecount'];
						}
						$lines[]=$t_lines;
						$start_date = strftime("%Y-%m-%d", strtotime("$start_date +1 day"));
					}
					?>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <?
					for($j=0;$j<=$datediff;$j++)
					{
						
						echo "<td>".$lines[$j]."</td>";
					}
					?>
                </tr>
            </tbody>
        </table>
       <div id="holder"></div>
       <?
	   echo "<center><strong>This graph shows your productivity from ".$s_date." to ".$e_date.".</strong></center><br>";
	   echo "<p style=\"text-align:left; padding-left:70px; color:#000; font-size:16px;\">Linecount Details</p>";
		echo "<center><table><tr align=\"center\">
        <td>
        <input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only
        </td>
        </tr></table>";
		echo "<div id=\"detail\" style=\"width: 770px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" width=\"750\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" cellpadding=\"3\" cellspacing=\"0\">";
		echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>File Type</th><th>LineCount</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Hospital'])."</td>";
			echo "<td>".htmlentities($row['File_No'])."</td>";
			echo "<td>".htmlentities($row['File_Type'])."</td>";
			echo "<td>".htmlentities($row['Linecount'])."</td>";
			$lc=$lc+$row['Linecount'];
			echo "</tr>";
			$c=$c+1;
			if($r==0)
			{
				$r=1;
			}
			else
			{
				$r=0;
			}
		}
		echo "</table>";
		echo "</div>";
		echo "<table>";
		echo "<tr class=\"result1\"><td>Total No. Of file(s)</td><td>:</td><td>".htmlentities($count)."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. Of lines</td><td>:</td><td>".htmlentities($lc)."</td></tr>";
		echo "</table></center>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
	Print "<center><form name=\"xl\" method=\"post\" action=\"editorreport.php\">";
	Print "<input type=\"hidden\" value=$s_date name=\"start\" id=\"start\" />";
	Print "<input type=\"hidden\" value=$e_date name=\"end\" id=\"end\" />";
	Print "<input type=\"submit\" value=\"Export to Excel\" name=\"inhouse\" title=\"Get report from ".$s_date." to ".$e_date."\" />";
	Print "</form></center></td></tr></table>";
}
mysql_close($con);
?>

<div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
	<script src="charts/charts.js"></script>
    <script src="charts/popup.js"></script>
    <?php include('footer.php');?>
    <script src="charts/analytics.js"></script>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
