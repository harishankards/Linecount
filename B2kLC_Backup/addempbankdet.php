<?php include('top.php');?>
<style>
input.text, textarea { margin-bottom:0px; width:250px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:255px; padding: .2em; text-align:left; }
#e_name, #e_bank_name, #e_ifsc, #e_acc_type ,#e_acc_no, #e_acc_no_con{text-transform:uppercase;}
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_vndr.value==='-1')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Vendor name"});
      return false;
    }
	
	if(thisform.e_name.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee name"});
      return false;
    }
	
	if(thisform.e_add.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee Address"});
      return false;
    }
	
	if(thisform.e_bank_name.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Bank Name"});
      return false;
    }
	
	if(thisform.e_bank_add.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Branch Address"});
      return false;
    }
	
	if(thisform.e_ifsc.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter the IFSC Code"});
      return false;
    }
	
	if(thisform.e_acc_type.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Account Type"});
      return false;
    }
	
	if(thisform.e_acc_no.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Account No"});
      return false;
    }
	
	if(thisform.e_acc_no_con.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Re-enter a Account No"});
      return false;
    }
	if(thisform.e_acc_no.value!=thisform.e_acc_no_con.value)
	{
	  dhtmlx.alert({title:"MISMATCH!!!", text:"Account No and Confirm Account No are mismatch please check"});
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
          <center><h2>Enter the Employee Bank details</h2></center>
          <table width="750" style="padding-left:80px;" cellpadding="1" align="center" cellspacing="3">
          
          <tr>
          <td>Vendor Name</td>
          <td>:</td>
          <td>
              <select name="e_vndr" id="e_vndr" class="text ui-widget-content ui-corner-all">
                  <option selected="selected" value="-1">--Select Vendor--</option>
                  <?php
                  $sql=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                  while($row=mysql_fetch_array($sql))
                  {
                      $vend=$row['Vendor_name'];
                      echo '<option value="'.htmlentities($vend).'">'.htmlentities($vend).'</option>';
                  }
                  ?>
              </select>
          </td>
          </tr>
          
          <tr>
          <td>Employee Name</td>
          <td>:</td>
          <td><input type="text" name="e_name" id="e_name" size="35"  class="text ui-widget-content ui-corner-all" autocomplete="off"/> </td><td>( Employee name )</td>
          </tr>
          
          <tr>
          <td>Address</td>
          <td>:</td>
          <td><textarea name="e_add" id="e_add" cols="27" rows="5" class="text ui-widget-content ui-corner-all"></textarea></td><td>( Employee Address )</td>
          </tr>
          
          <tr>
          <td>Name of the Bank</td>
          <td>:</td>
          <td><input type="text" name="e_bank_name" id="e_bank_name" size="35" class="text ui-widget-content ui-corner-all" autocomplete="off" /></td><td>( Enter the Bank name ,<br> in which the empployee has account )</td>
          </tr>
          
          <tr>
          <td>Branch Address</td>
          <td>:</td>
          <td><textarea name="e_bank_add" id="e_bank_add" cols="27" rows="5" class="text ui-widget-content ui-corner-all"></textarea></td><td>( Enter the Branch Address )</td>
          </tr>
          
          <tr>
          <td>IFSC Code</td>
          <td>:</td>
          <td><input type="text" name="e_ifsc" id="e_ifsc" size="35"  class="text ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Enter the IFSC Code of the Bank )</td>
          </tr>
          
          <tr>
          <td>Account Type</td>
          <td>:</td>
          <td><input type="text" name="e_acc_type" id="e_acc_type" size="35"  class="text ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Enter the Account Type )</td>
          </tr>
          
          <tr>
          <td>Account No</td>
          <td>:</td>
          <td><input type="text" name="e_acc_no" id="e_acc_no" size="35"  class="text ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Enter the correct Account Number )</td>
          </tr>
          
           <tr>
          <td>Confirm Account No</td>
          <td>:</td>
          <td><input type="text" name="e_acc_no_con" id="e_acc_no_con" size="35" class="text ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Re-enter the correct Account Number )</td>
          </tr>
          
          </table>
          <table width="70" cellpadding="5" align="center" cellspacing="10" style="padding-left:-30px;">
          <tr><td><input type="button" value="Submit" name="sub" class="button" onClick="check(this.form)"/></td><td><input type="reset" value="Reset" name="res" class="button" height="27" width="100" /></td></tr>
          </table>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
<?php
include('dbconfig.php');
if(isset($_POST['e_vndr'],$_POST['e_name'],$_POST['e_add'],$_POST['e_bank_name'],$_POST['e_bank_add'],$_POST['e_ifsc'],$_POST['e_acc_type'],$_POST['e_acc_no'],$_POST['e_acc_no_con']))
{
	$date=date('Y-m-d');
	$vendor=mysql_real_escape_string($_POST['e_vndr']);
	$acc_no=mysql_real_escape_string($_POST['e_acc_no']);
	$acc_no=strtoupper($acc_no);
	$con_acc_no=mysql_real_escape_string($_POST['e_acc_no_con']);
	$con_acc_no=strtoupper($con_acc_no);
	if($acc_no==$con_acc_no)
	{
		$name=mysql_real_escape_string($_POST['e_name']);
		$name=mysql_real_escape_string(strtoupper($name));
		$address=mysql_real_escape_string($_POST['e_add']);
		$bank_name=mysql_real_escape_string($_POST['e_bank_name']);
		$bank_add=mysql_real_escape_string($_POST['e_bank_add']);
		$ifsc=mysql_real_escape_string(strtoupper($_POST['e_ifsc']));
		$acc_type=mysql_real_escape_string($_POST['e_acc_type']);
		$enrterby=$loginas;
		$time=$datetime;
		$sql=mysql_query("INSERT INTO `bank_details` VALUES ('NULL','$date','$vendor','$name','$address','$bank_name','$bank_add','$ifsc','$acc_type','$con_acc_no','$enrterby','$time')");
		if($sql)
		{
			$comment=$loginas." has added Bank Details of an Employee [".$name."] into the Database";
			$fp = fopen($log_dir.$loginas.".txt", "at");
			fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
			fclose($fp);
			echo "<script> dhtmlx.alert({
						title:\"Success !!!\",
						ok:\"Ok\",
						text:\"Employee Bank details added Successfully\",
						callback:function(){
						setTimeout(function(){ window.location = \"addempbankdet.php\";}, 0);
						}
					});
					
					</script>";
		}
		else
		{
			echo "<script> dhtmlx.alert({
						title:\"Error !!!\",
						ok:\"Ok\",
						text:\"Employee Bank details not added Successfully\",
						callback:function(){
						setTimeout(function(){ window.location = \"addempbankdet.php\";}, 0);
						}
					});
					
					</script>";
		}
	}
	else
		{
			echo "<script> dhtmlx.alert({
						title:\"Error !!!\",
						ok:\"Ok\",
						text:\"Account No and Confirm Account No are mismatch please check\",
						callback:function(){
						setTimeout(function(){ window.location = \"addempbankdet.php\";}, 0);
						}
					});
					
					</script>";
		}
}

mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
