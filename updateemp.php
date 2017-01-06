<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
function checkstatus(thisform)
{
	if(thisform.e_status.value==='-1')
    {
      alert("Please Choose a ID Status");
      return false;
    }
	thisform.submit();
}
</script>
<style>
input.text { margin-bottom:0px; width:190px; padding: .2em; text-align:left; }

select,textarea { margin-bottom:0px; width:195px; padding: .2em; text-align:left; }

#e_no,#e_name{text-transform:uppercase;}
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
          <form name="empdata" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <center><h2>Enter the Employee details</h2></center>
          	<?php
          	$no=$_GET['no'];
			$acc=$_GET['acc'];
			if($acc=="escription")
			{
				$query="SELECT * FROM `es_employee` WHERE `Emp_no`='$no'";
			}
			else
			{
				$query="SELECT * FROM `employee` WHERE `Emp_no`='$no'";
			}
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
			?>
            
          <table cellpadding="5" align="center" cellspacing="20">
          <tr>
          <td>Client</td>
          <td>:</td>
          <td><input type="text" name="e_client" id="e_client" size="28" class="text ui-widget-content ui-corner-all" value="<?php echo htmlentities($acc);?>" readonly="readonly"  /></td>
          </tr>
          <tr>
          <td>Old Employee ID</td>
          <td>:</td>
          <td><input type="text" name="e_no_old" id="e_no_old" size="28" class="text ui-widget-content ui-corner-all" value="<?php echo htmlentities($row['Emp_no']);?>"  /></td>
          </tr>
          
          <tr>
          <td>New Employee ID</td>
          <td>:</td>
          <td><input type="text" name="e_no" id="e_no" size="28" class="text ui-widget-content ui-corner-all"  value="<?php echo htmlentities($row['Emp_no']);?>"  /></td>
          </tr>
          
          <tr>
          <td>Password</td>
          <td>:</td>
          <td><input type="text" name="e_pass" id="e_pass" class="text ui-widget-content ui-corner-all" size="28" value="<? echo htmlentities($row['password']);?>"  /></td>
          </tr>
          
          <tr>
          <td>Employee Name</td>
          <td>:</td>
          <td><input type="text" name="e_name" id="e_name" class="text ui-widget-content ui-corner-all" size="28" value="<? echo htmlentities($row['Emp_name']);?>"  /></td>
          </tr>
          
          <tr>
          <td>Designation</td>
          <td>:</td>
          <td>
          <select name="e_des" id="e_des" class="text ui-widget-content ui-corner-all">
                <option selected="selected" value="<? echo $row['Emp_desig'];?>"><? echo htmlentities($row['Emp_desig']);?></option>
                <?php
                $sql=mysql_query("select `Designation` from designation");
                while($row1=mysql_fetch_array($sql))
                {
                $des=$row1['Designation'];
                echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
                }
                ?>
          </select>
          </td>
          </tr>
          
          <tr>
          <td>Team Name</td>
          <td>:</td>
          <td>
              <select name="e_vndr" id="e_vndr" class="text ui-widget-content ui-corner-all">
                  <option selected="selected" value="<? echo htmlentities($row['Vendor']);?>"><? echo htmlentities($row['Vendor']);?></option>
                  <?php
                  $sql1=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                  while($row1=mysql_fetch_array($sql1))
                  {
                      $vend=$row1['Vendor_name'];
                      echo '<option value="'.htmlentities($vend).'">'.htmlentities($vend).'</option>';
                  }
                  ?>
              </select>
          </td>
          </tr>
          
          <tr>
          <td>D.O.B</td>
          <td>:</td>
          <td>
               <input type="text" id="dmpicker" title="Select the Date" name="date5" value="<?php echo $row['Emp_dob'];?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;"/>
          </td>
          </tr>
          
          <tr>
          <td>Address</td>
          <td>:</td>
          <td><textarea name="e_add" id="e_add" cols="21" rows="5" class="text ui-widget-content ui-corner-all"><?php echo htmlentities($row['Emp_add']);?></textarea></td>
          </tr>
          
          <tr>
          <td>Mobile No</td>
          <td>:</td>
          <td><input type="text" name="e_mob" id="e_mob" size="28" class="text ui-widget-content ui-corner-all" value="<? echo htmlentities($row['Emp_phno']);?>"  /></td>
          </tr>
          
          <tr>
          <td>Telephone</td>
          <td>:</td>
          <td><input type="text" name="e_tel" id="e_tel" size="28" class="text ui-widget-content ui-corner-all" value="<? echo htmlentities($row['Emp_tel']);?>"  /></td>
          </tr>
          
          <tr>
          <td>Mail Id</td>
          <td>:</td>
          <td><input type="text" name="e_mail" id="e_mail" size="28" class="text ui-widget-content ui-corner-all" value="<? echo htmlentities($row['Emp_mail']);?>"  /></td>
          </tr>
          
          <tr>
          <td>ID Status</td>
          <td>:</td>
          <td>
              <select name="e_status" id="e_status" class="text ui-widget-content ui-corner-all">
                  <option selected="selected" value="<? echo $row['ID_Status']; ?>"><? echo $row['ID_Status']; ?></option>
                  <?php 
				  if($row['ID_Status']=="ACTIVE")
				  {
				  		echo '<option value="BLOCK">BLOCK</option>';
				  }
				  else
				  {
				  		echo '<option value="ACTIVE">ACTIVE</option>';
				  }
				  ?>
              </select>
          </td>
          </tr>
          
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Submit" name="sub" onClick="checkstatus(this.form)"/></td><td><input type="reset" value="Reset" name="res" height="27" width="100" /></td></tr>
          </table>
          	<?php
				}
			?>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
