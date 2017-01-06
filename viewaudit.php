<?php include('editortop.php');?>
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
    <div id="main"><br>
        <h2>Audited and Missing file details </h2>
        <form name="sub" id="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <center>
        <table align="center" width="400" cellpadding="5">
        <tr align="center">
        <td class="show">Choose the Date to See the Audited files</td>
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
<?php
if(isset($_POST['date1'],$_POST['date2']))
{
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$name=$_SESSION['idsileditorname'];
	$uploadby=$name;
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$id." has viewed the Audit file details in IDSIL / PJO from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$c=1;
	$r=0;
	$lc=0;
	$result=mysql_query("SELECT * FROM `missing_files`  WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Edit_by`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<center><label class=\"result\"><u>Search Results For Missing Files</u></label></b><br><br>";
		echo "<div id=\"detail\" style=\"width: 770px; height: 350px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" width=\"750\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\" >";
		echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Client</th><th>File No</th><th>LineCount</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td>".$row['Date']."</td>";
			echo "<td>".$row['Client']."</td>";
			echo "<td>".$row['File_no']."</td>";
			echo "<td>".$row['Linecount']."</td>";
			
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
		echo "<tr class=\"result1\"><td>Total No. Of file(s)</td><td>:</td><td>".$count."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. Of lines</td><td>:</td><td>".$lc."</td></tr>";
		echo "</table></center>";
	}
	else
	{
		echo "<br /><br /><h1><center>No Record for Missing Files!!!</center></h1><br /><br /><br />";
	
	}
	$c=1;
	$r=0;
	$lc=0;
	$result=mysql_query("SELECT * FROM `audit_files`  WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND	`Audit_by`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<center><label class=\"result\"><u>Search Results for Audit Files</u></label></b><br><br>";
		echo "<div id=\"detail\" style=\"width: 770px; height: 350px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" width=\"750\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\" >";
		echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Client</th><th>File No</th><th>LineCount</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td>".$row['Date']."</td>";
			echo "<td>".$row['Client']."</td>";
			echo "<td>".$row['File_no']."</td>";
			echo "<td>".$row['Linecount']."</td>";
			
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
		echo "<tr class=\"result1\"><td>Total No. Of file(s)</td><td>:</td><td>".$count."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. Of lines</td><td>:</td><td>".$lc."</td></tr>";
		echo "</table></center>";
	}
	else
	{
		echo "<br /><br /><h1><center>No Record for Audit Files!!!</center></h1><br /><br /><br />";
	
	}
}
?>
<br />

<div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
