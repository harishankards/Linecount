<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:180px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:185px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_hr_id.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid HR ID"});
      return false;
    }

	if(thisform.e_name.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Username"});
      return false;
    }
	if(thisform.e_usr_id.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a UserID"});
      return false;
    }
	if(thisform.e_fiesa_id.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Fiesa ID"});
      return false;
    }
	
	if(thisform.e_fiesa.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Fiesa password"});
      return false;
    }
	if(thisform.e_mir.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a MIR Password"});
      return false;
    }
	if(thisform.e_wrk.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Working Status"});
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
          <center><h2>Enter the ID Details</h2></center>
          <table cellpadding="2" align="center" cellspacing="3">
          	<tr>
                <td>HR ID</td>
                <td>:</td>
                <td><input type="text" name="e_hr_id" id="e_hr_id" size="28" Value="" class="text ui-widget-content ui-corner-all" /></td>
            </tr>
            
          	<tr>
                <td>Username (As per HR)</td>
                <td>:</td>
                <td><input type="text" name="e_name" id="e_name" size="28" Value=""  class="text ui-widget-content ui-corner-all"/></td>
            </tr>
            
            <tr>
                <td>UserID</td>
                <td>:</td>
                <td><input type="text" name="e_usr_id" id="e_usr_id" size="28" Value="" class="text ui-widget-content ui-corner-all" /></td>
            </tr>
            
            <?php
			$hos_query=mysql_query("SELECT * from `escript_id`");
			$no=mysql_num_fields($hos_query);
			for($i=9;$i<$no;$i++)
			{
				$col=mysql_field_name($hos_query,$i);
				echo "<tr>
					<td>".$col." Password</td>
					<td>:</td>
					<td><input type=\"text\" class=\"text ui-widget-content ui-corner-all\" name=\"".trim($col)."pass\" id=\"".trim($col)."pass\" size=\"28\" Value=\"\" /></td>
					</tr>";
			} 
			?>
             <tr>
	            <td>Fiesa ID</td>
                <td>:</td>
                <td><input type="text" name="e_fiesa_id" id="e_fiesa_id" size="28" Value="" class="text ui-widget-content ui-corner-all"/></td>
            </tr>

            <tr>
	            <td>Fiesa Password</td>
                <td>:</td>
                <td><input type="text" name="e_fiesa" id="e_fiesa" size="28" Value="" class="text ui-widget-content ui-corner-all"/></td>
            </tr>

            <tr>
                <td>MIR Password</td>
                <td>:</td>
                <td><input type="text" name="e_mir" id="e_mir" size="28" Value="" class="text ui-widget-content ui-corner-all"/></td>
            </tr>

            <tr>
                <td>Working Status</td>
                <td>:</td>
                <td>
                    <select name="e_wrk" id="e_wrk" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Working Status--</option>
                    <option value="Working">Working</option>
                    <option value="Not Working">Not Working</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Alloted to</td>
                <td>:</td>
                <td><input type="text" name="e_altd" id="e_altd" size="28" Value="" class="text ui-widget-content ui-corner-all"/></td>
            </tr>
            
             <tr><td><br><input type="button" value="Submit" name="sub" onClick="check(this.form)" style="height:25px; width:75px; margin-left:70px;"/></td><td colspan="2"><br><input type="reset" value="Reset" name="reset" style="height:25px; width:75px; margin-left:70px;"/></td></tr>
          </table>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
<?php
if(isset($_POST['e_hr_id'],$_POST['e_name'],$_POST['e_usr_id'],$_POST['e_fiesa_id'],$_POST['e_fiesa'],$_POST['e_mir'],$_POST['e_wrk']))
{
	$hr_id=mysql_real_escape_string($_POST['e_hr_id']);
	$name=mysql_real_escape_string($_POST['e_name']);
	$name=strtoupper($name);
	$usr_id=mysql_real_escape_string($_POST['e_usr_id']);
	$fiesaid=mysql_real_escape_string($_POST['e_fiesa_id']);
	$fiesapass=mysql_real_escape_string($_POST['e_fiesa']);
	$mirpass=mysql_real_escape_string($_POST['e_mir']);
	$wrk=mysql_real_escape_string($_POST['e_wrk']);
	if(!($_POST['e_altd']==''))
	{
		$alloted_to=mysql_real_escape_string($_POST['e_altd']);
	}
	else
	{
		$alloted_to='Not alloted';
	}
	$f_query="INSERT INTO `escript_id` VALUES ('NULL','$hr_id','$name','$usr_id','$fiesaid','$fiesapass','$mirpass','$wrk','$alloted_to'";
	$hos_query=mysql_query("SELECT * from `escript_id`");
	$no=mysql_num_fields($hos_query);
	for($i=9;$i<$no;$i++)
	{
		$col=mysql_field_name($hos_query,$i);
		$val=mysql_real_escape_string(trim($_POST[$col.'pass']));
		$f_query=$f_query.",'".$val."'";
	} 
	$f_query=$f_query.")";
	echo $f_query;
	$sql=mysql_query($f_query);
	if($sql)
	{
		$comment=$loginas." has added Escription ID  [".$usr_id."] into Escription ID list in the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
				title:\"Success !!!\",
				ok:\"Ok\",
				text:\"ID Details added Successfully\",
				callback:function(){
				setTimeout(function(){ window.location = \"es-addid.php\";}, 0);
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
