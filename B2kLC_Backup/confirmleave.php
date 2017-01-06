<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }
fieldset { padding:0; border:0; margin-top:25px; text-align:left; }

</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	if(isset($_GET['no']))
	{		
		$value=$_GET['no'];
		$del=mysql_query("DELETE FROM `leave_request`  WHERE `S.No`='$value'");
		if($del)
		{	
			echo "<script>
					alert('Leave request is deleted successfully !!!');
					setTimeout(function(){ window.location = \"confirmleave.php\";}, 0);
				  </script>";
		}
	}
	?>
          <div id="main"><br>
          <center><h2>Leave request from Employees</h2></center>
          <center><button id="update_profile">Show Previous</button></center>
          <?php
		  	$id=$_SESSION['Admin'];
			$res=mysql_query("SELECT * FROM `leave_request` WHERE `Permission_status`='Pending' AND `Approved_by`='Not Yet Viewed'");
			$cnt=mysql_num_rows($res);
			if($cnt!=0)
			{
				$a=1;
				echo "<table align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"2\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px; width=\"880\">";
				echo "<tr class=\"ui-widget-header\"><th>S.No</th><th>Date of Request</th><th>ID</th><th>Name</th><th>Leave date</th><th>Purpose</th><th>Timings</th><th>Permission Status</th><th>Approved By</th></tr>";
				$c=0;
				while($row=mysql_fetch_array($res))
				{
					$emp_id=preg_replace('/\s+/', '', $row['Employee_ID']);
					$leave_date=$row['Leave_Date'];
					echo "
					<script>
					function call_file".$emp_id."_".$a."(thisform)
					{
						if(document.getElementById('leave_".$emp_id."_".$a."').value==='-1')
						{
							dhtmlx.alert({title:\"Warning!!!\", text:\"Please choose a Permission Status field for ".$emp_id."\"});
							return false;
						}
						else
						{
							thisform.submit();
						}
					}</script>";
					
					echo "<tr class=\"tr".$c."\"><td>".$a."</td>";
					echo "<td>".$row['Date_of_request']."</td>";
					echo "<td>".$row['Employee_ID']."</td>";
					echo "<td>".$row['Employee_Name']."</td>";
					echo "<td>".$row['Leave_Date']."</td>";
					echo "<td>".$row['Purpose']."</td>";
					echo "<td>".$row['Timings']."</td>";
					if($row['Permission_status']=="Pending")
					{
						echo "<td><form name=\"".$emp_id."_".$a."_form\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">
							<table align=\"center\">
							<tr align=\"center\">
							<td style=\"border:0px;\">
							<input type=\"hidden\" name=\"date\" id=\"date\" title=\"Laeavedate\" size=\"15\" value=\"".$leave_date."\">
							<input type=\"hidden\" id=\"Admin\" name=\"Admin\" value=\"".$id."\">
							<input type=\"hidden\" id=\"".$emp_id."_".$a."\" name=\"emp_id\" value=\"".$emp_id."\">
							<select name=\"leave-status\" title=\"leave_".$emp_id."\" id=\"leave_".$emp_id."_".$a."\" class=\"text ui-widget-content ui-corner-all button\" >
							<option selected=\"selected\" value=\"-1\">--Select--</option>
							<option value=\"Approved\">Approved</option>
							<option value=\"Rejected\">Rejected</option>
							<option value=\"Half day Allowed\">Half day Allowed</option>
							</select>
							</td>
							<td style=\"border:0px;\">
							<input type=\"button\" name=\"upload\" id=\"upload\" value=\"Save\" onclick=\"call_file".$emp_id."_".$a."(this.form)\" class=\"button\" style=\"height:25px; width:60px;\"/>
							</td>
							</tr>
							</table>
							</form></td>";
				}
				else
				{
					echo "<td>".$row['Permission_status']."</td>";
				}
					echo "<td>".$row['Approved_by']."</td></tr>";
					$a=$a+1;
					if($c==0)
					{
						$c=1;
					}
					else
					{
						$c=0;
					}
				}
				echo "</table>";
				
			}
			else
			{
				echo "<br><br><center><h2>Sorry, No Request received from Employess...</h2></center><br><br>";
			}
		  ?>
          <div id="dialog-form" title="Previous Leave details">
                  <fieldset>
					<?php
					$show_all=mysql_query("SELECT * FROM `leave_request` WHERE `Permission_status`!='Pending' AND `Approved_by`!='Not Yet Viewed'");
					$count_show=mysql_num_rows($show_all);
					if($count_show!=0)
					{
						$a=1;
						echo "<table align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"2\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px; width=\"880\">";
						echo "<tr class=\"ui-widget-header\"><th>S.No</th><th>Date of Request</th><th>ID</th><th>Name</th><th>Leave date</th><th>Purpose</th><th>Timings</th><th>Permission Status</th><th>Approved By</th></tr>";
						$c=0;
						while($show_row=mysql_fetch_array($show_all))
						{	
							echo "<tr class=tr".$c."><td align=\"center\">
				<table align=\"center\"><tr align=\"center\"><td style=\"border:0px;\">".$a."</td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$show_row['S.No']."');\"></td></tr></table>
				</td>";
							echo "<td>".$show_row['Date_of_request']."</td>";
							echo "<td>".$show_row['Employee_ID']."</td>";
							echo "<td>".$show_row['Employee_Name']."</td>";
							echo "<td>".$show_row['Leave_Date']."</td>";
							echo "<td>".$show_row['Purpose']."</td>";
							echo "<td>".$show_row['Timings']."</td>";
							echo "<td>".$show_row['Permission_status']."</td>";
							echo "<td>".$show_row['Approved_by']."</td></tr>";
							$a=$a+1;
							if($c==0)
							{
								$c=1;
							}
							else
							{
								$c=0;
							}
						}
						echo "</table>";
						echo "<script type=\"text/javascript\" language=\"javascript\">
							function deletefile(file_no)
							{
								var fno=file_no;
								if (confirm('Are you sure ? You want to delete this Request?'))
								{
									window.location = \"confirmleave.php?no=\"+fno;
								}
								else
								{
									return false;
								}
							}
							</script>";
					}
					else
					{
						echo "<br><br><center><h2>Sorry, No Request received from Employess...</h2></center><br><br>";
					}
					?>
                  </fieldset>
			</div>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
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
    <script>
    $( "#dialog-form" ).dialog({
	  autoOpen: false,
      modal: true,
	  width: 720,
	  height: 450,
      buttons: {
        Okay: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
      },
	  show: {
        effect: "clip",
        duration: 250
      }
  });
   $( "#update_profile" )
      .button()
      .click(function() {
        $( "#dialog-form" ).dialog( "open" );
      });
</script>
  </div> 
</div> <!-- end of outter wrapper -->
<?php
if(isset($_POST['Admin']))
{
	$name=mysql_real_escape_string($_POST['Admin']);
	$app_status=mysql_real_escape_string($_POST['leave-status']);
	$l_date=mysql_real_escape_string($_POST['date']);
	$emp_id=mysql_real_escape_string($_POST['emp_id']);
	$sqlupdate=mysql_query("UPDATE `leave_request` SET `Approved_by`='$name',`Permission_status`='$app_status' where `Employee_ID`='$emp_id' AND `Leave_Date`='$l_date'");
	if($sqlupdate)
	{
		$comment=$loginas." has ".$app_status." Leave request from the ID ".$emp_id." on ".$l_date.".";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Details Updated Successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"confirmleave.php\";}, 0);
					}
				});
				</script>";
						
	}
}

if(isset($_POST['date5'],$_POST['l_time'],$_POST['l_purpose']))
{
	if(isset($_SESSION['Admin']))
	{ 
		$id=$_SESSION['Admin'];
	}
	elseif(isset($_SESSION['MLS']))
	{ 
		$id=$_SESSION['MLS'];
	}
	elseif(isset($_SESSION['EDITOR']))
	{ 
		$id=$_SESSION['EDITOR'];
	}
	$emp_id=$id;
	$emp_name=getname_itself($id);
	$date=date('Y-m-d');
	$leave_date=mysql_real_escape_string($_POST['date5']);
	$timing=mysql_real_escape_string($_POST['l_time']);
	$purpose=mysql_real_escape_string($_POST['l_purpose']);
	$status="Pending";
	$approved_by="Not Yet Viewed";
	$sql=mysql_query("INSERT INTO `leave_request` VALUES ('NULL','$date','$emp_id','$emp_name','$leave_date','$purpose','$timing','$status','$approved_by')");
	if($sql)
	{
		echo "<script> alert('Leave Request added Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"leaverequest.php\";}, 0);</script>";
	}
}
?>
</body>
</html>