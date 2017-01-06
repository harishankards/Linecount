<?php include('editortop.php');?>
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
        <h2>Third Level File Details </h2>
        <form name="sub" id="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <center>
        <table align="center" width="300" cellpadding="5">
        <tr align="center">
        <td class="show">Choose the Date to See the Third level files</td>
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
if(isset($_POST['date1'],$_POST['date2']))
{
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$name=$_SESSION['idsileditorname'];
	$uploadby=$name;
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$id." has viewed the third level Edited file details in IDSIL / PJO from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$c=1;
	$r=0;
	$lc=0;
	$result=mysql_query("SELECT Date, Client, Hospital, File_No, File_Type, Linecount FROM `file_details`  WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Third_Editor`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<center><table><tr align=\"center\">
        <td>
        <input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only
        </td>
        </tr></table>";
		echo "<center><label class=\"result1\"><u>Search Results</u></label></b><br><br>";
		echo "<div id=\"detail\" style=\"width: 770px; height: 300px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" width=\"750\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\" cellpadding=\"3\" cellspacing=\"0\">";
		echo "<th>S.No.</th><th>Date</th><th>Client</th><th>Hospital</th><th>File No</th><th>File Type</th><th>LineCount</th>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Client'])."</td>";
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
		echo "<br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br />";
	}
}
mysql_close($con);
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
<script src="js/element.js"></script>
</html>
