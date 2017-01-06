<?php include('es-editortop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
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
        </center>
	</form>
<?php 
if(isset($_POST['date1'],$_POST['date2']))
{
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$uploadby=$name;
	//echo $name;
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$id." has viewed the Edited file details in Escription from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$c=1;
	$r=0;
	$lc=0;
	$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`File_type`,`Linecount` FROM `escript_filedetails` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND	`QC`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<center><table><tr align=\"center\">
        <td>
        <input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only
        </td>
        </tr></table>";
		echo "<center><label class=\"result1\">Search Results from $s_date to $e_date</label></b><br><br>";
		echo "<div id=\"detail\" style=\"width: 770px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" width=\"750\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\" cellpadding=\"3\" cellspacing=\"0\">";
		echo "<th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>File Type</th><th>LineCount</th>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Hospital'])."</td>";
			echo "<td>".htmlentities($row['File_No'])."</td>";
			echo "<td>".htmlentities($row['File_type'])."</td>";
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
	Print "<center><form name=\"xl\" method=\"post\" action=\"es-editorreport.php\">";
	Print "<input type=\"hidden\" value=$s_date name=\"start\" id=\"start\" />";
	Print "<input type=\"hidden\" value=$e_date name=\"end\" id=\"end\" />";
	Print "<input type=\"submit\" value=\"Export to Excel\" name=\"inhouse\" title=\"Get report from ".$s_date." to ".$e_date."\" />";
	Print "</form></center></td></tr></table>";
}
mysql_close($con);
?>
        
<br />
<br />
<br />
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
