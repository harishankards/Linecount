<?php 
error_reporting(0);
session_start();
if(isset($_SESSION['Admin']))
{ 
	include('top.php');
}
elseif(isset($_SESSION['MLS']))
{ 
	include('mlstop.php');
}
elseif(isset($_SESSION['EDITOR']))
{ 
	include('editortop.php');
}
elseif(isset($_SESSION['ES-MLS']))
{ 
	include('es-mlstop.php');
}
elseif(isset($_SESSION['ES-EDITOR']))
{ 
	include('es-editortop.php');
}
?>
<style>
input.text { margin-bottom:0px; width:80px; padding: .2em; text-align:left; }

select{ margin-bottom:0px; width:165px; padding: .2em; text-align:left; }

textarea{ margin-bottom:0px; width:250px; height:100px; padding: .2em; text-align:left; text-transform:none; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.leavedatepicker.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please select a Leave Date"});
      return false;
    }
	if(thisform.l_time.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please selest a Leave timings"});
      return false;
    }
	if(thisform.l_purpose.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please enter a Leave Purpose"});
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
          <?php
		  if(!isset($_POST['e_id'],$_POST['e_date'],$_POST['e_change']))
		  { 
		  ?>
          <form name="addleave" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter your leave request here ...</h2></center>
          <table cellpadding="2" align="center" cellspacing="5">
          
          	<tr>
                <td>Leave Date</td>
                <td>:</td>
                <td>
				 <input type="text" id="leavedatepicker" title="Select the Date" name="day" value="<?php echo date('Y-m-d',time()+2*60*60*24);?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly="readonly"/>
                 </td>
            </tr>
             <tr>
                <td>Leave Timings</td>
                <td>:</td>
                <td><select name="l_time" id="l_time" class="text ui-widget-content ui-corner-all" >
                    <option selected="selected" value="-1">--Select Timings--</option>
                    <option value="Full Day">Full Day</option>
                    <option value="Half Day">Half Day</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>Purpose</td>
                <td>:</td>
                <td><textarea name="l_purpose" id="l_purpose" rows="5" cols="22" class="text ui-widget-content ui-corner-all" ></textarea></td>
            </tr>
          </table>
          <table cellpadding="2" align="center" cellspacing="5">
          <tr><td><input type="button" value="Add Leave Request" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
          <?
		  }
		  ?>
          
           <?php
		  if(isset($_POST['e_id'],$_POST['e_date'],$_POST['e_change']))
		  { 
		  ?>
          <form name="changeleave" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <input type="hidden" name="e_id" id="e_id" value="<? echo $_POST['e_id'];?>">
          <input type="hidden" name="e_date" id="e_date" value="<? echo $_POST['e_date'];?>">
          <center><h2>Change your leave request here ...</h2></center>
          <table cellpadding="2" align="center" cellspacing="10">
          
          	<tr>
                <td>Change Leave Date</td>
                <td>:</td>
                <td>
				<input type="text" id="leavedatepicker" title="Select the Date" name="day" value="" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" />
                 </td>
            </tr>
             <tr>
                <td>Change Leave Timings</td>
                <td>:</td>
                <td><select name="c_time" id="l_time" class="text ui-widget-content ui-corner-all" >
                    <option selected="selected" value="-1">--Select Timings--</option>
                    <option value="Full Day">Full Day</option>
                    <option value="Half Day">Half Day</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>Purpose</td>
                <td>:</td>
                <td><textarea name="c_purpose" id="l_purpose" rows="5" cols="22" class="text ui-widget-content ui-corner-all"></textarea></td>
            </tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Change Leave Request" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
          <?
		  }
		  ?>
          <?php
		  if(!isset($_POST['e_id'],$_POST['e_date'],$_POST['e_change']))
		  {
		  	$res=mysql_query("SELECT * FROM `leave_request` WHERE `Employee_ID`='$id' LIMIT 0,10");
			$cnt=mysql_num_rows($res);
			if($cnt!=0)
			{
				if($count>5)
				{
					echo "<center><p>Please delete your previous request !!!</p></center>";
				}
				echo "<br><br><center><h2>Previous Leave request result</h2></center>";
				$a=1;
				$r=0;
				echo "<table border=\"1\" align=\"center\" width=\"880\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\">";
				echo "<tr class=\"ui-widget-header\"><th>S.No</th><th>Date of Request</th><th>ID</th><th>Name</th><th>Leave date</th><th>Purpose</th><th>Timings</th><th>Permission Status</th><th>Approved By</th></tr>";
				while($row=mysql_fetch_array($res))
				{
					echo "<tr class=tr".$r."><td align=\"center\">
				<table align=\"center\"><tr align=\"center\"><td style=\"border:0px;\">".$a."</td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$row['S.No']."');\"></td></tr></table>
				</td>";
					echo "<td>".$row['Date_of_request']."</td>";
					echo "<td>".$row['Employee_ID']."</td>";
					echo "<td>".$row['Employee_Name']."</td>";
					echo "<td>".$row['Leave_Date']."</td>";
					echo "<td>".$row['Purpose']."</td>";
					echo "<td>".$row['Timings']."</td>";
					if($row['Permission_status']=="Rejected")
					{
						echo "<td><form name=\"change\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" ><table align=\"center\"><tr><td>".$row['Permission_status']."&nbsp;&nbsp;&nbsp;<input type=\"hidden\" name=\"e_id\" id=\"e_id\" value=\"".$row['Employee_ID']."\"><input type=\"hidden\" name=\"e_change\" id=\"e_change\" value=\"change\"><input type=\"hidden\" name=\"e_date\" id=\"e_date\" value=\"".$row['Leave_Date']."\"></td><td><input type=\"submit\" name=\"change-leave\" value=\"change\" class=\"button\"></td></tr></table></form></td>";
					}
					else
					{
						echo "<td>".$row['Permission_status']."</td>";
					}
					echo "<td>".$row['Approved_by']."</td></tr>";
					$a=$a+1;
					if($r==0)
					{
						$r=1;
					}
					else
					{
						$r=0;
					}
				}
				echo "</table>";
				
			}
		}
		echo "<script type=\"text/javascript\" language=\"javascript\">
				function deletefile(file_no)
				{
					var fno=file_no;
					if (confirm('Are you sure ? You want to delete this Request?'))
					{
						window.location = \"leaverequest.php?no=\"+fno;
					}
					else
					{
						return false;
					}
				}
				</script>";
		  ?>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
<?php
if(isset($_POST['day'],$_POST['l_time'],$_POST['l_purpose']))
{
	$emp_id=$id;
	$emp_name=$_SESSION['EMP_NAME_ONLY'];
	$c_date=date('Y-m-d');
	$date=mysql_real_escape_string($_POST['day']);
	$leave_date=$date;
	$timing=mysql_real_escape_string($_POST['l_time']);
	$purpose=mysql_real_escape_string($_POST['l_purpose']);
	$status="Pending";
	$approved_by="Not Yet Viewed";
	$sql=mysql_query("INSERT INTO `leave_request` VALUES ('NULL','$c_date','$emp_id','$emp_name','$leave_date','$purpose','$timing','$status','$approved_by')");
	if($sql)
	{
		$comment=$id." has added Leave request\n";
		$uploadby=$_SESSION['EMP_NAME_ID'];
		$fp = fopen($log_dir.$uploadby.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Leave Request added Successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"leaverequest.php\";}, 0);
					}
				});
				</script>";
	}
}
if(isset($_POST['day'],$_POST['c_time'],$_POST['c_purpose'],$_POST['e_id'],$_POST['e_date']))
{
	$emp_id=mysql_real_escape_string($_POST['e_id']);
	$emp_name=$_SESSION['EMP_NAME_ONLY'];
	$old_leave=mysql_real_escape_string($_POST['e_date']);
	$c_date=date('Y-m-d');
	$date=mysql_real_escape_string($_POST['day']);
	$leave_date=$date;
	$timing=mysql_real_escape_string($_POST['c_time']);
	$purpose=mysql_real_escape_string($_POST['c_purpose']);
	$status="Pending";
	$approved_by="Not Yet Viewed";
	$sql=mysql_query("UPDATE `leave_request` SET `Date_of_request`='$c_date',`Leave_Date`='$leave_date',`Purpose`='$purpose',`Timings`='$timing',`Permission_status`='$status',`Approved_by`='$approved_by' WHERE `Employee_ID`='$emp_id' AND `Leave_Date`='$old_leave'");
	if($sql)
	{
		$uploadby=$_SESSION['EMP_NAME_ID'];
		$comment=$id." has Changed Leave request\n";
		$fp = fopen($log_dir.$uploadby.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Leave Changed Successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"leaverequest.php\";}, 0);
					}
				});
				</script>";
	}
}
if(isset($_GET['no']))
{		
	$value=$_GET['no'];
	
	$del=mysql_query("DELETE FROM `leave_request`  WHERE `S.No`='$value'");
	if($del)
	{	
		$comment=$id." has deleted Leave request \n";
		$uploadby=$_SESSION['EMP_NAME_ID'];
		$fp = fopen($log_dir.$uploadby.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
						title:\"Success !!!\",
						ok:\"Ok\",
						text:\"Leave request is deleted successfully !!!\",
						callback:function(){
						setTimeout(function(){ window.location = \"leaverequest.php\";}, 0);
						}
					});
					</script>";
	}

}
?>
</body>
</html>
