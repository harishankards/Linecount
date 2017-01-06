<?php include('top.php');?>
<script>
function check(thisform)
{
	if(thisform.serid.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Team"});
      return false;
    }
thisform.submit();
show();
}
</script>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }

</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
        <h2>Bank Details </h2>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center">
          <tr align="center">
          <td class="bold">Choose Team</td><td>:</td>
          <td>
                    <select name="serid" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1" >--Select Team--</option>
                    <?php
                    $sql=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Vendor_name'];
                    echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
                    }
                    ?>
            </select>&nbsp;&nbsp;
            </td>
           <td>
                  	<input type="button"  value="Search" title="Search" onClick="check(this.form)" />
             </td>
            </tr>
            </table>
	</form>
<div id="show_admin_detail">
<?php
if(isset($_POST['serid']))
{
	$ven=$_POST['serid'];
	$query="SELECT * FROM `bank_details` WHERE `Vendor`='$ven'";
	$ser="Search results ";
	$sendquery=$query;
	$result=mysql_query($query);
}
else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Bank Details</td></tr></table></center><br>";
	$result=mysql_query("SELECT * FROM `bank_details`");
	$ser="Search results ";
	$sendquery="SELECT * FROM `bank_details`";
}
if($result)
{
	$comment=$loginas." has viewed Bank Details";
	$fp = fopen($log_dir.$loginas.".txt", "a+");
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
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
				window.location = \"updatebankdet.php?acc_no=\"+acc_no;
			}
			else
			{
				return false;
			}
		}
		function deletefile(accno)
		{
			var acc_no=accno;
			if (confirm('Are you sure ? You want to delete this '+acc_no+'?'))
			{
				window.location = \"viewbankdet.php?accno_no_del=\"+acc_no;
			}
			else
			{
				return false;
			}
		}
		</script>";
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"880\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
		echo "<th>Options</th><th>Date of Entry</th><th>Team</th><th>Name</th><th>Address</th><th>Bank Name</th><th>Branch Address</th><th>IFSC Code</th><th>Account Type</th><th>Account No</th><th>Print</th></tr>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			//echo "<td>".$c."</td>";
			echo "<td><table><tr><td style=\"border:0px; font-size:12px;\">".$c.".</td><td style=\"border:0px;\"><img src=\"menu/notes.png\" title=\"Edit file details\" height=\"20\" width=\"20\"  style=\"cursor:pointer;\" onclick=\"update('".$row['Account_No']."');\"></td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$row['Account_No']."');\"></td>
			</tr></table></td>";
			echo "<td>".$row['Date_of_entry']."</td>";
			echo "<td>".$row['Vendor']."</td>";
			echo "<td>".$row['Name']."</td>";
			echo "<td>".$row['Address']."</td>";
			echo "<td>".$row['Bank_name']."</td>";
			echo "<td>".$row['Branch_add']."</td>";
			echo "<td>".$row['IFSC_Code']."</td>";
			echo "<td>".$row['Account_Type']."</td>";
			echo "<td>".$row['Account_No']."</td>";
			echo "<td><form name=\"print\" target=\"_blank\" action=\"printbankdet.php\" method=\"post\"><input type=\"hidden\" name=\"acc_no\" value=\"".$row['Account_No']."\" ><input type=\"image\" title=\"Click this to print\" value=\"Print\" name=\"printthis\" src=\"menu/printer_sticker.png\" height=\"25\" width=\"25\"></form></td>";
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
		Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
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
if(isset($_GET['accno_no_del']))
{		
	$value=$_GET['accno_no_del'];
	$del=mysql_query("DELETE FROM `bank_details` WHERE `Account_No`='$value'");
	if($del)
	{
		$comment=$loginas." has Deleted Bank Details of ".$value;
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Details of the Account ".$value."  is deleted successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewbankdet.php\";}, 0);
					}
				});
				</script>";
		
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