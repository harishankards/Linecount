<?php include('top.php');?>
<script id="source" language="javascript" type="text/javascript">
function enableTextBox() {
        if (document.getElementById("double").checked == true)
            document.getElementById("a_comm1").style.display = '';
        else
            document.getElementById("a_comm1").style.display='none';
    }
	
function hide()
{
	document.getElementById("a_comm1").style.display = 'none';
}
function check(thisform)
{
	if(document.getElementById("status").value==='-1')
	{
		alert('Please Select a Status');
		return false;
	}
	thisform.submit();
}
</script>
<style>
#attendate { margin-bottom:0px; width:75px; padding: .2em; text-align:left; }
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
select,textarea { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
</style>


</head>
<body onLoad="hide()"> 
<div id="outer_wrapper">
  <div id="wrapper">
   	<?php 
	include('main_top.php');
	?>
          <div id="main"><br>
          <form name="empatt" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <?php 
		  include('dbconfig.php');
		  $no='';
		  if(isset($_GET['no']))
		  {
		  	$no=$_GET['no'];
		  }
		  $result=mysql_query("SELECT * FROM `attendance` WHERE `S_No`='$no'");
		  while($row=mysql_fetch_array($result))
		  {
		  ?>
          <table cellpadding="5" align="center" cellspacing="20">
          <tr><td>Date</td><td>:</td><td><input type="text" id="attendate" name="date5" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )</td></tr>
          <tr><td>Employee ID</td><td>:</td><td><input type="text" name="a_id" id="a_id" size="28" class="text ui-widget-content ui-corner-all" value="<?php echo htmlentities($row['No']);?>" readonly="readonly" /></td></tr>
          <tr><td>Employee Name</td><td>:</td><td><input type="text" name="a_name" id="a_name" size="28" class="text ui-widget-content ui-corner-all" value="<?php echo htmlentities($row['Name']);?>" readonly="readonly" /></td></tr>
          <tr><td>Status</td><td>:</td><td><select name="status" id="status" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1"><?php echo htmlentities($row['Full/Half/Leave']);?></option>
                    <option value="Full">Full Day</option>
					<option value="NIght">Night Shift</option>
                    <option value="Half">Half Day</option>
                    <option value="Leave">Leave</option>
                    </select></td></tr>
          <tr><td>Double Shift</td><td>:</td><td><input type="radio" name="double[]" id="double" value="YES" onChange="enableTextBox()">&nbsp;YES&nbsp;&nbsp;<input type="radio" name="double[]" id="double" checked="true" value="NO" onChange="enableTextBox()" >&nbsp;NO</td></tr>
          <tr id="a_comm1"><td>Comments</td><td>:</td><td><textarea name="a_comm" class="text ui-widget-content ui-corner-all" id="a_comm" cols="21" rows="5" onFocus="clearText(this)" onBlur="clearText(this)"><?php echo htmlentities($row['Comments']);?></textarea></td></tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Submit" name="sub" class="button" onClick="check(this.form)"/></td><td><input type="reset" value="Reset" name="res" class="button" height="27" width="100" /></td></tr>
          </table>
          <?php }?>
          </form>
          
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
include('dbconfig.php');

if(isset($_POST['a_id'],$_POST['a_name'],$_POST['date5'],$_POST['status'],$_POST['double'],$_POST['a_comm']))
{
	$double=$_POST['double'];
	for($i=0;$i<sizeof($double);$i++)
	{
		$dday=mysql_real_escape_string($_POST['double'][$i]);
	}
	$no=mysql_real_escape_string($_POST['a_id']);
	$name=mysql_real_escape_string($_POST['a_name']);
	$date=mysql_real_escape_string($_POST['date5']);
	$status=mysql_real_escape_string($_POST['status']);
	$comm=mysql_real_escape_string($_POST['a_comm']);
	$sql=mysql_query("UPDATE `attendance` SET `Full/Half/Leave`='$status',Double_pay='$dday',`Comments`='$comm' WHERE `Date`='$date' AND `No`='$no' AND `Name`='$name'");
	if($sql)
	{
		$comment=$loginas." has updated Attendance Details for ".name;
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Employee attendance details Updated Successfully\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewatten.php\";}, 0);
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
