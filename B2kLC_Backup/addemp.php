<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:190px; padding: .2em; text-align:left; }

select,textarea { margin-bottom:0px; width:195px; padding: .2em; text-align:left; }

#e_no,#e_name{text-transform:uppercase;}
</style>

<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_account.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a User of "});
      return false;
    }
	if(thisform.e_no.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee ID"});
      return false;
    }
	if(thisform.e_pass.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Password"});
      return false;
    }
	
	if(thisform.e_name.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee name"});
      return false;
    }
	
	if(thisform.e_vndr.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Team"});
      return false;
    }
	
	if(thisform.e_des.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Designation"});
      return false;
    }
	
	if(thisform.e_status.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a ID Status"});
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
          <div id="main">
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Employee details</h2></center>
          <table cellpadding="0" align="center" cellspacing="10">
          <tr>
          <td>User of </td>
          <td>:</td>
          <td> <select name="e_account" id="e_account" class="text ui-widget-content ui-corner-all">
                  <option selected="selected" value="-1">--Select Client--</option>
                  <option value="IDSIL_or_PJO">IDSIL / PJO</option>
                  <option value="EScription">EScription</option>
              </select>
          </td>
          </tr>
          <tr>
          <td>Employee ID</td>
          <td>:</td>
          <td><input type="text" name="e_no" id="e_no" size="28"  class="text ui-widget-content ui-corner-all"/></td>
          </tr>
          
          <tr>
          <td>Password</td>
          <td>:</td>
          <td><input type="text" name="e_pass" id="e_pass" size="28" class="text ui-widget-content ui-corner-all" /></td>
          </tr>
          
          <tr>
          <td>Employee Name</td>
          <td>:</td>
          <td><input type="text" name="e_name" id="e_name" size="28" class="text ui-widget-content ui-corner-all" /></td>
          </tr>
          
          <tr>
          <td>Team Name</td>
          <td>:</td>
          <td>
              <select name="e_vndr" id="e_vndr" class="text ui-widget-content ui-corner-all" >
                  <option selected="selected" value="-1">--Select Team--</option>
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
          <td>Designation</td>
          <td>:</td>
          <td>
          	<select name="e_des" id="e_des" class="text ui-widget-content ui-corner-all">
                <option selected="selected" value="-1">--Designation--</option>
                <?php
                $sql=mysql_query("select `Designation` from `designation` order by `Designation`");
                while($row=mysql_fetch_array($sql))
                {
                $des=$row['Designation'];
                echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
                }
                ?>
            </select>
          </td>
          </tr>
          
          <tr>
          <td>D.O.B</td>
          <td>:</td>
          <td>
         <input type="text" id="dmpicker" title="Select the Date" name="date5" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;"/>
          </td>
          </tr>
          
          <tr>
          <td>Address</td>
          <td>:</td>
          <td><textarea name="e_add" id="e_add" cols="21" rows="5" class="text ui-widget-content ui-corner-all"></textarea></td>
          </tr>
          
          <tr>
          <td>Mobile No</td>
          <td>:</td>
          <td><input type="text" name="e_mob" id="e_mob" size="28" class="text ui-widget-content ui-corner-all" /></td>
          </tr>
          
          <tr>
          <td>Telephone</td>
          <td>:</td>
          <td><input type="text" name="e_tel" id="e_tel" size="28"  class="text ui-widget-content ui-corner-all"/></td>
          </tr>
          
          <tr>
          <td>Mail Id</td>
          <td>:</td>
          <td><input type="text" name="e_mail" id="e_mail" size="28"  class="text ui-widget-content ui-corner-all"/></td>
          </tr>
          
          <tr>
          <td>ID Status</td>
          <td>:</td>
          <td>
              <select name="e_status" id="e_status" class="text ui-widget-content ui-corner-all">
                  <option selected="selected" value="-1">--Select Status--</option>
                  <option value="ACTIVE">ACTIVE</option>
                  <option value="BLOCK">BLOCK</option>
              </select>
          </td>
          </tr>
          
          </table>
          <table cellpadding="10" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td><td><input type="reset" value="Reset" name="res" /></td></tr>
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
if(isset($_POST['e_account'],$_POST['e_no'],$_POST['e_name'],$_POST['e_vndr'],$_POST['date5'],$_POST['e_add'],$_POST['e_mob'],$_POST['e_tel'],$_POST['e_mail'],$_POST['e_des'],$_POST['e_status']))
{
$major_acc=mysql_real_escape_string($_POST['e_account']);
$no=mysql_real_escape_string($_POST['e_no']);
$no=strtoupper($no);
$pass=mysql_real_escape_string($_POST['e_pass']);
$name=mysql_real_escape_string($_POST['e_name']);
$name=mysql_real_escape_string(strtoupper($name));
$vendor=mysql_real_escape_string($_POST['e_vndr']);
$date=mysql_real_escape_string($_POST['date5']);
$add=mysql_real_escape_string($_POST['e_add']);
$ph=mysql_real_escape_string($_POST['e_mob']);
$tel=mysql_real_escape_string($_POST['e_tel']);
$mail=mysql_real_escape_string($_POST['e_mail']);
$desg=mysql_real_escape_string($_POST['e_des']);
$status=mysql_real_escape_string($_POST['e_status']);
$log_status="NO";
if($major_acc=="EScription")
{
$query="INSERT INTO `es_employee` VALUES ('NULL','$vendor','$no',SHA('$pass'),'$pass','$name','$date','$add','$ph','$tel','$mail','$desg','$status','$log_status')";

}
else
{
$query="INSERT INTO `employee` VALUES ('NULL','$vendor','$no',SHA('$pass'),'$pass','$name','$date','$add','$ph','$tel','$mail','$desg','$status','$log_status')";
}
$sql=mysql_query($query);
if($sql)
{
	$comment=$loginas." has added Employee Details[".$name."] into the Database";
	$fp = fopen($log_dir.$loginas.".txt", "at");
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	echo "<script> dhtmlx.alert({
				title:\"Success !!!\",
				ok:\"Ok\",
				text:\"Employee details added Successfully\",
				callback:function(){
				setTimeout(function(){ window.location = \"addemp.php\";}, 0);
				}
			});
			
			</script>";
}
else
{
	echo "<script> dhtmlx.alert({
				title:\"Error !!!\",
				ok:\"Ok\",
				text:\"Employee details not added Successfully\",
				callback:function(){
				setTimeout(function(){ window.location = \"addemp.php\";}, 0);
				}
			});
			
			</script>";
}
}

//mysql_close($con);
?>
</body>
</html>
