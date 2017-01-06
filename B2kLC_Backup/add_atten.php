<?php include('top.php');?>
<style>
select { margin-bottom:0px; width:300px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.emp.value==='-1')
    {
      dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Please Choose an Employee name to add"
			});
      return false;
    }
	thisform.submit();
	save();
}
function check_del(thisform)
{
	if(thisform.emp_del.value==='-1')
    {
      dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Please Choose an Employee name to delete"
			});
      return false;
    }
	thisform.submit();
	del();
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
           <div >
           <h2>Add Employee to Attendance List</h2>
           <form name="addemp" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
           <table align="center" width="600">
           <tr>
           <td class="show" width="200">Choose an Employee to Add</td>
           <td>:</td>
           <td>
                    <select name="emp" id="emp" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Select Employee--</option>
                    <?php
                    $sql=mysql_query("select * from `employee` order by `Emp_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $no=$row['Emp_no'];
					$name=$row['Emp_name'];
                    echo '<option value="'.htmlentities($name).'-->'.htmlentities($no).'">'.htmlentities($name).'-->'.htmlentities($no).'</option>';
                    }
                    ?>
            </select>&nbsp;&nbsp;
            </td>
            </tr>
            </table>
             <center>
             <br>
             <input type="button" name="Searchdes" value="Add Employee" alt="Search" id="Searchdes" title="Search" onClick="check(this.form)" style="height:30px; width:150px;" /></center>
                </form>
             </div>
          	<br />
			<br />
			<br />
            <div >
            <h2>Delete Employee from Attendance List</h2>
           <form name="addemp" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
           <table align="center" width="600">
           <tr>
           <td class="show" width="200">Choose an Employee to Delete</td>
           <td>:</td>
           <td>
                    <select name="emp_del" id="emp_del" class="text ui-widget-content ui-corner-all" >
                    <option selected="selected" value="-1">--Select Employee--</option>
                    <?php
                    $sql=mysql_query("select `Name`,`No` from `attn_list` order by `Name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $no=$row['No'];
					$name=$row['Name'];
                    echo '<option value="'.htmlentities($name).'-->'.htmlentities($no).'">'.htmlentities($name).'-->'.htmlentities($no).'</option>';
                    }
                    ?>
            </select>&nbsp;&nbsp;
            </td>
            </tr>
            </table>
             <center>
             <br>
             <input type="button" name="Searchdes" value="Delete Employee" alt="Search" id="Searchdes" title="Search" onClick="check_del(this.form)" style="height:30px; width:150px;" /></center>
                </form>
             </div>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php

if(isset($_POST['emp']))
{
	$emp=explode("-->",mysql_real_escape_string($_POST['emp']));
	$emp_name=$emp[0];
	$emp_no=$emp[1];
	$sql=mysql_query("INSERT INTO `attn_list` VALUES ('NULL','$emp_name','$emp_no')");
	if($sql)
	{
		$comment=$loginas." has added Employee [".$emp_name."] into attendance list in the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);

		echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Employee added Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"add_atten.php\";}, 0);
								}
							});
							</script>";
	}
	else
	{
		echo "<script> dhtmlx.alert({
								title:\"Error !!!\",
								ok:\"Ok\",
								text:\"Employee not added Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"add_atten.php\";}, 0);
								}
							});
							</script>";
	}

}
if(isset($_POST['emp_del']))
{
	$emp=explode("-->",mysql_real_escape_string($_POST['emp_del']));
	$emp_name=$emp[0];
	$emp_no=$emp[1];
	echo "<script> alert('".$emp_name.$emp_no."');</script>";
	$sql=mysql_query("DELETE FROM `attn_list` WHERE `No`='$emp_no' and `Name`='$emp_name'");
	if($sql)
	{
		$comment=$loginas." has Deleted Employee [".$emp_name."] from attendance list in the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Employee Deleted Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"add_atten.php\";}, 0);
								}
							});
							</script>";
	}
	else
	{
		echo "<script> dhtmlx.alert({
								title:\"Error !!!\",
								ok:\"Ok\",
								text:\"Employee not deleted Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"add_atten.php\";}, 0);
								}
							});
							</script>";
	}

}
?>
</body>
<script src="js/element.js"></script>
</html>
