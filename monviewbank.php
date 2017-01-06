<?php include('monitortop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left;}
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
		<?php
    include('header.php');
    if(isset($_SESSION['Vendor_Admin']))
    { 
        include('ak_tecmenu.php');
        $vendor_name=$_SESSION['Vendor_Admin'];
    }
    ?>
<div id="main_top"><center><br><?php echo"<label id=\"welcome_note\">Welcome ".$vendor_name."</label>";?></center></div>
    <div id="main"><br>
        <h2>Bank Details </h2>

<div id="show_admin_detail">
<?php
if(isset($_POST['date1'],$_POST['date2']))
{
	$s_date=$_POST['date1'];
	$e_date=$_POST['date2'];
	$query="SELECT * FROM `bank_details` WHERE `Date_of_entry` BETWEEN '$s_date' AND '$e_date' AND `Vendor`='$vendor_name'";
	$ser="Search results ";
	$sendquery=$query;
	$result=mysql_query($query);
}
else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Bank Details </td></tr></table></center><br>";
	$query="SELECT * FROM `bank_details` WHERE `Vendor`='$vendor_name'";
	$result=mysql_query($query);
	$ser="Search results ";
	$sendquery=$query;
}
if($result)
{
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		$comment=$loginas." has Viewed Employee Details";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		$c=1;
		$r=0;
		echo "<center><label class=\"result\"><u>".$ser."</u></label></b><br><br>";
		if($count<20)
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 350px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		echo "<script type=\"text/javascript\" language=\"javascript\">
		function update(accno)
		{
			var acc_no=accno;
			if (confirm('Are you sure ? You want to update this '+acc_no+'?'))
			{
				window.location = \"monupdatebank.php?acc_no=\"+acc_no;
			}
			else
			{
				return false;
			}
		}
		</script>";
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"880\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\">";
		echo "<tr class=\"ui-widget-header\"><th>Options</th><th>Date of Entry</th><th>Name</th><th>Address</th><th>Bank Name</th><th>Branch Address</th><th>IFSC Code</th><th>Account Type</th><th>Account No</th></tr>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td><table><tr><td style=\"border:0px; font-size:12px;\">".$c.".</td><td style=\"border:0px;\"><img src=\"menu/notes.png\" title=\"Edit file details\" height=\"20\" width=\"20\"  style=\"cursor:pointer;\" onclick=\"update('".$row['Account_No']."');\"></td></tr></table></td>";
			echo "<td>".$row['Date_of_entry']."</td>";
			echo "<td>".$row['Name']."</td>";
			echo "<td>".$row['Address']."</td>";
			echo "<td>".$row['Bank_name']."</td>";
			echo "<td>".$row['Branch_add']."</td>";
			echo "<td>".$row['IFSC_Code']."</td>";
			echo "<td>".$row['Account_Type']."</td>";
			echo "<td>".$row['Account_No']."</td>";
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
		echo "</table></div>";
		echo "</center>";
		echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
		Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"editmonitoring-report.php\">";
		Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
		Print "<input type=\"hidden\" Value=\"Bank Details\" name=\"rep_name\" id=\"name\" />";
		Print "<input type=\"submit\" value=\"Get Bank details as Excel\" name=\"Filedetails\"/>";
		Print "</form></center></td></tr></table>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}

?>
		</div>
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
<script src="js/element.js"></script>
</html>