include('dbconfig.php');
if(isset($_POST['e_client']))
{
	$acc=$_POST['e_client'];
	if($acc=="escription")
	{
			if(isset($_POST['e_no_old'],$_POST['e_no'],$_POST['e_name'],$_POST['date5'],$_POST['e_add'],$_POST['e_mob'],$_POST['e_tel'],$_POST['e_mail'],$_POST['e_des'],$_POST['e_pass'],$_POST['e_vndr'],$_POST['e_status']))
		{
		
			$vendor=mysql_real_escape_string($_POST['e_vndr']);
			$oldno=mysql_real_escape_string($_POST['e_no_old']);
			$no1=mysql_real_escape_string($_POST['e_no']);
			$pass=mysql_real_escape_string($_POST['e_pass']);
			$name=mysql_real_escape_string($_POST['e_name']);
			$date=mysql_real_escape_string($_POST['date5']);
			$add=mysql_real_escape_string($_POST['e_add']);
			$ph=mysql_real_escape_string($_POST['e_mob']);
			$tel=mysql_real_escape_string($_POST['e_tel']);
			$mail=mysql_real_escape_string($_POST['e_mail']);
			$desg=mysql_real_escape_string($_POST['e_des']);
			$status=mysql_real_escape_string($_POST['e_status']);
			$sql=mysql_query("UPDATE `es_employee` SET  `Vendor`='$vendor',`Emp_no`='$no1',`password`='$pass',`Emp_pass`=SHA('$pass'),`Emp_name`='$name',`Emp_dob`='$date',`Emp_add`='$add',`Emp_phno`='$ph',`Emp_tel`='$tel',`Emp_mail`='$mail',`Emp_desig`='$desg',`ID_Status`='$status' where `Emp_no`='$oldno'");
			if($sql)
			{
				echo "<script> alert('Employee details updated Successfully');</script>";
				echo "<script> setTimeout(function(){ window.location = \"viewesemp.php\";}, 0);</script>";
			}
			else
			{
				echo "<script> alert('Employee details not added Successfully');</script>";
				echo "<script> setTimeout(function(){ window.location = \"viewesemp.php\";}, 0);</script>";
			
			}
		}
	}
	else
	{
		if(isset($_POST['e_no_old'],$_POST['e_no'],$_POST['e_name'],$_POST['date5'],$_POST['e_add'],$_POST['e_mob'],$_POST['e_tel'],$_POST['e_mail'],$_POST['e_des'],$_POST['e_pass'],$_POST['e_vndr'],$_POST['e_status']))
		{
			$vendor=mysql_real_escape_string($_POST['e_vndr']);
			$oldno=mysql_real_escape_string($_POST['e_no_old']);
			$no1=mysql_real_escape_string($_POST['e_no']);
			$pass=mysql_real_escape_string($_POST['e_pass']);
			$name=mysql_real_escape_string($_POST['e_name']);
			$date=mysql_real_escape_string($_POST['date5']);
			$add=mysql_real_escape_string($_POST['e_add']);
			$ph=mysql_real_escape_string($_POST['e_mob']);
			$tel=mysql_real_escape_string($_POST['e_tel']);
			$mail=mysql_real_escape_string($_POST['e_mail']);
			$desg=mysql_real_escape_string($_POST['e_des']);
			$status=mysql_real_escape_string($_POST['e_status']);
			$sql=mysql_query("UPDATE `employee` SET  `Vendor`='$vendor',`Emp_no`='$no1',`password`='$pass',`Emp_pass`=SHA('$pass'),`Emp_name`='$name',`Emp_dob`='$date',`Emp_add`='$add',`Emp_phno`='$ph',`Emp_tel`='$tel',`Emp_mail`='$mail',`Emp_desig`='$desg',`ID_Status`='$status' where `Emp_no`='$oldno'");
			if($sql)
			{
				echo "<script> alert('Employee details updated Successfully');</script>";
				echo "<script> setTimeout(function(){ window.location = \"viewemp.php\";}, 0);</script>";
			}
			else
			{
				echo "<script> alert('Employee details not added Successfully');</script>";
				echo "<script> setTimeout(function(){ window.location = \"viewemp.php\";}, 0);</script>";
			
			}
		}
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
