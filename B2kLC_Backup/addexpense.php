<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_part.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please enter a particular"});
      return false;
    }
	if(thisform.e_amount.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please enter an Amount"});
      return false;
    }
	thisform.submit();
	save();
}
</script>

</head>
<body> 
<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
          <div id="main"><br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Expense Details</h2></center>
          <table cellpadding="5" align="center" cellspacing="5">
          
          	<tr>
                <td>Date</td>
                <td>:</td>
                <td>
				<input type="text" id="datepicker" title="Select the Date" name="date5" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                 </td>
            </tr>
            
            <tr>
                <td>Voucher No</td>
                <td>:</td>
                <td>
                    <input type="text" name="e_voucher" id="e_voucher" size="28" Value="" autocomplete="off" class="text ui-widget-content ui-corner-all"/>
                </td>
            </tr>
            
            <tr>
                <td>Particulars</td>
                <td>:</td>
                <td><textarea name="e_part" id="e_part" rows="5" cols="22" class="text ui-widget-content ui-corner-all"></textarea></td>
            </tr>
            
            <tr>
                <td>Amount</td>
                <td>:</td>
                <td>
                    <input type="text" name="e_amount" id="e_amount" size="28" Value="" autocomplete="off" class="text ui-widget-content ui-corner-all"/>
                </td>
            </tr>
            
                     
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)" style="height:30px; width:80px;"/></td><td><input type="reset" value="Reset" name="reset"  style="height:30px; width:80px;"/></td></tr>
          </table>
          </form>

    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
if(isset($_POST['date5'],$_POST['e_voucher'],$_POST['e_part'],$_POST['e_amount']))
{
	$date=mysql_real_escape_string($_POST['date5']);
	$voucher=mysql_real_escape_string($_POST['e_voucher']);
	$part=mysql_real_escape_string($_POST['e_part']);
	$amount=mysql_real_escape_string($_POST['e_amount']);
	$balance=0;
	if($voucher==0)
	{
		$voucher="Not Specified";
	}
	$bal_query=sprintf("SELECT * FROM `main_balance` WHERE `Balance`='Main'");
	$bal=mysql_query($bal_query);
	while($bal_row=mysql_fetch_array($bal))
	{
		$balance=$bal_row['Total'];
	}
	if($balance>$amount)
	{
		$balance=$balance-$amount;
		$ins_sql=sprintf("INSERT INTO `expense_details` VALUES ('NULL','$date','$voucher','$part','$amount','$balance')");
		$sql=mysql_query($ins_sql);
		if($sql)
		{	
			$comment=$loginas." has added Expense Details into the Database";
			$fp = fopen($log_dir.$loginas.".txt", "at");
			fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
			fclose($fp);
			$sql_up=sprintf("UPDATE `main_balance` SET `Total`='$balance' WHERE `Balance`='Main'");
			$sql_up_exe=mysql_query($sql_up);
			$sql_ins=sprintf("INSERT INTO `accounts_log` VALUES ('NULL','$date','EXPENSE','$voucher','$part','$amount','$balance')");
			$sql_ins_exe=mysql_query($sql_ins);
			echo "<script>
							 dhtmlx.alert({
							title:\"Success !!!\",
							ok:\"Ok\",
							text:\"Expense Details added Successfully !!!\",
							callback:function(){
							setTimeout(function(){ window.location = \"addexpense.php\";}, 0);
							}
						});
						</script>";
		}
	}
	else
	{
		echo "<script> dhtmlx.alert({
							title:\"Oops !!!\",
							ok:\"Ok\",
							text:\"You have only ".$balance." rupees !!!\"
						});
						</script>";
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
