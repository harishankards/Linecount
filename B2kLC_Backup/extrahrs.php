<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_id.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose the Employee"});
      return false;
    }
	if(thisform.e_hrs.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please enter a No. of Hours Worked"});
      return false;
    }
	thisform.submit();
}

</script>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
select,textarea { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
</style>
</head>
<body> 
<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
          <div id="main"><br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Extra working Hours</h2></center>
          <table cellpadding="2" align="center" cellspacing="2">
          
          	<tr>
                <td>Date</td>
                <td>:</td>
                <td>
                <input type="text" id="datepicker" title="Select the Date" name="date5" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                 </td>
            </tr>
            <tr>
                <td>Employee Name</td>
                <td>:</td>
                <td>
                    <select name="e_id" id="e_id" class="text ui-widget-content ui-corner-all">
                        <option selected="selected" value="-1">--Select Name--</option>
							<?php
                            $sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='ADMINISTRATOR'");
                            while($row=mysql_fetch_array($sql))
                            {
                            $id=$row['Emp_no'];
                            $name=$row['Emp_name'];
                            echo '<option value="'.htmlentities($id).'">'.htmlentities($name).'</option>';
                            }
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>No. of Hours Worked</td>
                <td>:</td>
                <td><input type="text" name="e_hrs" id="e_hrs" size="20" value="" class="text ui-widget-content ui-corner-all"> Hrs</td>
            </tr>
          </table>
          <table cellpadding="2" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)" style="height:25px; width:75px;"/></td><td><input type="reset" value="Reset" name="reset" style="height:25px; width:75px;"/></td></tr>
          </table>
          </form>

    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
if(isset($_POST['date5'],$_POST['e_hrs'],$_POST['e_id']))
{
	$date=mysql_real_escape_string($_POST['date5']);
	$hrs=mysql_real_escape_string($_POST['e_hrs']);
	$id=mysql_real_escape_string($_POST['e_id']);
	
	$sql=mysql_query("UPDATE `attendance` SET `Extra_hrs`='$hrs' WHERE `Date`='$date' AND `No`='$id'");
		if($sql)
		{		
			$comment=$loginas." has added Extra hours Details into the Database";
			$fp = fopen($log_dir.$loginas.".txt", "a+");
			fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
			fclose($fp);
			echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Extra Hours Details added Successfully\",
					callback:function(){
					setTimeout(function(){ window.location = \"extrahrs.php\";}, 0);
					}
				});
				</script>";
		}
		else
		{
			echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Extra Hours not Details added\",
					callback:function(){
					setTimeout(function(){ window.location = \"extrahrs.php\";}, 0);
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
