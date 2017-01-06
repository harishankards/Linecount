<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
function check(thisform)
{
	if(thisform.e_vndr.value==='')
    {
      alert("Please Enter a Team name");
      return false;
    }
	if(thisform.e_vndr_add.value==='')
    {
      alert("Please Enter a Team Address");
      return false;
    }
	if(thisform.e_vndr_of.value==='')
    {
      alert("Please Enter a Team name");
      return false;
    }
	if(thisform.e_vndr_cp.value==='')
    {
      alert("Please Enter a Team Contact Person Name ");
      return false;
    }
	if(thisform.e_vndr_ph1.value==='')
    {
      alert("Please Enter a Phone Number");
      return false;
    }
	if(thisform.e_vndr_ml1.value==='')
    {
      alert("Please Enter a Mail ID");
      return false;
    }
	thisform.submit();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
      alert("Please Enter a Valid Team");
      return false;
    }
	thisform.submit();
}
</script>
<style>
input.text { margin-bottom:0px; width:190px; padding: .2em; text-align:left; }

select,textarea { margin-bottom:0px; width:195px; padding: .2em; text-align:left; }

#e_vndr,#e_vndr_cp{text-transform:uppercase;}
</style>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
          <div id="main">
          <br>
          <form name="empdata" action="" method="post">
          
	  <?php
      if(!(isset($_GET['sno']))=="0")
        {		
            $no=$_GET['sno'];
            $result=mysql_query("SELECT * FROM `vendor` WHERE `S.No`='$no'");
            while($vnrow=mysql_fetch_array($result))
            {
    ?>
            <center><h2>Enter the Team Details</h2></center>
          <table cellpadding="5" align="center" cellspacing="20">
          
          <tr>
          <td>Team Name</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr" id="e_vndr" size="28" Value="<?php echo $vnrow['Vendor_name'];?>" class="text ui-widget-content ui-corner-all" /> *</td>
          </tr>
          
	      <tr>
          <td>Address</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="e_vndr_add" id="e_vndr_add" cols="21" rows="5" class="text ui-widget-content ui-corner-all"/><?php echo $vnrow['Address'];?></textarea> *</td></td>
          </tr>
          
           <tr>
          <td>Office Number</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_of" id="e_vndr_of" size="28" Value="<?php echo $vnrow['Office_no'];?>" class="text ui-widget-content ui-corner-all" /> *</td></td>
          </tr>
          
          <tr>
          <td>Contact Person</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_cp" id="e_vndr_cp" size="28" Value="<?php echo $vnrow['Contact_person'];?>" class="text ui-widget-content ui-corner-all" /> *</td>
          </tr>
          <tr>
          <td>Phone number(s)</td>
          <td>:</td>
          <td>+91&nbsp;&nbsp;<input type="text" name="e_vndr_ph1" id="e_vndr_ph1" size="24" maxlength="10" Value="<?php echo $vnrow['Ph_no_1'];?>" class="text ui-widget-content ui-corner-all" /> *<br><br>

			  +91&nbsp;&nbsp;<input type="text" name="e_vndr_ph2" id="e_vndr_ph2" maxlength="10" size="24" Value="<?php echo $vnrow['Ph_no_2'];?>" class="text ui-widget-content ui-corner-all" /><br><br>
			  +91&nbsp;&nbsp;<input type="text" name="e_vndr_ph3" id="e_vndr_ph3" maxlength="10" size="24" Value="<?php echo $vnrow['Ph_no_3'];?>" class="text ui-widget-content ui-corner-all" /><br>
<br>
	
          </td>
          </tr>
          
          <tr>
          <td>Mail ID</td>
          <td>:</td>
          <td>(1)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_ml1" id="e_vndr_ml1" size="24" Value="<?php echo $vnrow['Mail_1'];?>" class="text ui-widget-content ui-corner-all" /> *<br><br>
		       (2)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_ml2" id="e_vndr_ml2" size="24" Value="<?php echo $vnrow['Mail_2'];?>" class="text ui-widget-content ui-corner-all" /><br><br>
          </td>
          </tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td><td><input type="reset" value="Reset" name="reset" /></td></tr>
          </table>
          <?php 		
		  }
		}
?>
          </form>
           
			<br />
			<br />
			<br />
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php

if(isset($_POST['e_vndr'],$_POST['e_vndr_add'],$_POST['e_vndr_cp'],$_POST['e_vndr_of'],$_POST['e_vndr_ph1'],$_POST['e_vndr_ml1']))
{

	$vndr_name=$_POST['e_vndr'];	
	$vndr_add=$_POST['e_vndr_add'];
	$vndr_off=$_POST['e_vndr_of'];
	$vndr_cntctprsn=$_POST['e_vndr_cp'];
	$vndr_ph1=$_POST['e_vndr_ph1'];
	$vndr_ph2=$_POST['e_vndr_ph2'];
	$vndr_ph3=$_POST['e_vndr_ph3'];
	$vndr_mail1=$_POST['e_vndr_ml1'];
	$vndr_mail2=$_POST['e_vndr_ml2'];
	echo $vndr_name;
	$sql=mysql_query("UPDATE `vendor` SET `Vendor_name`='$vndr_name',`Address`='$vndr_add',`Office_no`='$vndr_off',`Contact_person`='$vndr_cntctprsn',`Ph_no_1`='$vndr_ph1',`Ph_no_2`='$vndr_ph2',`Ph_no_3`='$vndr_ph3',`Mail_1`='$vndr_mail1',`Mail_2`='$vndr_mail2' WHERE `Vendor_name`='$vndr_name'");
	if($sql)
	{
		echo "<script> alert('Team details updated Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"vendordetails.php\";}, 0);</script>";
	}
	else
	{
		echo "<script> alert('Team details not updated Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"vendordetails.php\";}, 0);</script>";
	}
}


?>
</body>
<script src="js/element.js"></script>
</html>
