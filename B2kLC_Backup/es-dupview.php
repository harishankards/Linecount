<?php include('es-editortop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center }
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main">
     <?php
		$name=$_SESSION['eseditorname'];
		$up_query=mysql_query("SELECT `Date`,`Hospital`,`Platform_ID`,`File_No`,`Linecount` FROM escript_filedetails WHERE `MT`='$name' AND `Linecount`='0'");
		$up_count=mysql_num_rows($up_query);
		if($up_count!=0)
		{
			echo "<button id=\"updatelinecount\">Update</button>";
        	echo " <div id=\"dialog-form\" title=\"Linecount details\">";
			echo "<h2>Update Linecount</h2>";
        	echo "<form name=\"updatelc\" id=\"updatelc\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"lc_update\" >";
			echo "<table border=\"1\" align=\"center\"  class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\">";
			echo "<tr class=\"ui-widget-header\"><th>Date</th><th>Hospital</th><th>ID</th><th>File No</th><th>Linecount</th></tr>";
			while($up_row=mysql_fetch_array($up_query))
			{
				echo "<tr><td>".$up_row['Date']."</td><td>".$up_row['Hospital']."</td><td>".$up_row['Platform_ID']."</td><td>".$up_row['File_No']."</td><td>"; 
				if($up_row['Linecount']==0)
				{
					$file_no=preg_replace('/\s+/', '', $up_row['File_No']);
					echo "<input type=\"text\" name=\"lines_".$file_no."\" id=\"lines_".$file_no."\" size=\"7\" maxlength=\"7\" class=\"text ui-widget-content ui-corner-all\" autocomplete=\"off\" onBlur=\"check_".$file_no."(this);\">";
				}
				echo "</td></tr>";
			}
			echo "</table>";
			//echo "<center><input type=\"submit\" value=\"Save\"></center></form>";
			echo "</div>";
		}
		?>
        <h2>File Details </h2>
        <form name="sub" id="sub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <table align="center" width="400" cellpadding="0">
            <tr align="center">
            <td class="show">Choose the Date to See the Files</td>
            </tr>
        </table>
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
        </table><br>
        <table align="center" width="400" cellpadding="0">
            <tr align="center">
                <td>
                <input type="submit" value="Search" name="search" id="search" onClick="show()">
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
	$name=$_SESSION['eseditorname'];
	$uploadby=$_SESSION['eseditorname'];
	$id=$_SESSION['ES-EDITOR'];
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$id." has viewed the file details in Escription from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$c=1;
	$r=0;
	$lc=0;
	$editlines=0;
	$blanklines=0;
	$dupeditlines=0;
	$dupblanklines=0;
	$conv=0;
	$result=mysql_query("SELECT `Date`,`Hospital`,`Platform_ID`,`File_No`,`File_type`,`DSP/NONDSP`,`Linecount` FROM `escript_filedetails` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `MT`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<table align=\"center\">
				<tr align=\"center\">
					<td>
					<input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only 
					</td>
				</tr></table>";
		echo "<center><label class=\"result1\">Search Results from $s_date to $e_date</label></b><br><br>";
		echo "<div id=\"detail\" style=\"width: 770px; height: 300px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" width=\"750\" align=\"center\"  class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\">";
		echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Hospital</th><th>ID</th><th>File No</th><th>File Type</th><th>Upload Type</th><th>LineCount</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r." >";
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Hospital'])."</td>";
			echo "<td>".htmlentities($row['Platform_ID'])."</td>";
			echo "<td>".htmlentities($row['File_No'])."</td>";
			if($row['DSP/NONDSP']=="NON-DSP")
			{
				if($row['File_type']=="Edit")
				{	
					$editlines=$editlines+$row['Linecount'];
				}
				if($row['File_type']=="Trans")
				{	
					$blanklines=$blanklines+$row['Linecount'];
				}
			}
			else
			{
				if($row['File_type']=="Edit")
				{	
					$dupeditlines=$dupeditlines+$row['Linecount'];
				}
				if($row['File_type']=="Trans")
				{	
					$dupblanklines=$dupblanklines+$row['Linecount'];
				}
			}
			echo "<td>".htmlentities($row['File_type'])."</td>";
			echo "<td>".htmlentities($row['DSP/NONDSP'])."</td>";
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
		echo "<tr class=\"result1\"><td>No. of. Files</td><td>:</td><td>".htmlentities($count)."</td></tr><br>";
		echo "<tr class=\"result1\"><td>No. of. DSP Edit lines</td><td>:</td><td>".htmlentities($dupeditlines)."</td></tr>";
		echo "<tr class=\"result1\"><td>No. of. DSP Trans lines</td><td>:</td><td>".htmlentities($dupblanklines)."</td></tr>";
		echo "<tr class=\"result1\"><td>No. of. Non DSP Edit lines</td><td>:</td><td>".htmlentities($editlines)."</td></tr>";
		echo "<tr class=\"result1\"><td>No. of. Non DSP Trans lines</td><td>:</td><td>".htmlentities($blanklines)."</td></tr>";
		$conv=(2*$dupblanklines)+(2*$blanklines)+$dupeditlines+$editlines;
		echo "<tr class=\"result1\"><td>Converted Lines</td><td>:</td><td>".htmlentities($conv)."</td></tr>";
		echo "</table></center>";
		Print "<center><form name=\"xl\" method=\"post\" action=\"es-editorreport.php\">";
		Print "<input type=\"hidden\" value=$s_date name=\"start\" id=\"start\" />";
		Print "<input type=\"hidden\" value=$e_date name=\"end\" id=\"end\" />";
		Print "<input type=\"submit\" value=\"Export to Excel\" name=\"inhouse\" title=\"Get report from ".$s_date." to ".$e_date."\" />";
		Print "</form></center></td></tr></table>";
	}
	else
	{
		echo "<br /><h1><center>Sorry no files found  !!!</center></h1>";
	
	}
}
?>
<?php
if(isset($_POST['lc_update']))
{
	$name=$_SESSION['eseditorname'];
	$up_query=mysql_query("SELECT `File_No` FROM `escript_filedetails` WHERE `MT`='$name' AND `Linecount`='0'");
	$up_count=mysql_num_rows($up_query);
	if($up_count!=0)
	{
		while($up_row=mysql_fetch_array($up_query))
		{
			$f_no=$up_row['File_No'];
			$lc=$_POST['lines_'.$f_no];
			if($lc=='')
			{
				$lc=0;
			}
			$sql=mysql_query("UPDATE `escript_filedetails` SET `Linecount`='$lc' where `File_No`='$f_no'");
			if($sql)
			{
				$flag=$flag+1;
			}
		}
		echo "<script> document.location.href = \"es-dupview.php\";</script>";
	}
}
?>
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    
    <?php include('footer.php');?>
    <script>
    $( "#dialog-form" ).dialog({
	  autoOpen: true,
      modal: true,
	  width: 500,
      buttons: {
        Save: function() {
		     $('#updatelc').submit();
        }
      },
	  close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
      },
	  show: {
        effect: "clip",
        duration: 250
      }
    });
	$( "#updatelinecount" )
      .button()
      .click(function() {
        $( "#dialog-form" ).dialog( "open" );
      });
	</script>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
