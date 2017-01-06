<?php include('monitortop.php');?>
<style>
input.text { margin-bottom:0px; width:200px; padding: .2em; text-align:left; }
select{ margin-bottom:0px; width:220px; padding: .2em; text-align:left;}
</style>
<script language="javascript" type="text/javascript">
function show()
{
	dhtmlx.message('Searching please wait...');
}
function save()
{
	dhtmlx.message('Saving please wait...');
}
function del()
{
	dhtmlx.message('Removing please wait...');
}
</script>
<script type="text/javascript">
window.onload = function () {
refreshy = setTimeout("window.location='browserclose.php' ", 3600000); //seconds
}
window.onmousemove = function() {
stopCount();
startCount();
}
function stopCount() {
clearTimeout(refreshy);
}
function startCount() {
refreshy = setTimeout("window.location='browserclose.php' ", 3600000);
}
</script>
<script language="javascript" type="text/javascript">
function check(thisform)
{
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
	
	if(thisform.e_acc_no_new.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Account No"});
      return false;
    }
	
	if(thisform.e_acc_no_con.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Re-enter a Account No"});
      return false;
    }
	if(thisform.e_acc_no_new.value!==thisform.e_acc_no_con.value)
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
    include('header.php');
    if(isset($_SESSION['Vendor_Admin']))
    { 
        include('ak_tecmenu.php');
        $vendor_name=$_SESSION['Vendor_Admin'];
    }
    ?>
<div id="main_top"><center><br><?php echo"<label id=\"welcome_note\">Welcome ".$vendor_name."</label>";?></center></div>
          <div id="main"><br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Employee Bank details</h2></center>
          <table cellpadding="5" align="center" cellspacing="10">
          <?php
          	$accno=$_GET['acc_no'];
			$result=mysql_query("SELECT * FROM `bank_details` WHERE `Account_No`='$accno'");
			while($row=mysql_fetch_array($result))
			{
			?>
          <tr>
          <td>Employee Name</td>
          <td>:</td>
          <td><input type="text" name="e_name" id="e_name" size="35" value="<?php echo htmlentities($row['Name']);?>" class="text ui-widget-content ui-corner-all"  /> </td><td>( Employee name )</td>
          </tr>
          
          <tr>
          <td>Address</td>
          <td>:</td>
          <td><textarea name="e_add" id="e_add" cols="21" rows="5" class="text ui-widget-content ui-corner-all" ><?php echo htmlentities($row['Address']);?></textarea></td><td>( Employee Address)</td>
          </tr>
          
          <tr>
          <td>Name of the Bank</td>
          <td>:</td>
          <td><input type="text" name="e_bank_name" id="e_bank_name" size="35" value="<?php echo htmlentities($row['Bank_name']);?>" class="text ui-widget-content ui-corner-all" /></td><td>( Enter the Bank name ,<br> in which the empployee has account )</td>
          </tr>
          
          <tr>
          <td>Branch Address</td>
          <td>:</td>
          <td><textarea name="e_bank_add" id="e_bank_add" cols="21" rows="5" class="text ui-widget-content ui-corner-all"><?php echo htmlentities($row['Branch_add']);?></textarea></td><td>( Enter the Branch Address )</td>
          </tr>
          
          <tr>
          <td>IFSC Code</td>
          <td>:</td>
          <td><input type="text" name="e_ifsc" id="e_ifsc" size="35" value="<?php echo htmlentities($row['IFSC_Code']);?>" class="text ui-widget-content ui-corner-all" /></td><td>( Enter the IFSC Code of the Bank )</td>
          </tr>
          
          <tr>
          <td>Account Type</td>
          <td>:</td>
          <td><input type="text" name="e_acc_type" id="e_acc_type" size="35" value="<?php echo htmlentities($row['Account_Type']);?>" class="text ui-widget-content ui-corner-all" /></td><td>( Enter the Account Type )</td>
          </tr>
          
          <tr>
          <td>Old Account No</td>
          <td>:</td>
          <td><input type="text" name="e_acc_no" id="e_acc_no" size="35" value="<?php echo htmlentities($row['Account_No']);?>" readonly="readonly" class="text ui-widget-content ui-corner-all" /></td><td>( Enter the correct Account Number )</td>
          </tr>
          
           <tr>
          <td>New Account No</td>
          <td>:</td>
          <td><input type="text" name="e_acc_no_new" id="e_acc_no_new" size="35" value="<?php echo htmlentities($row['Account_No']);?>" class="text ui-widget-content ui-corner-all" /></td><td>( Enter the correct New Account Number )</td>
          </tr>
          
          <tr>
          <td>Confirm Account No</td>
          <td>:</td>
          <td><input type="text" name="e_acc_no_con" id="e_acc_no_con" size="35" value="<?php echo htmlentities($row['Account_No']);?>" class="text ui-widget-content ui-corner-all" /></td><td>( Re-enter the correct Account Number )</td>
          </tr>
          
          </table>
          <table cellpadding="25" align="center" cellspacing="50">
          <tr><td><input type="button" value="update" name="sub" class="button" onClick="check(this.form)"/></td><td><input type="reset" value="Reset" name="res" class="button" height="27" width="100" /></td></tr>
          </table>
          </form>
         <?php 
		 }
		 ?>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
<?php
include('dbconfig.php');
if(isset($_POST['e_name'],$_POST['e_add'],$_POST['e_bank_name'],$_POST['e_bank_add'],$_POST['e_ifsc'],$_POST['e_acc_type'],$_POST['e_acc_no'],$_POST['e_acc_no_con'],$_POST['e_acc_no_new']))
{
	$date=date('Y-m-d');
	$old_no=mysql_real_escape_string($_POST['e_acc_no']);
	$acc_no=mysql_real_escape_string($_POST['e_acc_no_new']);
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
		$enrterby=$vendor_name;
		$time=$datetime;
		$sql=mysql_query("UPDATE `bank_details` SET  `Date_of_entry`='$date',`Name`='$name',`Address`='$address',`Bank_name`='$bank_name',`Branch_add`='$bank_add',`IFSC_Code`='$ifsc',`Account_Type`='$acc_type',`Account_No`='$con_acc_no',`Enteredby`='$enrterby',`Time`='$time' WHERE `Account_No`='$old_no'");
		if($sql)
		{
			echo "<script> dhtmlx.alert({
						title:\"Success !!!\",
						ok:\"Ok\",
						text:\"Employee Bank details Updated Successfully\",
						callback:function(){
						setTimeout(function(){ window.location = \"monviewbank.php\";}, 0);
						}
					});
					
					</script>";
		}
		else
		{
			echo "<script> dhtmlx.alert({
						title:\"Error !!!\",
						ok:\"Ok\",
						text:\"Employee Bank details not updated Successfully\",
						callback:function(){
						setTimeout(function(){ window.location = \"monviewbank.php\";}, 0);
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
						setTimeout(function(){ window.location = \"monviewbank.php\";}, 0);
						}
					});
					
					</script>";
		}
}

mysql_close($con);
?>
