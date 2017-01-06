<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	
	if(thisform.e_no.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee ID"});
      return false;
    }
	
	if(thisform.e_name.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee name"});
      return false;
    }
	
	if(thisform.e_pass.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Password"});
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
          <div id="main"><br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Super Admin details</h2></center>
          <table cellpadding="5" align="center" cellspacing="20">
          
          <tr>
          <td>Employee ID</td>
          <td>:</td>
          <td><input type="text" name="e_no" id="e_no" size="28"  /></td>
          </tr>
          
          <tr>
          <td>Employee Name</td>
          <td>:</td>
          <td><input type="text" name="e_name" id="e_name" size="28"  /></td>
          </tr>
          
          <tr>
          <td>Password</td>
          <td>:</td>
          <td><input type="text" name="e_pass" id="e_pass" size="28"  /></td>
          </tr>
          
          <tr>
          <td>D.O.B</td>
          <td>:</td>
          <td>
		  	  <?php
			  $myCalendar = new tc_calendar("date5", true, false);
			  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
			  $myCalendar->setDate(date('d'), date('m'), date('Y'));
			  $myCalendar->setPath("calendar/");
			  $myCalendar->setYearInterval(1940, 1994);
			  $myCalendar->dateAllow('1960-01-01', '1994-12-31');
			  $myCalendar->setDateFormat('j F Y');
			  //$myCalendar->autoSubmit(true, "form1");
			  $myCalendar->setAlignment('left', 'bottom');
			  $myCalendar->writeScript();
			  ?>
          </td>
          </tr>

          <tr>
          <td>Mobile No</td>
          <td>:</td>
          <td><input type="text" name="e_mob" id="e_mob" size="28"  /></td>
          </tr>

          <tr>
          <td>Mail Id</td>
          <td>:</td>
          <td><input type="text" name="e_mail" id="e_mail" size="28"  /></td>
          </tr>
                    
          <tr>
          <td>ID Status</td>
          <td>:</td>
          <td>
              <select name="e_status" id="e_status" >
                  <option selected="selected" value="-1">--Select Status--</option>
                  <option value="ACTIVE">ACTIVE</option>
                  <option value="BLOCK">BLOCK</option>
              </select>
          </td>
          </tr>
          
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
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
if(isset($_POST['e_no'],$_POST['e_name'],$_POST['e_pass'],$_POST['date5'],$_POST['e_mob'],$_POST['e_mail'],$_POST['e_status']))
{
$no=mysql_real_escape_string($_POST['e_no']);
$no=strtoupper($no);
$pass=mysql_real_escape_string($_POST['e_pass']);
$name=mysql_real_escape_string($_POST['e_name']);
$name=mysql_real_escape_string(strtoupper($name));
$dob=mysql_real_escape_string($_POST['date5']);
$date=date('Y-m-d');
$ph=mysql_real_escape_string($_POST['e_mob']);
$mail=mysql_real_escape_string($_POST['e_mail']);
$status=mysql_real_escape_string($_POST['e_status']);
$sql=mysql_query("INSERT INTO `super_admin` VALUES ('NULL','$date','$no','$name',SHA('$pass'),'$dob','$ph','$mail','$status')");
if($sql)
{
	echo "<script> dhtmlx.alert({
				title:\"Success !!!\",
				ok:\"Ok\",
				text:\"Employee details added Successfully\",
				callback:function(){
				setTimeout(function(){ window.location = \"addsuperadmin.php\";}, 0);
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
				setTimeout(function(){ window.location = \"addsuperadmin.php\";}, 0);
				}
			});
			
			</script>";
}
}

//mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
