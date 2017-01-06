<?php include('mlstop.php');?>
<style>
input.text { margin-bottom:0px; width:180px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:185px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.primary.value==='primary')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please choose a Primary account"});
      return false;
    }
	if(thisform.secondary.value==='secondary')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please choose a Secondary account"});
      return false;
    }
	
	if(thisform.tertiary.value==='tertiary')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please choose a Tertiary account"});
      return false;
    }

	if(thisform.e_target.value==="")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please enter your Daily Target Lines"});
      return false;
    }
	thisform.submit();
	save();
}
function check_dup()
{
	if(document.getElementById('primary').value===document.getElementById('secondary').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('primary').value===document.getElementById('tertiary').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('primary').value===document.getElementById('optional1').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('primary').value===document.getElementById('optional2').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('secondary').value===document.getElementById('tertiary').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('secondary').value===document.getElementById('optional1').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('secondary').value===document.getElementById('optional2').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('tertiary').value===document.getElementById('optional1').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('tertiary').value===document.getElementById('optional2').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	if(document.getElementById('optional2').value===document.getElementById('optional1').value)
	{
		dhtmlx.alert({title:"Warning!!!", text:"You already Choose these account"});
      	return false;
	}
	
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
          <h2>MLS Profile</h2>
          <table cellpadding="2" align="center" cellspacing="2">
          
          	<tr>
                <td>User ID</td>
                <td>:</td>
                <td><input type="text" name="e_id" id="e_id" size="28" Value="<?php echo $_SESSION['MLS'];?>" class="text ui-widget-content ui-corner-all" autocomplete="off" readonly/></td>
            </tr>
            
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="e_name" id="e_name" size="28" Value="<?php echo $_SESSION['EMP_NAME_ONLY'];?>" class="text ui-widget-content ui-corner-all" autocomplete="off" readonly/></td>
            </tr>
            <?php $sql=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
				  $sql2=$sql;
				  $sql3=$sql
					?>
            <tr>
                <td>Primary Account</td>
                <td>:</td>
                <td> <select name="primary" id="primary" class="text ui-widget-content ui-corner-all" onChange="check_dup();">
					<?
						echo "<option selected=\"selected\" value=\"primary\">--Select--</option>";
						$sql1=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row1=mysql_fetch_array($sql1))
						{
							$hsp1=$row1['Hospital_name'];
							echo '<option value="'.$hsp1.'">'.$hsp1.'</option>';
						}
                    ?>
                    </select></td>
            </tr>
            
            <tr>
                <td>Secondary Account</td>
                <td>:</td>
                <td>
                   <select name="secondary" id="secondary" class="text ui-widget-content ui-corner-all" onChange="check_dup();">
					<?
						echo "<option selected=\"selected\" value=\"secondary\">--Select--</option>";
						$sql2=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row2=mysql_fetch_array($sql2))
						{
							$hsp2=$row2['Hospital_name'];
							echo '<option value="'.$hsp2.'">'.$hsp2.'</option>';
						}
                    ?>
                    </select>
                </td>
            </tr>
            
             <tr>
                <td>Tertiary Account</td>
                <td>:</td>
                <td>
                   <select name="tertiary" id="tertiary" class="text ui-widget-content ui-corner-all" onChange="check_dup();">
					<?
						echo "<option selected=\"selected\" value=\"tertiary\">--Select--</option>";
						$sql3=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row3=mysql_fetch_array($sql3))
						{
							$hsp3=$row3['Hospital_name'];
							echo '<option value="'.$hsp3.'">'.$hsp3.'</option>';
						}
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Optional Account (1)</td>
                <td>:</td>
                <td>
                   <select name="optional1" id="optional1" class="text ui-widget-content ui-corner-all" onChange="check_dup();">
					<?
						echo "<option selected=\"selected\" value=\"optional1\">--Select--</option>";
						$sql4=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row4=mysql_fetch_array($sql4))
						{
							$hsp4=$row4['Hospital_name'];
							echo '<option value="'.$hsp4.'">'.$hsp4.'</option>';
						}
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Optional Account (2)</td>
                <td>:</td>
                <td>
                   <select name="optional2" id="optional2" class="text ui-widget-content ui-corner-all" onChange="check_dup();">
					<?
						echo "<option selected=\"selected\" value=\"optional2\">--Select--</option>";
						$sql5=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row5=mysql_fetch_array($sql5))
						{
							$hsp5=$row5['Hospital_name'];
							echo '<option value="'.$hsp5.'">'.$hsp5.'</option>';
						}
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Target Lines</td>
                <td>:</td>
                <td>
                   <input type="text" name="e_target" id="e_target" size="28" class="text ui-widget-content ui-corner-all" autocomplete="off" />
                </td>
            </tr>
          </table>
          <table cellpadding="1" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
<?php

if(isset($_POST['e_id'],$_POST['e_name'],$_POST['primary'],$_POST['secondary'],$_POST['tertiary'],$_POST['optional1'],$_POST['optional2'],$_POST['e_target']))
{
	$dat=date('Y-m-d');
	$id=mysql_real_escape_string($_POST['e_id']);
	$name=mysql_real_escape_string($_POST['e_name']);
	$name=strtoupper($name);
	$primary=mysql_real_escape_string($_POST['primary']);
	$secondary=mysql_real_escape_string($_POST['secondary']);
	$tertiary=mysql_real_escape_string($_POST['tertiary']);
	$opt1=mysql_real_escape_string($_POST['optional1']);
	$opt2=mysql_real_escape_string($_POST['optional2']);
	$target=mysql_real_escape_string($_POST['e_target']);
	$sql=mysql_query("INSERT INTO `mlsprofile` VALUES ('$dat','$id','$name','$primary','$secondary','$tertiary','$opt1','$opt2','$target')");
	if($sql)
	{
		$comment=$loginas." has added MLS Profile into the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Profile updated Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"mls.php\";}, 0);
								}
							});
							</script>";
	}
	else
	{
		echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Profile Not updated Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"mls.php\";}, 0);
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
