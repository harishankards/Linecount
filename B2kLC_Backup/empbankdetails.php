<?php 
include('dbconfig.php');
?>
<style>
.bank { margin-bottom:0px; width:250px; padding: .2em; text-align:left; text-transform:uppercase; }
.bank_sel { margin-bottom:0px; width:255px; padding: .2em; text-align:left; text-transform:uppercase;}
</style>
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script>
	$(function(){
		$( "#bank_data_dialog" ).dialog({
			autoOpen: true,
			height: 600,
			width: 780,
			modal: true,
			buttons: {
					"Save Details": function() {
						$( "#emp_bank_form" ).submit();
						//$( this ).dialog( "close" );
					},
					"Cancel": function() {
					$( this ).dialog( "close" );
					//window.location=window.location.href;
					}
				},
				close: function() {
					//window.location=window.location.href;
				}
			});
	
	});
	jQuery(document).ready(function(){
			jQuery("#emp_bank_form").validationEngine('attach',{promptPosition : "topLeft"});
		});
</script>
<?php
if(!isset($_SESSION['bank_details_set']))
{
	$bank_u_id=$_SESSION['username'];
	$b_c_sql=mysql_query("SELECT * FROM `new_bank_details` WHERE `Emp_id`='$bank_u_id'");
	$b_c_count=mysql_num_rows($b_c_sql);
	if($b_c_count==0)
	{
	?>
	<div id="bank_data_dialog" title="Enter you Bank Details"><br><br>
		<form name="emp_bank_form" id="emp_bank_form"action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
			<center><p style="color:#FF0000;">Please fill all the details. Unless you Enter these details you can't able to enter your Linecount.</p></center>
			<table width="750" style="padding-left:80px;" cellpadding="1" align="center" cellspacing="3">
				<input type="hidden" name="employee_id" id="employee_id" size="35" value="<?php if(isset($_SESSION['username'])) { echo $_SESSION['username'];} else { echo ""; }?>"  class="validate[required] bank ui-widget-content ui-corner-all" autocomplete="off"/>
				<input type="hidden" name="employee_vndr" id="employee_vndr" size="35" value="<?php if(isset($_SESSION['Vendorname'])) { echo $_SESSION['Vendorname'];} else { echo ""; } ?>"  class="validate[required] bank ui-widget-content ui-corner-all" autocomplete="off"/>
				<tr>
				<td>Employee Name</td>
				<td>:</td>
				<td><input type="text" name="employee_name" id="employee_name" size="35"  class="validate[required] bank ui-widget-content ui-corner-all" autocomplete="off"/> </td><td>( Employee name )</td>
				</tr>
	
				<tr>
				<td>Address</td>
				<td>:</td>
				<td><textarea name="employee_add" id="employee_add" cols="27" rows="5" class="validate[required] bank ui-widget-content ui-corner-all"></textarea></td><td>( Employee Address )</td>
				</tr>
	
				<tr>
				<td>Name of the Bank</td>
				<td>:</td>
				<td><input type="text" name="employee_bank_name" id="employee_bank_name" size="35" class="validate[required] bank ui-widget-content ui-corner-all" autocomplete="off" /></td><td>( Enter the Bank name ,<br> in which the empployee has account )</td>
				</tr>
	
				<tr>
				<td>Branch Address</td>
				<td>:</td>
				<td><textarea name="employee_bank_add" id="employee_bank_add" cols="27" rows="5" class="validate[required] bank ui-widget-content ui-corner-all"></textarea></td><td>( Enter the Branch Address )</td>
				</tr>
	
				<tr>
				<td>IFSC Code</td>
				<td>:</td>
				<td><input type="text" name="employee_ifsc" id="employee_ifsc" size="35"  class="validate[required] bank ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Enter the IFSC Code of the Bank )</td>
				</tr>
	
				<tr>
				<td>Account Type</td>
				<td>:</td>
				<td><input type="text" name="employee_acc_type" id="employee_acc_type" size="35"  class="validate[required] bank ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Enter the Account Type )</td>
				</tr>
	
				<tr>
				<td>Account No</td>
				<td>:</td>
				<td><input type="text" name="employee_acc_no" id="employee_acc_no" size="35"  class="validate[required] bank ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Enter the correct Account Number )</td>
				</tr>
	
				<tr>
				<td>Confirm Account No</td>
				<td>:</td>
				<td><input type="text" name="employee_acc_no_con" id="employee_acc_no_con" size="35" class="validate[required,equals[employee_acc_no]] bank ui-widget-content ui-corner-all" autocomplete="off"/></td><td>( Re-enter the correct Account Number )</td>
				</tr>
	
			</table>
		</form>
	</div>
	<?php
	}
	$_SESSION['bank_details_set']='test';
}
?>
<?php
if(isset($_POST['employee_vndr'],$_POST['employee_name'],$_POST['employee_add'],$_POST['employee_bank_name'],$_POST['employee_bank_add'],$_POST['employee_ifsc'],$_POST['employee_acc_type'],$_POST['employee_acc_no'],$_POST['employee_acc_no_con']))
{
	$date=date('Y-m-d');
	$bank_vendor=mysql_real_escape_string($_POST['employee_vndr']);
	$emp_bank_id=mysql_real_escape_string($_POST['employee_id']);
	$acc_no=mysql_real_escape_string($_POST['employee_acc_no']);
	$acc_no=strtoupper($acc_no);
	$con_acc_no=mysql_real_escape_string($_POST['employee_acc_no_con']);
	$con_acc_no=strtoupper($con_acc_no);
	if($acc_no==$con_acc_no)
	{
		$b_name=mysql_real_escape_string($_POST['employee_name']);
		$b_name=mysql_real_escape_string(strtoupper($b_name));
		$address=mysql_real_escape_string($_POST['employee_add']);
		$bank_name=mysql_real_escape_string($_POST['employee_bank_name']);
		$bank_add=mysql_real_escape_string($_POST['employee_bank_add']);
		$ifsc=mysql_real_escape_string(strtoupper($_POST['employee_ifsc']));
		$acc_type=mysql_real_escape_string($_POST['employee_acc_type']);
		$enrterby=$id;
		$time=$datetime;
		$sql=mysql_query("INSERT INTO `new_bank_details` VALUES ('NULL','$date','$bank_vendor','$emp_bank_id','$b_name','$address','$bank_name','$bank_add','$ifsc','$acc_type','$con_acc_no','$enrterby','$time')");
		if($sql)
		{
			$comment=$id." has added Bank Details  into the Database";
			$fp = fopen($log_dir.$id.".txt", "at");
			fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
			fclose($fp);
			echo "<script> dhtmlx.alert({
						title:\"Success !!!\",
						ok:\"Ok\",
						text:\"Employee Bank details added Successfully\",
						callback:function(){
						setTimeout(function(){ window.location = window.loation.href;}, 0);
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
						setTimeout(function(){ window.location = window.loation.href;}, 0);
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
						setTimeout(function(){ window.location = window.location.href;}, 0);
						}
					});
					
					</script>";
		}
}

?>
